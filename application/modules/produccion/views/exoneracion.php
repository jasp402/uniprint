<?php echo $this->load->view('global_views/header_dashboard'); ?>
    <style>
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        }
    </style>
    <script type="text/javascript"
            src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
    <link rel="stylesheet" type="text/css"
          href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/datepicker.css"/>


    <script src="<?= base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
    <script src="<?= base_url(); ?>assets/js/date-time/bootstrap-datepicker.es.js"></script>
    <script src="<?= base_url(); ?>assets/js/date-time/moment.js"></script>
    <script src="<?= base_url(); ?>assets/js/date-time/daterangepicker.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <!--
        <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    -->
    <script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
    <script src="<?= base_url() ?>assets/js/bootbox.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('form').submit(function (event) {
                event.preventDefault();
            });


            $('#cod_alumno').selectpicker({
                liveSearch: true,
                maxOptions: 1,
                liveSearchPlaceholder: 'Escriba...',
                title: 'seleccionar'
            });

        });
        //DIV FORM CREATE
        function div_agregar() {
            $('#div_textbox').show(300);
            $('#titulo_div').html('Agregar Exoneración');
            $("#form")[0].reset();
            $('#div_btn_edit').hide();
            $('#div_btn_save').show();
        }
        //DIV FORM EDIT
        var result;
        function ver_detalle(id) {
            $('#example').DataTable({
                    bAutoWidth: true,
                    "ajax": {
                        type: 'POST',
                        "url": 'exoneracion/getAll',
                        "data": {'id': id}
                    },
                    "columns": [
                        {"data": "cod_exoneracion"},
                        {"data": null,
                            render: function (data, type, row) {
                                return data.f_inicio + ' <i class=\"fa fa-arrows-h\" aria-hidden=\"true\"></i> ' + data.f_fin;
                            }},
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return data.nombre_1 + ' ' + data.nombre_2;
                            }
                        },
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return data.apellido_paterno + ' ' + data.apellido_materno;
                            }
                        },
                        {"data": "fecha","class":"green",
                            render: function (data, type, row) {
                                var diaActual = hoy();
                                if (data == diaActual) {
                                    return data+  ' <span class=\"label label-sm label-warning arrowed\">hoy</span>';
                                }else{
                                    return data;
                                }
                            }
                        },
                        {"data": null,
                            render: function (data, type, row) {
                                var diaActual = hoy(); //14/11/2016
                                var diasSemana = new Array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
                                var f=new Date(data.fecha);
                                if(diasSemana[f.getDay()] == 'Domingo' || diasSemana[f.getDay()]=='Sábado'){
                                    var dia = '<strike class=\"red\">'+diasSemana[f.getDay()]+'</strike>';
                                    return dia;
                                }else{
                                    return diasSemana[f.getDay()];
                                }
                            }
                        },
                        {"data": "comentario"},
                        {"data": "estado",
                            render: function (data, type, row) {
                                if(data == 1){
                                    return '<span class=\"label label-sm label-success arrowed\">Activo</span>';
                                }else{
                                    return '<span class=\"label label-sm label-inverse arrowed-right\">Historico</span>';
                                }
                            }


                        }

                    ],"columnDefs": [
                        //{ "visible": false, "targets": 0 }
                    ],
                    "order": [[ 0, 'desc' ]],
                    "displayLength": 10,
                    "drawCallback": function ( settings ) {
                        var api = this.api();
                        var rows = api.rows().nodes();
                        var last=null;

                        api.column(0).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="8">Codigo de Registro ['+group+']</td></tr>'
                                );

                                last = group;
                            }
                        } );
                    }
                }
            );
            //########################################### END MODAL TABLE
            return result;
        }
        function limpiarTabla() {
            $('#example').DataTable().destroy();
        }
        //CREAR UNIDAD
        function save_unidad() {
            var f_inicio = toDateString($('#start').val());
            var f_fin = toDateString($('#end').val());
            if(f_inicio != 'undefined//undefined' && f_fin != 'undefined//undefined'){
                var rango = calc_fecha_dia($('#start').val(), $('#end').val());
            }
            var cod = $('#cod_alumno').val().trim();
            if (cod == "") {
                bootbox.alert("Ingrese el Alumno");
            } else {
                if (rango == undefined) {
                    bootbox.alert('No ha introducido la fecha o lo ha hecho de forma incorrecta')
                } else {
                    if ($('#start').val() == $('#end').val()) {
                        rango = -1
                    }

                    $.ajax({
                        url: 'exoneracion/save_trataminto',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#form').serialize() + '&rango=' + rango + '&start1=' + f_inicio + '&start2=' + f_fin,
                        beforeSend: function () {
                            desactivar_inputs('form');
                            mensaje_gbl('Procesando...', 'info', 'clock-o', 'mensaje_crud_apoderado');
                        },
                        success: function (data) {
                            mensaje_gbl('Completado', 'success', 'check', 'mensaje_crud_apoderado');
                            message_box(data.success, data.times, data.closes);
                        }
                    });
                }
            }
        }



        //ELIMINAR UNIDAD
        function archivar(id, nom) {

            $('#div_textbox').hide(500);
            bootbox.confirm("Estas seguro que deseas <b>deshabilitar</b> todos los registro del  estudiante <b>" +nom+"</b>?", function (result) {
                if (result) {
                    $.ajax({
                        url: 'exoneracion/archivarTodo',
                        type: 'POST',
                        dataType: 'json',
                        data: {id: id},
                        beforeSend: function () {
                        },
                        success: function (data) {
                            message_box(data.success, data.times, data.closes);
                        }
                    });
                }
            });

        }
    </script>
    </head>
<?php echo $this->load->view('global_views/contenedor'); ?>

    <!-- CABECERA -->
    <div class="page-header">
        <h1>
            <i class="fa fa-cogs grey"></i>
            Comedor
            <small>
                <i class="fa fa-angle-double-right"></i>
                Alumno Exonerados
            </small>
        </h1>
    </div>

    <!-- ESPACIO -->
    <div class="space-12"></div>

    <!-- BOTON <<AGREGAR UNIDADES>> -->
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-white btn-info btn-bold" onclick="javascript:div_agregar();">
                <i class="ace-icon fa fa-plus bigger-120 blue"></i>
                Agregar Exoneración
            </button>
        </div>
    </div>

    <!-- FORMULARIO DE CRUD -->
    <div class="row" id="div_textbox" style="display: none;">
        <div class="hr hr-18 hr-double dotted"></div>
        <div class="col-xs-12 center">
            <span class="bigger-140 blue" id="titulo_div"></span>
            <div class="hr hr-18 hr-double dotted"></div>
        </div>
        <div class="col-sm-12">
            <?php echo form_open('', "id='form' class='form-horizontal' "); ?>
            <div class="col-sm-6">
                <div class="form-group" style="display: none">
                    <label class="col-sm-4 control-label no-padding-right"> id: </label>
                    <input type="hidden" id="id_tra_especial" name="id_tra_especial">
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right"> Alumno: </label>
                    <div class="col-sm-8">
                        <select class="form-control" name="cod_alumno" id="cod_alumno" data-live-search="true" required>
                            <?php foreach ($setByAlumno as $keyAList): ?>
                                <option value="<?= $keyAList->cod_alumno; ?>">[<?= $keyAList->cod_alumno; ?>
                                    ] <?= $keyAList->nombre_1 . " " . $keyAList->nombre_2; ?>
                                    - <?= $keyAList->apellido_paterno . " " . $keyAList->apellido_materno; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-12"><br></div>
                    <label class="col-sm-4 control-label no-padding-right"> Rango de Fecha: </label>
                    <div class="col-sm-8">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control" placeholder="inicia" name="start" id="start" required>
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" placeholder="finaliza" name="end" id="end" required>
                        </div>

                        <!-- /section:plugins/date-time.datepicker -->
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Comentario: </label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="comentario" id="comentario" maxlength="150"
                                  rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="row" id="mensaje_crud_apoderado"></div>
            <div class="col-xs-12 col-sm-12 center" style="display: none;" id="div_btn_save">
                <button class="btn btn-primary" id="btn_save_apoderado" onclick="javascript:save_unidad();">
                    <i class="fa fa-save bigger-120"></i>
                    Registrar
                </button>
            </div>
            <div class="col-xs-12 col-sm-12 center" style="display: none;" id="div_btn_edit">
                <button class="btn btn-warning" id="btn_edit" onclick="javascript:edit_unidad();">
                    <i class="fa fa-pencil bigger-120"></i>
                    Editar
                </button>
            </div>
            </form>
        </div>
    </div>
    <!-- TABLA RECETA -->
    <div class="row">
        <div class="col-xs-12">
            <h3 class="header smaller lighter blue"></h3>

            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
            </div>
            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th><i class="fa fa-clock-o" aria-hidden="true"></i> fecha</th>
                        <th><i class="fa fa-clock-o" aria-hidden="true"></i> días</th>
                        <th>Comentario</th>

                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if ($setByAll): ?>
                        <?php foreach ($setByAll as $keyAll): ?>
                            <tr>
                                <td align="cen"><?= $keyAll->nombre_1 . " " . $keyAll->nombre_2; ?></td>
                                <td><?= $keyAll->apellido_paterno . " " . $keyAll->apellido_materno; ?></td>
                                <td align="center" class="hidden-480"><?= $keyAll->f_inicio; ?> <i
                                        class="fa fa-arrows-h" aria-hidden="true"></i> <?= $keyAll->f_fin; ?> </td>
                                <td align="center" class="hidden-480"><?= $keyAll->dias; ?></td>
                                <td class="hidden-480"><?= $keyAll->comentario; ?></td>
                                <td>

                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a href="#modal-table" role="button" data-toggle="modal" data-keyboard="false"
                                           data-backdrop="static" class="blue"
                                           onclick="ver_detalle('<?= $keyAll->cod_alumno ?>');">
                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                        </a>

                                        <a class="red" href="#"
                                           onclick="archivar('<?= $keyAll->cod_alumno ?>','<?= $keyAll->nombre_1 .' '. $keyAll->nombre_2 .' '. $keyAll->apellido_paterno ?>')">
                                            <i class="fa fa-archive" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                    <?php endif ?>

                    </tbody>
                </table>
            </div>
            <div id="modal-table" class="modal fade" tabindex="-1">
                <div class="modal-dialog" style="width:80% !important;">
                    <div class="modal-content">
                        <div class="modal-header no-padding">
                            <div class="table-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                        onclick="limpiarTabla()">
                                    <span class="white">&times;</span>
                                </button>
                                Detalle de la Consulta
                            </div>
                        </div>

                        <div class="modal-body no-padding">
                            <table id="example" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Reg.</th>
                                    <th>Periodo</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Fecha</th>
                                    <th>dia</th>
                                    <th>comentarios</th>
                                    <th>estatus</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="modal-footer no-margin-top">
                            <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal"
                                    onclick="limpiarTabla()">
                                <i class="ace-icon fa fa-times"></i>
                                Cerrar
                            </button>

                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?=base_url();?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
    </script>
    <script type="text/javascript">
        var module = 'Modulo de Unidad';
        var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        var f = new Date();
        var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " del " + f.getFullYear();
        jQuery(function ($) {

            var oTable1 =
                $('#dynamic-table')

                    .dataTable({
//############################### Config Reponsive DataTable
                        //"sScrollY": "500px",
                        //"bPaginate": false,
                        //"sScrollX": "100%",
                        //"sScrollXInner": "100%",
                        //"bScrollCollapse": false,
// /.Config Reponsive DataTable #############################
                        bAutoWidth: true,
                        "aoColumns": [
                            {"bSortable": false},
                            null, null, null, null,
                            {"bSortable": false}
                        ],
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
                "sRowSelector": "td:not(:last-child)",
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
                            this.fnInfo('<h3 class="no-margin-top smaller">Tabla Copiada</h3>\
									<p>Copiado ' + (oTable1.fnSettings().fnRecordsTotal()) + ' fila(s) al portapapeles.</p>',
                                1500
                            );
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
                    }
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
                "aiExclude": [5],
                "showAll": "Mostrar Todo",
                "bShowAll": true,
                //"bRestore": true,
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

            //select/deselect all rows according to table header checkbox
            $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function () {
                var th_checked = this.checked;//checkbox inside "TH" table header

                $(this).closest('table').find('tbody > tr').each(function () {
                    var row = this;
                    if (th_checked) tableTools_obj.fnSelect(row);
                    else tableTools_obj.fnDeselect(row);
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#dynamic-table').on('click', 'td input[type=checkbox]', function () {
                var row = $(this).closest('tr').get(0);
                if (!this.checked) tableTools_obj.fnSelect(row);
                else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
            });


            $(document).on('click', '#dynamic-table .dropdown-toggle', function (e) {
                e.stopImmediatePropagation();
                e.stopPropagation();
                e.preventDefault();
            });


            //And for the first simple table, which doesn't have TableTools or dataTables
            //select/deselect all rows according to table header checkbox
            var active_class = 'active';
            $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function () {
                var th_checked = this.checked;//checkbox inside "TH" table header

                $(this).closest('table').find('tbody > tr').each(function () {
                    var row = this;
                    if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                    else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#simple-table').on('click', 'td input[type=checkbox]', function () {
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

            $('.input-daterange').datepicker({
                startDate: '-1d',
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                language: 'es'
            });
            $('input[name=date-range-picker]').daterangepicker({
                'applyClass': 'btn-sm btn-success',
                'cancelClass': 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel'
                }
            })
                .prev().on(ace.click_event, function () {
                $(this).next().focus();
            });

        })
    </script>
<?php $this->load->view('global_views/footer_dashboard'); ?>