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
        <i class="fa fa-sliders grey"></i>
        Prodrucción
        <small>
            <i class="fa fa-angle-double-right"></i>
            Control y Registros material procesado, embalado o empaquetado
        </small>
    </h1>
</div>


<div class="row">
    <div class="form-group has-info">
        <div class="col-sm-2">
            <span>
                <label for="destino" class="control-label no-padding-right pull-right">Linea de Producción</label>
                <select class="form-control" name="linea" id="id_ubicacion">
                    <?php foreach ($this->CRUD->__getAll('ubicacion', array('tipo' => 'linea')) as $keyList): ?>
                        <option value="<?= $keyList->id_ubicacion; ?>"><?= $keyList->label; ?>
                            -<?= $keyList->nombre; ?></option>
                    <?php endforeach ?>
                </select>
            </span>
        </div>
        <div class="col-sm-2">
            <span>
                <label for="id_proyecto" class="control-label no-padding-right pull-right">Categoria</label>
                <select class="form-control" name="categorias" id="id_categoria" onchange="loadTipo()">
                    <?php foreach ($this->CRUD->__getAll('categorias', array('id_proyecto' => '1')) as $keyList): ?>
                        <option value="<?= $keyList->id_categoria; ?>">
                            <?= $keyList->nombre; ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </span>
        </div>
        <div class="col-sm-2">
            <span>
                <label for="id_proyecto" class="control-label no-padding-right pull-right">Tipo</label>
                <select class="form-control" name="tipos" id="id_tipo" onchange="loadLibros()">
                    <option value="">
                            Seleccione Categoria
                        </option>
                </select>
            </span>
        </div>
        <div class="col-sm-6">
            <div class="col-xs-12">
                <blockquote>
                    <p class="lighter line-height-125">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>

                    <small>
                        Someone famous
                        <cite title="Source Title">Source Title</cite>
                    </small>
                </blockquote>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div>
            <h3 class="header smaller lighter blue">
                Registro de Libros
                <small>(<span id="title_grado"> Segun el grado</span>)</small>
            </h3>
            <table id="simple-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">
                        <label class="pos-rel">
                            <input type="checkbox" class="ace">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Materia</th>
                    <th>Titulo</th>
                    <th>saldo</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>


                </tbody>
            </table>
        </div><!-- /.row -->


    </div><!-- /.col -->

    <div class="col-sm-6">
        <h3 class="header smaller lighter green">
            Registro del Material Escolar
        </h3>
    </div><!-- /.col -->
</div>

<?php $this->load->view('global_views/footer_dashboard'); ?>
