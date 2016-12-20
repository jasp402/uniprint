<?php echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" type="text/css"
      href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

<script type="text/javascript"
        src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?= base_url() ?>assets/js/bootbox.js"></script>
<script src="<?= base_url() ?>assets/js/fuelux/fuelux.tree.js"></script>
<script src="<?= base_url(); ?>assets/js/views/inventario.js"></script>

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>

<!-- CABECERA -->
<div class="page-header">
    <h1>
        <i class="fa fa-cubes grey"></i>
        Stock
        <small>
            <i class="fa fa-angle-double-right"></i>
            Inventario de Movimientos de Productos
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="widget-box">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title lighter" id="widget-title">
                    <i class="ace-icon fa fa-paperclip orange"></i>
                    Ultima Entrada Registrada
                </h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <?php if(count($getAll)>0): ?>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div class="space-12"></div>

                        <div id="_load"></div>
                        <div class="profile-user-info profile-user-info-striped" id="_profile">
                            <div class="col-sm-8">
                                <div class="profile-info-row" >
                                    <div class="profile-info-name" style="width:150px"> Nota de Entrega </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_documento"><?= $this->models->getAllLast()[0]->documento; ?></span>
                                    </div>
                                    <div class="profile-info-name" style="width:150px"> Codigo Inventario </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_cod_inventario"><?= $this->models->getAllLast()[0]->cod_inventario; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Origen </div>

                                    <div class="profile-info-value">
                                        <i class="fa fa-map-marker light-orange bigger-110"></i>
                                        <span class="editable" id="_origen"><?= $getAllUbicacion[($this->models->getAllLast()[0]->origen)-1]->nombre; ?></span>
                                    </div>
                                    <div class="profile-info-name"> Destino </div>

                                    <div class="profile-info-value">
                                        <i class="fa fa-map-marker light-green bigger-110"></i>
                                        <span class="editable" id="_destino"><?= $getAllUbicacion[($this->models->getAllLast()[0]->destino)-1]->nombre; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Chofer </div>

                                    <div class="profile-info-value">
                                    <span class="editable" id="_chofer">
                                        <?= $getAllChoferes->getAllById($this->models->getAllLast()[0]->id_chofer)[0]->nombre_apellido; ?> -
                                        <?= number_format($getAllChoferes->getAllById($this->models->getAllLast()[0]->id_chofer)[0]->cedula,0,',','.'); ?>
                                    </span>
                                    </div>
                                    <div class="profile-info-name"> Proyecto </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_proyecto"><?=$getAllProductos[$this->models->getAllLast()[0]->id_producto]->proyecto?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Vehiculo </div>

                                    <div class="profile-info-value">
                                    <span class="editable" id="_vehiculo">
                                        <?= $getAllVehiculos->getAllById($this->models->getAllLast()[0]->id_vehiculo)[0]->marca; ?>
                                        <?= $getAllVehiculos->getAllById($this->models->getAllLast()[0]->id_vehiculo)[0]->modelo;?> -
                                        <?= $getAllVehiculos->getAllById($this->models->getAllLast()[0]->id_vehiculo)[0]->placa; ?>
                                    </span>
                                    </div>
                                    <div class="profile-info-name"> Responsable </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_loguser"><?=$this->models->getAllLast()[0]->log_user?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Fecha </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_fecha"><?=$this->models->getAllLast()[0]->fecha?></span>
                                    </div>
                                    <div class="profile-info-name"> Registro </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_logdate"><?=$this->models->getAllLast()[0]->log_date?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Cant. Paletas </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_pltas"><?= $this->models->sumarPaletas($this->models->getAllLast()[0]->cod_inventario)[0]->suma ?></span>
                                    </div>
                                    <div class="profile-info-name"> Total </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="_total"><?=  number_format($this->models->sumarTotal($this->models->getAllLast()[0]->cod_inventario)[0]->suma,0,',','.'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="widget-box widget-color-green">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">Etiquetas</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main align-center">
                                            <a href="../pdfs/pdfs?labelBookIn=<?= $this->models->getAllLast()[0]->cod_inventario; ?>" target="_blank" id="_etiqueta"><i class="fa fa-barcode bigger-300"></i>
                                                <h6>Generar Etiqueta</h6>
                                            </a>
                                        </div>

                                        <div>
                                            <a href="../pdfs/pdfs?labelBookIn=<?= $this->models->getAllLast()[0]->cod_inventario; ?>" target="_blank" id="_etiquetaBtn" class="btn btn-block btn-success">
                                                <i class="ace-icon fa fa-print bigger-110"></i>
                                                <span>Imprimir</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="widget-box widget-color-blue">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">Habladores</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main align-center">
                                            <a href="#" onclick="bootbox.alert('<b>Lo Sentimos!</b> Esta opcion aun no esta disponible \n Continuamos trabajando en ello...')"><i class="fa fa-fw fa-file-o bigger-300"></i>
                                                <h6>Generar Habladores</h6>
                                            </a>
                                        </div>

                                        <div>
                                            <a href="#" onclick="bootbox.alert('<b>Lo Sentimos!</b> Esta opcion aun no esta disponible \n Continuamos trabajando en ello...')" class="btn btn-block btn-primary">
                                                <i class="ace-icon fa fa-print bigger-110"></i>
                                                <span>Imprimir</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-12"><br></div>
                    </div><!-- /.widget-main -->
                </div><!-- /.widget-body -->
            <?php endif; ?>
        </div><!-- /.widget-box -->
    </div><!-- /.col -->
</div>
<div class="row">
    <div class="col-sm-12 align-left">
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table_3" class="table table-bordered table-hover table-responsive">
                <thead>
                <tr>
                    <th class="align-middle align-center">#</th>
                    <th class="align-middle align-center">fecha</th>
                    <th class="align-middle align-center">origen</th>
                    <th class="align-middle align-center">documento</th>
                    <th class="align-middle align-center">proyecto</th>
                    <th class="align-middle align-center">categoria</th>
                    <th class="align-middle align-center">tipo</th>
                    <th class="align-middle align-center">producto</th>
                    <th class="align-middle align-center">Pltas</th>
                    <th class="align-middle align-center">cant. x Pltas</th>
                    <th class="align-middle align-center">total </th>
                    <th class="align-middle align-center"><i class="ace-icon fa fa-user-o bigger-110"></i> Usuario</th>
                    <th class="align-middle align-center"><i class="ace-icon fa fa-calendar-check-o bigger-110"></i> Registro</th>
                    <th class="align-middle align-center">Funciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-table" class="modal fade" tabindex="-3">
    <div class="modal-dialog" style="width: 80%!important;">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="white">&times;</span>
                    </button>
                    <span class="bigger-140" id="titulo_div"></span>
                </div>
            </div>

            <div class="modal-body no-padding">
                <!-- FORMULARIO DE CRUD -->
                <div class="row" id="form_categorias">
                    <div id="mensaje_crud_apoderado"></div>
                    <div class="hr hr-18 dotted"></div>
                    <?php echo form_open('', "id='form' class='form-horizontal' "); ?>
                    <input type="hidden" name="id_inventario" id="id_inventario">
                    <input type="hidden" name="cod_inventario" id="cod_inventario">
                    <input type="hidden" name="id_producto" id="id_producto">
                    <div class="col-sm-6">
                        <div class="col-lg-offset-1 col-sm-3">
                            <div class=" form-group">
                                <label class="control-label no-padding-right">Pltas: </label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="number" name="cant_lote" id="cant_lote">
                                    </div>

                            </div>
                        </div>
                        <div class="col-lg-offset-1 col-sm-3">
                            <div class=" form-group">
                                <label class="control-label no-padding-right">Cant. x Pltas: </label>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                    <input class="form-control" type="number" name="cant_unidades" id="cant_unidades">
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-offset-1 col-sm-3">
                            <div class=" form-group">
                                <label class="control-label no-padding-right">Total Unidades: </label>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                    <input class="form-control" type="number" name="total" id="total">
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer no-margin-top">
                <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Close
                </button>
                <div style="display: none;" id="div_btn_edit">
                    <button class="btn btn-sm btn-warning" id="btn_edit" onclick="javascript:Edit();">
                        <i class="fa fa-pencil bigger-120"></i>
                        Editar
                    </button>
                </div>
                <div style="display: none;" id="div_btn_save">
                    <button class="btn btn-sm btn-primary" id="btn_save" onclick="javascript:Save();">
                        <i class="fa fa-save bigger-120"></i>
                        Registrar
                    </button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?=base_url();?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
</script>

<?php $this->load->view('global_views/footer_dashboard'); ?>
