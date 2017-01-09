<?php echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/datepicker.css"/>

<script type="text/javascript" src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
<script type="text/javascript" src='<?= base_url(); ?>assets/js/select2.js'></script>
<script type="text/javascript" src='<?= base_url(); ?>assets/js/fuelux/fuelux.wizard.js'></script>
<script type="text/javascript" src='<?= base_url(); ?>assets/js/jquery.validate.js'></script>
<script type="text/javascript" src='<?= base_url(); ?>assets/js/additional-methods.js'></script>
<script type="text/javascript" src='<?= base_url(); ?>assets/js/jquery.maskedinput.js'></script>
<!--// DataTables //-->
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?=base_url()?>assets/js/bootbox.js"></script>
<!--// DatePicker //-->
<script src="<?= base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?= base_url(); ?>assets/js/date-time/bootstrap-datepicker.es.js"></script>
<script src="<?= base_url(); ?>assets/js/ace/elements.aside.js"></script>
<script src="<?= base_url(); ?>assets/js/views/stock/traslados.js"></script>

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>


<!--// (Modal) Editar        //-->
<div id="modal-table" class="modal fade" tabindex="-1">
    <div class="modal-dialog" style="width:80% !important;">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            onclick="limpiarTabla()">
                        <span class="white">&times;</span>
                    </button>
                    <i class="fa fa-exclamation-triangle fa-3" aria-hidden="true"></i>
                    Error - Nota de Traslado <b>[<span id="modal-doc"></span>]</b>  registrada
                </div>
            </div>

            <div class="modal-body no-padding">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>cod</th>
                        <th>Fecha</th>
                        <th>Origen</th>
                        <th>Documento</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Producto</th>
                        <th>Paleta</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
<tr></tr>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
<div>
    Se Recomienda verificar la información -
</div>
            <div class="modal-footer no-margin-top">
                <button class="btn btn-sm btn-primary pull-right" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Ignorar
                </button>
                <button class="btn btn-sm btn-warning pull-right" data-dismiss="modal" onclick="elimDoc()">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    Cambiar
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<!--//  Titulo Cabecera     //-->
<div class="page-header">
    <h1>
        <i class="fa fa-cubes grey"></i>
        Stock
        <small>
            <i class="fa fa-angle-double-right"></i>
            Traslado de Material (Almacenes Locales)
        </small>
    </h1>
</div>


<!--//  Ultimos registros   //-->
<div class="row">
    <div class="col-sm-12">
        <div class="widget-box collapsed">
            <div class="widget-header widget-header-blue widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-random blue"></i>
                    Ultima Traslado Registrada
                </h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-down"></i>
                    </a>
                </div>
            </div>
            <?php if(count($getAll)>0): ?>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <div class="space-12"></div>

                        <div class="profile-user-info profile-user-info-striped">
                            <div class="col-sm-8">
                                <div class="profile-info-row" >
                                    <div class="profile-info-name" style="width:150px"> Nota de Entrega </div>

                                    <div class="profile-info-value">
                                        <span class="editable"><?= $getAll->getAllLast_traslado()->documento; ?></span>
                                    </div>
                                    <div class="profile-info-name" style="width:150px"> Codigo Inventario </div>

                                    <div class="profile-info-value">
                                        <span class="editable"><?= $getAll->getAllLast_traslado()->cod_traslado; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Origen </div>

                                    <div class="profile-info-value">
                                        <i class="fa fa-map-marker light-orange bigger-110"></i>
                                        <span class="editable" id="country"><?=$getAll->getAllLast_traslado()->nombre_origen; ?></span>
                                    </div>
                                    <div class="profile-info-name"> Destino </div>

                                    <div class="profile-info-value">
                                        <i class="fa fa-map-marker light-green bigger-110"></i>
                                        <span class="editable" id="country"><?= $getAll->getAllLast_traslado()->nombre_destino; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Chofer </div>

                                    <div class="profile-info-value">
                                    <span class="editable" id="age">
                                      <?= $getAll->getAllLast_traslado()->chofer; ?> -
                                        <?= number_format($getAll->getAllLast_traslado()->cedula,0,',','.'); ?>
                                    </span>
                                    </div>
                                    <div class="profile-info-name"> Proyecto </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="login"><?=$getAll->getAllLast_traslado()->proyecto?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Vehiculo </div>

                                    <div class="profile-info-value">
                                    <span class="editable" id="age">
                                        <?= $getAll->getAllLast_traslado()->marca; ?>
                                        <?= $getAll->getAllLast_traslado()->modelo;?> -
                                        <?= $getAll->getAllLast_traslado()->placa; ?>
                                    </span>
                                    </div>
                                    <div class="profile-info-name"> Responsable </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="login"><?=$getAll->getAllLast_traslado()->responsable?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Fecha </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="signup"><?=$getAll->getAllLast_traslado()->fecha?></span>
                                    </div>
                                    <div class="profile-info-name"> Registro </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="login"><?=$getAll->getAllLast_traslado()->registro?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> Cant. Paletas </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="login"><?= $getAll->sumarPaletas($getAll->getAllLast_traslado()->cod_traslado)[0]->suma ?></span>
                                    </div>
                                    <div class="profile-info-name"> Total </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="about"><?=  number_format($getAll->sumarTotal($getAll->getAllLast_traslado()->cod_traslado)[0]->suma,0,',','.'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="widget-box widget-color-orange">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">Nota de Acarreo</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main align-center">
                                            <a href="#" class="light-orange" onclick="bootbox.alert('<b>Lo Sentimos!</b> Esta opcion aun no esta disponible \n Continuamos trabajando en ello...')"><i class="fa fa-fw fa-file-o bigger-300"></i>
                                                <h6>Generar Habladores</h6>
                                            </a>
                                        </div>

                                        <div>
                                            <a href="#" onclick="bootbox.alert('<b>Lo Sentimos!</b> Esta opcion aun no esta disponible \n Continuamos trabajando en ello...')" class="btn btn-block btn-warning no-border">
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
                                        <h5 class="widget-title bigger lighter">Hablador</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main align-center">
                                            <a href="#" onclick="bootbox.alert('<b>Lo Sentimos!</b> Esta opcion aun no esta disponible \n Continuamos trabajando en ello...')"><i class="fa fa-fw fa-file-o bigger-300"></i>
                                                <h6>Generar Habladores</h6>
                                            </a>
                                        </div>

                                        <div>
                                            <a href="#" onclick="bootbox.alert('<b>Lo Sentimos!</b> Esta opcion aun no esta disponible \n Continuamos trabajando en ello...')" class="btn btn-block btn-primary no-border">
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

<!--//  Procesar entrada    //-->
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <h4 class="widget-title lighter">
            <i class="ace-icon fa fa-terminal"></i>
            Procesar Traslado
        </h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <!-- #section:plugins/fuelux.wizard -->
            <div id="fuelux-wizard-container">
                <div>
                    <!-- #section:plugins/fuelux.wizard.steps -->
                    <ul class="steps">
                        <li data-step="1" class="active">
                            <span class="step">
                                <i class="ace-icon fa fa-truck"></i>
                            </span>
                            <span class="title">Origen del Producto</span>
                        </li>

                        <li data-step="2">
                            <span class="step">
                                 <i class="ace-icon fa fa-cubes"></i>
                            </span>
                            <span class="title">Registrar Producto</span>
                        </li>
                        <li data-step="4">
                            <span class="step">
                                <i class="ace-icon fa fa-file-text-o"></i>
                            </span>
                            <span class="title">Verificar Datos</span>
                        </li>
                    </ul>
                    <!-- /section:plugins/fuelux.wizard.steps -->
                </div>
                <hr />
                <?php echo form_open('', "id='form' class='form-horizontal' "); ?>
                <div class="step-content pos-rel">
                    <!-- #section:data-step="1" -->
                    <div class="step-pane active" data-step="1">
                        <h3 class="lighter block green">Detalle del Traslado</h3>
                        <div class="form-group has-info">
                            <label class="col-sm-3 control-label no-padding-right">Origen</label>
                            <div class="col-sm-5">
                                <span class="block input-icon input-icon-right">
                                    <div class="col-sm-12 input-daterange input-group">
                                        <select class="form-control" id="origen" name="origen" onchange="SetDestino(this.value)">
                                            <option value="">--Seleccione Origen--</option>
                                            <?php foreach ($this->CRUD->__getAll('ubicacion',array('tipo'=>'interno')) as $keyList): ?>
                                                <option value="<?= $keyList->id_ubicacion; ?>"><?= $keyList->nombre; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <span class="input-group-addon">
                                            <i class="fa fa-exchange"></i>
                                        </span>
                                        <select class="form-control" name="destino" id="destino">
                                            <option value="">--seleccione Destino--</option>
                                        </select>
                                    </div>
                                </span>
                            </div>
                            <label class="control-label no-padding-left">Destino</label>
                        </div>


                        <div class="form-group has-info">
                            <label for="inputWarning" class="col-xs-12 col-sm-3 control-label no-padding-right">Datos del Chofer</label>

                            <div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<select class="form-control" name="id_chofer" id="id_chofer"
                                                        data-live-search="true">
                                                    <?php foreach ($this->CRUD->__getAll('choferes') as $keyList): ?>
                                                        <option value="<?= $keyList->id_chofer; ?>"><?= number_format($keyList->cedula,0,',','.'); ?> - <?= $keyList->nombre_apellido; ?></option>
                                                    <?php endforeach ?>
                                                </select>
											</span>
                            </div>
                            <a href="#" class="btn btn-white btn-info" data-rel="popover"  data-placement="right" title="<i class='ace-icon fa fa-exclamation-triangle orange'></i> Datos No Encontrado" data-content="En caso de no estar registrado los datos del chofer. utilice la opción <a href=../parametros/choferes>Agregar nuevo Chofer</a>">
                                <i class="ace-icon fa fa-address-card-o"></i>
                            </a>
                        </div>

                        <div class="form-group has-info">
                            <label for="inputSuccess" class="col-xs-12 col-sm-3 control-label no-padding-right">Datos del Vehiculo</label>
                            <div class="col-xs-12 col-sm-5">
											<span class="block input-icon input-icon-right">
												<select class="form-control" name="id_vehiculo" id="id_vehiculo"
                                                        data-live-search="true">
                                                    <?php foreach ($this->CRUD->__getAll('vehiculos') as $keyList): ?>
                                                        <option value="<?= $keyList->id_vehiculo; ?>"><?= $keyList->placa;?> - <?= $keyList->marca;?> <?= $keyList->modelo;?></option>
                                                    <?php endforeach ?>
                                                </select>
											</span>
                            </div>
                            <a href="#" class="btn btn-white btn-info" data-rel="popover"  data-placement="right" title="<i class='ace-icon fa fa-exclamation-triangle orange'></i> Datos No Encontrado" data-content="En caso de no estar registrado los datos del Vehiculo. utilice la opción <a href=../parametros/vehiculos>Agregar nuevo Vehiculo</a>">
                                <i class="ace-icon fa fa-truck"></i>
                            </a>
                        </div>
                    </div>
                    <!-- #section:data-step="2" -->
                    <div class="step-pane" data-step="2">
                        <h3 class="lighter block green">Datos del Producto</h3>
                        <div class="form-group has-success">
                            <div class="col-sm-1">

                                <label class="col-sm-12 control-label no-padding-right inline">
                                    <small>Granel</small>
                                    <a class="info open-event" href="#" title="¿Productos a granel?" style="text-decoration:none">
                                        <i class="ace-icon fa fa-exclamation-circle"></i>
                                    </a>
                                    <div class="space-4"></div>
                                    <input id="id-pills-stacked-granel" type="checkbox" value="1" class="ace ace-switch ace-switch-5" onclick="granel()">
                                    <span class="lbl middle"></span>
                                </label>
                            </div>

                            <div class="col-sm-4">
                                    <span>
                                        <label for="inputWarning" class="control-label no-padding-right pull-right">Proyecto</label>
												  <select class="form-control" name="id_proyecto" id="id_proyecto"  data-live-search="true" onchange="loadAllSelect()">
                                        <?php foreach ($this->CRUD->__getAll('proyecto') as $keyList): ?>
                                            <option
                                                value="<?= $keyList->id_proyecto; ?>"><?= $keyList->nombre; ?></option>
                                        <?php endforeach ?>
                                    </select>
											</span>
                            </div>
                            <div class="col-sm-5">
                                    <span>
                                        <label for="inputWarning" class="control-label no-padding-right pull-right">N° Nota de Entrega</label>
												<input type="textbox" name="documento" id="documento" class="form-control">
											</span>
                            </div>
                            <div class="col-sm-2">
                                    <span>
                                        <label for="inputWarning" class="control-label no-padding-right pull-right">Fecha del Documento</label>
												<input type="textbox" dataformatas="" name="fecha" id="fecha" class="form-control" placeholder="dd/mm/yyyy">
                                    </span>
                            </div>
                        </div>
                        <table id="thead_lote" class="table table-striped table-bordered table-hover">
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
                                <th>Disponible</th>
                                <th>Cant. paletas</th>
                                <th>Unidades x Paletas</th>
                                <th>Total de Unidades</th>
                            </tr>
                            </thead>
                            <tbody id="campos_lote">
                            <!-- // function addfields() // -->
                            </tbody>
                            <tfoot class="text-mute">
                            <th colspan="8" style="width:30px!important;">
                                <span id="footRows" role="button" onclick="AgregarCampos_lote()" style="cursor:pointer;">
                                    <i class="fa fa-plus blue" aria-hidden="true"></i>
                                </span>
                            </th>
                            <th id="table_lote_total">Total de Unidades</th>
                            </tfoot>
                        </table>
                        <table id="thead_serie" class="table table-striped table-bordered table-hover" style="display: none;">
                            <thead>
                            <tr>
                                <th style="width:30px!important;">
                                    <span role="link" onclick="AgregarCampos_serie()" style="cursor: pointer">
                                        <i class="fa fa-plus blue" aria-hidden="true"></i>
                                    </span>
                                </th>
                                <th>#</th>
                                <th>categoria</th>
                                <th>Tipo</th>
                                <th width="40%">Producto</th>
                                <th>Disponible</th>
                                <th width="20%">Total de Unidades</th>
                            </tr>
                            </thead>
                            <tbody id="campos_serie">
                            <!-- // function addfields() // -->
                            </tbody>
                            <tfoot class="text-mute">
                            <th colspan="6" style="width:30px!important;">
                                <span id="footRows" role="button" onclick="AgregarCampos_serie()" style="cursor:pointer;">
                                    <i class="fa fa-plus blue" aria-hidden="true"></i>
                                </span>
                            </th>
                            <th id="table_lote_total_serie">Total de Unidades</th>
                            </tfoot>
                        </table>
                        <textarea id="comentario" name="comentario" class="form-control" placeholder="Agregar comentario" style="width: 100%"></textarea>
                    </div>
                    <!-- #section:data-step="4" -->
                    <div class="step-pane" data-step="4">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <!-- #section:pages/invoice -->
                                <div class="widget-box transparent">
                                    <div class="widget-header widget-header-large">
                                        <h3 class="widget-title grey lighter">
                                            <i class="
                                                 fa fa-leaf green"></i>
                                            Detalle de Recepción
                                        </h3>

                                        <!-- #section:pages/invoice.info -->
                                        <div class="widget-toolbar no-border invoice-info">
                                            <span class="invoice-info-label">N° Nota:</span>
                                            <span class="red bolder" id="invoice_documento"></span>

                                            <br />
                                            <span class="invoice-info-label">Date:</span>
                                            <span class="blue" id="invoice_fecha"></span>
                                        </div>

                                        <div class="widget-toolbar hidden-480">
                                            <a href="#">
                                                <i class="ace-icon fa fa-print"></i>
                                            </a>
                                        </div>

                                        <!-- /section:pages/invoice.info -->
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main padding-24">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                                            <b>Información de Origen</b>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <ul class="list-unstyled spaced">
                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i><span class="bolder">Origen</span>, <spam id="invoice_origenSelect"></spam>
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i><span class="bolder">Chofer</span>, <span id="invoice_chofer"></span>
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right blue"></i><span class="bolder">Vehiculo</span>, <span id="invoice_vehiculo"></span>
                                                            </li>

                                                            <li class="divider"></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- /.col -->

                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <div class="col-xs-11 label label-lg label-success arrowed-in arrowed-right">
                                                            <b>Información de Destino</b>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <ul class="list-unstyled  spaced">
                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><b>Destino</b>,
                                                                <spam id="invoice_destino"></spam>
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><b>Proyecto</b>,
                                                                <spam id="invoice_proyecto"></spam>
                                                            </li>

                                                            <li>
                                                                <i class="ace-icon fa fa-caret-right green"></i><b>Responsable</b>,
                                                                <?= $this->auditoria['log_user']; ?>
                                                            </li>

                                                            <li class="divider"></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->

                                            <div class="space"></div>

                                            <div>
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="center">#</th>
                                                        <th>categoria</th>
                                                        <th>Tipo</th>
                                                        <th>Producto</th>
                                                        <th>Cant. paletas</th>
                                                        <th>Unidades x Paletas</th>
                                                        <th>Total de Unidades</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody id="invoice_result">
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="hr hr8 hr-double hr-dotted"></div>

                                            <div class="row">
                                                <div class="col-sm-5 pull-right">
                                                    <h4 class="pull-right">
                                                        Total :
                                                        <span class="red" id="invoice_total"></span>
                                                    </h4>
                                                </div>
                                                <div class="col-sm-7 pull-left"> Extra Information </div>
                                            </div>

                                            <div class="space-6"></div>
                                            <div class="well" id="invoice_comentario">
                                                <i class="ace-icon fafa-info-circle grey bigger-110"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /section:pages/invoice -->
                            </div>
                        </div>

                    </div>
                </div>
                </form>
                <!-- #section:plugins/fuelux.wizard.container -->

                <!-- /section:plugins/fuelux.wizard.container -->
            </div>

            <hr />
            <div class="wizard-actions">
                <!-- #section:plugins/fuelux.wizard.buttons -->
                <button class="btn btn-prev">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    Prev
                </button>

                <button class="btn btn-success btn-next" data-last="Finish">
                    Next
                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                </button>

                <!-- /section:plugins/fuelux.wizard.buttons -->
            </div>

            <!-- /section:plugins/fuelux.wizard -->
        </div><!-- /.widget-main -->
    </div><!-- /.widget-body -->
</div>


<?php $this->load->view('global_views/footer_dashboard'); ?>
