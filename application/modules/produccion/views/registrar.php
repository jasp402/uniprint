<?php
echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" type="text/css"
      href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

<script type="text/javascript"
        src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?= base_url() ?>assets/js/bootbox.js"></script>
<script src="<?= base_url(); ?>assets/js/views/produccion/registrar.js"></script>

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>
<script>

</script>
<!-- CABECERA -->
<div class="page-header">
    <h1>
        <i class="fa fa-product-hunt grey"></i>
        Prodrucción
        <small>
            <i class="fa fa-angle-double-right"></i>
            Control y Registros material procesado, embalado o empaquetado
        </small>
    </h1>
</div>

<div class="row" style="width: 100%">
    <?php echo form_open('', "id='form' class='form-horizontal' "); ?>
    <div class="form-group has-info">
        <div class="col-sm-6">
            <div class="col-xs-12">
            <span>
                <label for="destino" class="control-label no-padding-right pull-right">Linea de Producción</label>
                <select class="form-control" name="linea" id="id_ubicacion">
                    <?php foreach ($this->CRUD->__getAll('ubicacion', array('tipo' => 'linea')) as $keyList): ?>
                        <option value="<?= $keyList->label;?>-<?= $keyList->nombre; ?>"><?= $keyList->label; ?>
                            -<?= $keyList->nombre; ?></option>
                    <?php endforeach ?>
                </select>
            </span>
            </div>
            <div class="col-xs-6">
                <div class="space-6"></div>
            <span>
                <label for="id_proyecto" class="control-label no-padding-right pull-right">Categoria</label>
                <select class="form-control" id="id_categoria" onchange="loadGrado()">
                    <?php foreach ($this->CRUD->__getAll('categorias', array('id_proyecto' => '1')) as $keyList): ?>
                        <option value="<?= $keyList->id_categoria; ?>">
                            <?= $keyList->nombre; ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </span>
            </div>
            <div class="col-xs-6">
                <div class="space-6"></div>
            <span>
                <label for="grado" class="control-label no-padding-right pull-right">Tipo</label>
                <select class="form-control" id="id_tipo" onchange="loadLibros()">
                    <option value="">
                            Elija Categoria
                        </option>
                </select>
            </span>
            </div>
            <div class="col-xs-12 align-center">
                <div class="space-12"></div>
                                <span class="block input-icon input-icon-right">
                                    <div class="input-daterange input-group form-group">
                                        <input type="number" min="0" name="lote" id="lote" placeholder="Paletas" onchange="totalizar_Produccion()">
                                        <span class="input-group-addon">
                                            <i class="fa fa-close"></i>
                                        </span>
                                         <input type="number" min="0" name="unidades" id="cant_lote" placeholder="Cantidad x Paletas" onchange="totalizar_Produccion()">
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                         <input type="text" name="total" id="total" readonly>
                                    </div>
                                </span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="space-12"></div>
            <div class="col-xs-12">
                <blockquote>
                    <p class="lighter line-height-125">
                        Aqui va el registro del dia anterior y debe indentificar si este dia se ha cargado alguna informacion
                    </p>

                    <small>
                        Un modal
                        <cite title="Source Title">Para los detalles de esta misma info.</cite>
                    </small>
                </blockquote>
            </div>

        </div>
    </div>
    <div class="col-sm-12"></div>
    <div class="col-sm-6">
        <div>
            <h3 class="header smaller lighter blue">
                <i class="fa fa-book" aria-hidden="true"></i>
                Registro de Libros
                <small>(<span id="title_grado"> Segun el grado</span>)</small>
            </h3>
            <table id="simple-table" class="table table-bordered table-striped table-hover small" style="display:none">
                <thead>
                <tr>
                    <th class="center">
                        <!--
                        <label class="pos-rel">
                            <input type="checkbox" class="ace">
                            <span class="lbl"></span>
                        </label>
                        -->
                    </th>
                    <th>Materia</th>
                    <th>Titulo</th>
                    <th>saldo</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div><!-- /.row -->


    </div><!-- /.col -->

    <div class="col-sm-6">

        <h3 class="header smaller lighter green">
            <i class="fa fa-scissors" aria-hidden="true"></i>
            Registro del Material Escolar
        </h3>
        <table id="thead_lote" class="table table-striped table-bordered table-hover small" style="display: none">
            <thead>
            <tr>
                <th style="width:30px!important;">
                    <span href="#" role="button" onclick="AgregarCampos_lote()" style="cursor: pointer">
                        <i class="fa fa-plus blue" aria-hidden="true"></i>
                    </span>
                </th>
                <th>#</th>
                <th>categoria</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Total de Unidades</th>
            </tr>
            </thead>
            <tbody id="campos_lote">
            <!-- // function addfields() // -->
            </tbody>
            <tfoot class="text-mute">
            <th colspan="6" style="width:30px!important;">
                <span id="footRows" role="button" onclick="AgregarCampos_lote()" style="cursor:pointer;">
                    <i class="fa fa-plus blue" aria-hidden="true"></i>
                </span>
            </th>
            </tfoot>
        </table>
    </div><!-- /.col -->

    <div class="col-sm-12">
        <div class="space-6"></div>
        <textarea id="comentario" name="comentario" class="form-control" placeholder="Agregar comentario" style="width: 100%"></textarea>
        <hr>
        <div class="wizard-actions">
            <!-- #section:plugins/fuelux.wizard.buttons -->

            <button class="btn btn-success btn-next" onclick="validar()">
                <i class="ace-icon fa fa-save icon-on-right"></i>
                Guardar
            </button>

            <!-- /section:plugins/fuelux.wizard.buttons -->
        </div>
    </div>
    </form>
</div>

<?php $this->load->view('global_views/footer_dashboard'); ?>
