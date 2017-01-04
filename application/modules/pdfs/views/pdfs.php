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
<!-- //Codigo de Barra //-->
<script src="<?= base_url(); ?>assets/js/jquery-barcode-last.min.js"></script>
<style>
    @media all {
        div.saltopaginar{
            display: none;
        }
    }
    @media print{
        div.saltopagina{
            display:block;
           /* page-break-before:always;*/
            page-break-before: always;
        }
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
    .bcTarget{
        overflow: hidden!important;
        margin-left: -15px!important;
        /*margin-bottom: -20px!important;*/
        height: 82px!important;
        margin-top: -5px!important;

    }
    div.bcTarget > div {
        font-size: 18px !important;
        overflow: hidden!important;
        height: 60px!important;
        margin-top: 0px!important;
        margin-bottom: -1px!important;
    }
    .counttarget{
        margin-top: 10px!important;
    font-family: Impact;
    color: #000;
    font-size: 62px
}
</style>

<?php
//ETIQUETAS DE *LIBROS*// //ToDo - Intentare que soporte todos los productos
if (isset($_GET['labelBookIn'])):
    $dataLabel = $this->models->LabelFull($_GET['labelBookIn']);
    $c = count($dataLabel);
    for($i=0; $i<$c; $i++):
    ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#bcTarget<?=$i; ?>").barcode({code: "<?= str_pad($dataLabel[$i]->codigo_barra, 5, "0", STR_PAD_LEFT); ?>", crc:false},"code128",{barWidth:2, barHeight:10}); });
        </script>
<body class="no-skin" style="overflow-x: hidden">


                    <div class="row">
                        <div class="center col-sm-offset-2">
                        <div class=" col-xs-12 widget-header well" style="width:377px!important; height: 350px !important;">

                            <div class="clearfix">
                                <div class="grid3">
                                    <span class="grey">
                                        <i class="ace-icon fa fa-file-o fa-2x "></i>
                                        &nbsp;N° Doc.
                                    </span>
                                    <h6 class="bigger"><b><?= $dataLabel[$i]->nota_entrega?></b></h6>
                                </div>

                                <div class="grid3">
                                    <span class="grey">
                                        <i class="ace-icon fa fa-calendar fa-2x"></i>
                                        &nbsp Fecha
                                    </span>
                                    <h6 class="bigger"><b><?=$dataLabel[$i]->fecha;?></b></h6>
                                </div>
                                <div class="grid3">
                                    <span class="grey">
                                        <i class="ace-icon fa fa-cubes fa-2x"></i>
                                        &nbsp; Lotes
                                    </span>
                                    <h6 class="bigger"><b><?=($i+1).'/'.$c;?></b></h6>
                                </div>
                            </div>
                            <br>
                            <div class="col-xs-6 col-sm-6">
                                <div class="bcTarget" id="bcTarget<?php echo $i; ?>"></div>
                            </div>
                            <div class="col-xs-5 col-sm-5" style="float: left">
                                <h1 class="counttarget"><?=number_format ($dataLabel[$i]->cantidad,0,',','.');?></h1>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="col-xs-12 col-sm-12 pull-left align-left">
                                <ul class="list-unstyled spaced inline bigger-110 margin-15">
                                    <?php if(strlen($dataLabel[$i]->producto)>=24): ?>
                                    <li><h1 style="font-family: Impact; font-size: 28px;margin-top: -15px"><?=strtoupper($dataLabel[$i]->producto);?></h1>
                                    </li>
                                    <?php else: ?>
                                    <li><h1 style="font-family: Impact; font-size: 36px;margin-top: -15px"><?=strtoupper($dataLabel[$i]->producto);?></h1>
                                    </li>
                                    <?php endif;?>
                                    <li>
                                        <h1 style="font-family: Impact; font-size: 32px; margin-top: -5px"><?=$dataLabel[$i]->tipo;?></h1>
                                    </li>
                                </ul>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a href="#faq-1-1" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
                                            <i class="ace-icon fa fa-chevron-left pull-right"></i>
                                            <i class="ace-icon fa fa-map-marker bigger-130"></i>
                                            &nbsp; <?=$dataLabel[$i]->origen;?>
                                        </a>
                                    </div>
                                    <div class="panel-heading">
                                        <a href="#faq-1-1" data-parent="#faq-list-1" data-toggle="collapse" class="accordion-toggle collapsed">
                                            <i class="ace-icon fa fa-chevron-left pull-right"></i>
                                            <i class="ace-icon fa fa-address-card-o bigger-130"></i>
                                            &nbsp; <?=$dataLabel[$i]->log_user.' - '.$dataLabel[$i]->log_date;?>
                                        </a>
                                    </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        <div class="saltopagina"></div>
</body>

    <?php
    endfor;
    endif;
?>
