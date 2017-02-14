<?php echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

<script type="text/javascript" src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?=base_url()?>assets/js/bootbox.js"></script>
<script src="<?= base_url(); ?>assets/js/views/produccion/lineas.js"></script>

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>

<!-- CABECERA -->
<div class="page-header">
    <h1>
        <i class="fa fa-product-hunt grey"></i>
        Producción
        <small>
            <i class="fa fa-angle-double-right"></i>
            Gestionar responsables por lineas de embalaje
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-12">

        <div class="infobox infobox-red">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-random"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?=count($this->CRUD->__getAll($this->schema['table'],$this->schema['options']))?></span>
                <div class="infobox-content">
                    <a href="#modal-table_categoria" role="button" data-toggle="modal"
                       onclick="javascript:div_form_create('Agregar nueva Linea');">
                        <i class="ace-icon fa fa-external-link"></i>
                        Registar Linea
                    </a>
                </div>
            </div>
        </div>
        <div class="space-6"></div>
        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table_3" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th width="15%" style="width: 20%!important;">Linea</th>
                    <th width="15%" style="width: 20%!important;">Responsable</th>
                    <th>Cedula</th>
                    <th>funciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-table_categoria" class="modal fade" tabindex="-3">
    <div class="modal-dialog">
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

                    <div class="col-sm-12">
                        <?php echo form_open('', "id='form' class='form-horizontal' "); ?>
                        <input type="hidden"  name="id_ubicacion" id="id_ubicacion">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Linea: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="label" id="label" placeholder="L1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Responsable: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="nombre" id="nombre" placeholder="nombre & Apellido">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Cedula: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="number" name="telefono" id="telefono" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
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
<?php $this->load->view('global_views/footer_dashboard'); ?>
