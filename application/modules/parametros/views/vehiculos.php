<?php echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

<script type="text/javascript" src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?=base_url()?>assets/js/bootbox.js"></script>
<script src="<?= base_url(); ?>assets/js/views/parametros/vehiculos.js"></script>

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>

<!-- CABECERA -->
<div class="page-header">
    <h1>
        <i class="fa fa-sliders grey"></i>
        Parametros
        <small>
            <i class="fa fa-angle-double-right"></i>
            Gestionar Vehiculos
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="widget-box transparent">
        <div class="widget-header widget-header-small header-color-blue2">
            <h4 class="widget-title smaller">
                <i class="ace-icon fa fa-gears bigger-120"></i>
                Opciones
            </h4>
        </div>
            <div class="space-4"></div>
        <div class="infobox infobox-blue padding-16">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-truck"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?=count($getAll->getAll_vehiculos())?></span>
                <div class="infobox-content">
                    <a href="#modal-table_categoria" role="button" data-toggle="modal"
                       onclick="javascript:div_form_create('Agregar Vehiculo');">
                        <i class="ace-icon fa fa-external-link"></i>
                        Registrar Vehiculo
                    </a>
                </div>
            </div>
        </div>
            <div class="space-12"></div>
            <div class="space-12"></div>
            <div class="hr hr-32"></div>
            </div>
    </div>

    <div class="col-sm-9">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-small header-color-blue2">
                <h4 class="widget-title smaller">
                    <i class="ace-icon fa fa-info-circle bigger-120"></i>
                    Estadisticas de Registros
                </h4>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-16">
                    <div class="clearfix">
                        <div class="grid3 center">
                            <span class="badge badge-success" style="position: ABSOLUTE; z-index:999"><?=$getAll->graphic_vehiculos()['count_success']?></span>
                            <div class="center easy-pie-chart percentage" data-percent=" <?=$getAll->graphic_vehiculos()['success']?>" data-color="#59A84B" style="height: 72px; width: 72px; line-height: 71px; color: rgb(89, 168, 75);">
                                <span class="percent"> <?=$getAll->graphic_vehiculos()['success'] ?></span>%
                                <canvas height="72" width="72"></canvas></div>

                            <div class="space-2"></div>
                            Registros Aceptables
                            <a class="blue open-event" href="#" title="(Marca, modelo, Tipo, color y placa)">
                                <i class="ace-icon fa fa-exclamation-circle"></i>
                            </a>
                        </div>

                        <div class="grid3 center">
                            <!-- #section:plugins/charts.easypiechart -->
                            <span class="badge badge-info" style="position: ABSOLUTE; z-index:999"><?=$getAll->graphic_vehiculos()['count_regular']?></span>
                            <div class="easy-pie-chart percentage" data-percent="<?=$getAll->graphic_vehiculos()['regular']?>" data-color="#6BA2CA" style="height: 72px; width: 72px; line-height: 71px; color: rgb(107, 162, 202);">
                                <span class="percent"><?=$getAll->graphic_vehiculos()['regular']?></span>%
                                <canvas height="72" width="72"></canvas></div>

                            <!-- /section:plugins/charts.easypiechart -->
                            <div class="space-2"></div>
                            Registros Parciales
                            <a class="blue open-event" href="#" title="(Marca y placa)">
                                <i class="ace-icon fa fa-exclamation-circle"></i>
                            </a>
                        </div>

                        <div class="grid3 center">
                            <span class="badge badge-danger" style="position: ABSOLUTE; z-index:999"><?=$getAll->graphic_vehiculos()['count_fail']?></span>
                            <div class="center easy-pie-chart percentage" data-percent="<?=$getAll->graphic_vehiculos()['fail']?>" data-color="#CA5952" style="height: 72px; width: 72px; line-height: 71px; color: rgb(149, 133, 191);">
                               <span class="percent"><?=$getAll->graphic_vehiculos()['fail']?></span>%
                                <canvas height="72" width="72"></canvas></div>
                            <div class="space-2"></div>
                            Registros Incompletos
                            <a class="blue open-event" href="#" title="(Placa)">
                                <i class="ace-icon fa fa-exclamation-circle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="hr hr-16"></div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">


        <div class="space-6"></div>

        <div class="clearfix">
            <div class="pull-right tableTools-container"></div>
        </div>
        <div>
            <table id="dynamic-table_3" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Placa</th>
                    <th>Placa Batea</th>
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
                        <input type="hidden"  name="<?=$this->schema['pri_key']?>" id="<?=$this->schema['pri_key']?>">
                        <div class="col-sm-12">

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Marca: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="marca" id="marca" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Modelo: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="modelo" id="modelo" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Tipo: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <select name="tipo" id="tipo" class="form-control">
                                            <option value="">--Seleccione--</option>
                                            <option value="350">Camión 350</option>
                                            <option value="600">Camión 600</option>
                                            <option value="750">Camión 750</option>
                                            <option value="NPR">NPR</option>
                                            <option value="800">Camión 800</option>
                                            <option value="800">Camión 800</option>
                                            <option value="815">Camión 815</option>
                                            <option value="8000">Camión 8000</option>
                                            <option value="Toronto">Toronto</option>
                                            <option value="Gandola">Gandola</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Color: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="color" id="color" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Placa: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="placa" id="placa" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Batea: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="placa_batea" id="placa_batea" required>
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
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='<?=base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
</script>
<!-- ToDo - tratar de migrar el DataTable a js/view/parametro/vehiculos.js -->
<script type="text/javascript">
    var module = 'Modulo de Unidad';
    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " del " + f.getFullYear();
    jQuery(function ($) {
        //initiate dataTables plugin
        var oTable1 =
            $('#dynamic-table_3')
                .dataTable({
                    bAutoWidth: false,
                    "ajax": {
                        "url": 'vehiculos/getDataTable'
                    },
                    "columns": [
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return '<input type=\"checkbox\" name=\"<?=$this->schema['pri_key']?>[]\" value='+data.<?=$this->schema['pri_key']?> +'>';
                            }
                        },
                        {"data": "marca"},
                        {"data": "modelo"},
                        {"data": "tipo"},
                        {"data": "color"},
                        {"data": "placa"},
                        {"data": "placa_batea"},
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return '<div class=\"hidden-sm hidden-xs action-buttons\">'+
                                    '<a href="#modal-table_categoria" role="button" data-toggle="modal" data-rel="tooltip" title="Editar" onclick="div_form_edit('+data.<?=$this->schema['pri_key']?> +', \'Editar Vehiculo\', \'vehiculos\')">' +
                                    '<span class=\"green\">' +
                                    '<i class="ace-icon fa fa-pencil bigger-120"></i>' +
                                    '</span>' +
                                    '</a>'+
                                    '<a href="#" class="tooltip-error" data-rel="tooltip" title="Eliminar" onclick="Delete('+data.<?=$this->schema['pri_key']?> +')">' +
                                    '<span class="red">' +
                                    '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
                                    '</span>' +
                                    '</a>'+
                                    '</div>'
                            }
                        }
                    ],
                    "columnDefs": [
                        {
                            "targets": [-1],
                            "visible": true,
                            "searchable": false
                        }],
                    "aaSorting": []
                });

        //TableTools settings
        TableTools.classes.container = "btn-group btn-overlap";
        TableTools.classes.print = {
            "body": "DTTT_Print",
            "info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
            "message": "tableTools-print-navbar"
        }

        //initiate TableTools extension
        var tableTools_obj = new $.fn.dataTable.TableTools(oTable1, {
            "sSwfPath": "../assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf", //in Ace demo ../assets will be replaced by correct assets path
            //"sRowSelector": "td:not(:last-child)",
            "sRowSelect": "multi",
            "fnRowSelected": function (row) {
                //check checkbox when row is selected
                try {
                    $(row).find('input[type=checkbox]').get(0).checked = true
                }
                catch (e) {
                }
            },
            "fnRowDeselected": function (row) {
                //uncheck checkbox
                try {
                    $(row).find('input[type=checkbox]').get(0).checked = false
                }
                catch (e) {
                }
            },
            "sSelectedClass": "success",
            "aButtons": [
                {
                    "sExtends": "copy",
                    "sToolTip": "Copiar a portapapeles",
                    "sButtonClass": "btn btn-white btn-primary btn-bold",
                    "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
                    "fnComplete": function () {
                        this.fnInfo('<h3 class="no-margin-top smaller">Tabla Copiada</h3><p>Copiado ' + (oTable1.fnSettings().fnRecordsTotal()) + ' fila(s) al portapapeles.</p>', 1500);
                    }
                },

                {
                    "sExtends": "csv",
                    "sToolTip": "Exportar a CVS",
                    "sTitle": module + " - " + fecha,
                    "sButtonClass": "btn btn-white btn-primary  btn-bold",
                    "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
                },

                {
                    "sExtends": "pdf",
                    "sToolTip": "Exportar a PDF",
                    "sTitle": module + " - " + fecha,
                    "sButtonClass": "btn btn-white btn-primary  btn-bold",
                    "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
                },

                {
                    "sExtends": "print",
                    "sToolTip": "Imprimir",
                    "sTitle": module + " - " + fecha,
                    "sButtonClass": "btn btn-white btn-primary  btn-bold",
                    "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",

                    "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Vista de Impresión - Modulo Unidad</small></a></div></div>",

                    "sInfo": "<h3 class='no-margin-top'>Vista de Impresión</h3>\
									  <p>Porfavor use la función de su navegador para Imprimir las Tablas.\
									  <br />Presione <b>escape</b> Para finalizar.</p>",
                },
                {
                    "sExtends": "select",
                    "sButtonText": "<i class='fa fa-trash-o bigger-110 red'></i>",
                    "sToolTip": "Eliminar Multipes",
                    "sTitle": module + " - " + fecha,
                    "sButtonClass": "btn btn-white btn-primary  btn-bold",
                    "fnClick": function (nButton, oConfig, oFlash) {
                        var checkboxValues =  new Array();
                        $('input[name="<?=$this->schema['pri_key']?>[]"]:checked').each(function() {
//                            checkboxValues += $(this).val() + ",";
                            checkboxValues.push($(this).val());
                        });
                        //checkboxValues = checkboxValues.substring(0, checkboxValues.length-1);
                        deleteMultipe(checkboxValues);
                    }

                },
            ]
        });
        //we put a container before our table and append TableTools element to it
        $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
        setTimeout(function () {
            $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function () {
                var div = $(this).find('> div');
                if (div.length > 0) div.tooltip({container: 'body'});
                else $(this).tooltip({container: 'body'});
            });
        }, 200);


        //ColVis extension
        var colvis = new $.fn.dataTable.ColVis(oTable1, {
            "buttonText": "<i class='fa fa-search'></i>",
            "aiExclude": [0],
            "showAll": "Mostrar Todo",
            "bShowAll": true,
            "bRestore": true,
            "sAlign": "right",
            "fnLabel": function (i, title, th) {
                return $(th).text();//remove icons, etc
            }

        });

        //style it
        $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')

        //and append it to our table tools btn-group, also add tooltip
        $(colvis.button())
            .prependTo('.tableTools-container .btn-group')
            .attr('title', 'Mostrar/Ocultar columnas').tooltip({container: 'body'});

        //and make the list, buttons and checkboxed Ace-like
        $(colvis.dom.collection)
            .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
            .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
            .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');


        /////////////////////////////////
        //table checkboxes
        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);


        var active_class = 'active';
        //select/deselect all rows according to table header checkbox
        $('#dynamic-table_3 > thead > tr > th input[type=checkbox]').eq(0).on('click', function () {
            var th_checked = this.checked;//checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function () {
                var row = this;
                if (th_checked) tableTools_obj.fnSelect(row);
                else tableTools_obj.fnDeselect(row);
            });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table_3').on('click', 'td input[type=checkbox]', function () {
            var row = $(this).closest('tr').get(0);
            if (!this.checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
        });


        $(document).on('click', '#dynamic-table_3 .dropdown-toggle', function (e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
        });




        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table_3').on('click', 'td input[type=checkbox]', function () {
            var $row = $(this).closest('tr');
            if (this.checked) $row.addClass(active_class);
            else $row.removeClass(active_class);
        });


        /********************************/
        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

        //tooltip placement on right or left
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }

    })
</script>
<?php $this->load->view('global_views/footer_dashboard'); ?>
