<?php echo $this->load->view('global_views/header_dashboard'); ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

    <script type="text/javascript" src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
    <script src="<?=base_url()?>assets/js/bootbox.js"></script>
    <script src="<?=base_url();?>assets/js/jquery.gritter.js"></script>
    <script src="<?= base_url(); ?>assets/js/views/produccion/descontar.js"></script>

    </head>
<?php echo $this->load->view('global_views/contenedor'); ?>

    <!-- CABECERA -->
    <div class="page-header">
        <h1>
            <i class="fa fa-product-hunt grey"></i>
            Producción
            <small>
                <i class="fa fa-angle-double-right"></i>
                Descontar lotes
            </small>
        </h1>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div>
                <h3 class="header smaller lighter blue">
                    <i class="fa fa-barcode" aria-hidden="true"></i>
                    Codigo de Barra
                    <small>(Lote)</small>
                </h3>
            </div>
            <div class="clearfix">
                <input name="descontar" id="descontar" type="number" style="width: 555px" autofocus
                       onkeyup="myFunction(this,this.value)" maxlength="5" onfocus="this"/>
            </div>

        </div>
        <div class="col-sm-6">
            <div>
                <h3 class="header smaller lighter green">
                    <i class="fa fa-mail-forward" aria-hidden="true"></i>
                    Ultimo lote Descontado del Stock
                </h3>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover small">
                    <thead class="table-condensed">
                    <tr>
                        <th>codigo</th>
                        <th>N° Doc.</th>
                        <th>Origen</th>
                        <th>tipo</th>
                        <th>producto</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>
        <div class="col-sm-12">
            <div>
                <h3 class="header smaller lighter grey">
                    <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                    Registro de lotes procesados
                </h3>
                <div class="widget-main no-padding">
                <table id="simple-table" class="table table-bordered table-striped table-responsive small">
                    <thead class="thin-border-bottom">
                    <tr>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Producto</th>
                        <th>Imprenta / Proveedor</th>
                        <th>Cant. Entrada</th>
                        <th>Cant. Producción</th>

                        <th width="50%">
                            <i class="ace-icon fa fa-clock-o bigger-110"></i>
                            Estadisticas
                        </th>
                    </tr>
                    </thead>
                    <tbody style="vertical-align: middle">
                    <?php foreach ($getAll->inventario_activo($this->schema['detail']) as  $keyList): ?>
                    <tr>

                        <td>
                            <a href="#"><?=$keyList->categoria?></a>
                        </td>
                        <td width="10%"><?=$keyList->tipo?></td>
                        <td width="15%"><?=$keyList->producto?></td>
                        <td width="20%"><?=$keyList->origen_nombre?></td>
                        <td width="10%"><?=$format_number = number_format($keyList->procesado, 0, ',', '.');?></td>
                        <td width="10%">
                            <?php if($keyList->estado == 'i'): ?>

                            <span class="label label-warning arrowed-in arrowed-right ">
                                <?=$keyList->procesado?>
                            </span>
                        <?php endif; ?>
                            </td>
                        <td>
                            <div class="progress pos-rel" data-percent="66%">
                                <div class="progress-bar" style="width:66%;"></div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>



<?php $this->load->view('global_views/footer_dashboard'); ?>