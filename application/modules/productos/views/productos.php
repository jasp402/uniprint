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

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>
<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
        });
        $('#id_proyecto').selectpicker({
            liveSearch: true,
            maxOptions: 1,
            liveSearchPlaceholder: 'Escriba...',
            title: 'seleccionar'
        });
    });

    function loadCategoria() {
        var id = $("#id_proyecto").find(":selected").val();
        if (id > 0) {
            $("#id_categoria").empty();
            $("#id_tipo").empty();
            $.ajax({
                type: 'POST',
                url: 'categorias/searchAllByWhere',
                data: {'id': id, 'field': 'id_proyecto'},
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    var r = obj.result;
                    $.each(r, function (indice, valor) {
                        $("#id_categoria").append(
                            $("<option></option>").attr("value", valor[indice].id_categoria).text(valor[indice].nombre)
                        );
                    });
                }
            });
            setTimeout(function () {
                loadTipo();
            }, 200);

        } else {
            if (id == 0) {
                $("#id_categoria").empty()
            }
        }
    }
    function loadTipo() {
        var id = $("#id_categoria").find(":selected").val();
        if (id > 0) {
            $("#id_tipo").empty();
            $.ajax({
                type: 'POST',
                url: 'tipos/searchAllByWhere',
                data: {'id': id, 'field': 'id_categoria'},
                success: function (data) {
                    var obj = jQuery.parseJSON(data);
                    var r = obj.result;
                    $.each(r, function (indice, valor) {
                        //console.log(valor[indice].nombre);
                        $("#id_tipo").append(
                            $("<option></option>").attr("value", valor[indice].id_tipo).text(valor[indice].nombre)
                        );
                    });
                }
            });
        } else {
            if (id == 0) {
                $("#id_tipo").empty()
            }
        }
    }
    function div_form_create(text) {
        $('#titulo_div').html(text);
        $("#form")[0].reset();
        $('#div_btn_edit').hide();
        $('#div_btn_save').show();
        $('#selectlive_1').selectpicker('refresh');
    }
    function div_form_edit(id, text, models) {
        $('#titulo_div').html(text);
        $('#div_btn_save').hide();
        $('#div_btn_edit').show();

        $.ajax({
            url: models + '/searchAllById',
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function (data) {
                console.log(data)
                var r = data.result[0];
                $.each(r, function (indice, valor) {
                    $("#" + indice).val(valor);
                });
                SelectAjaxRefresh(r.id_proyecto, 'id_proyecto');

                $("#id_tipo").append(
                    $("<option></option>").attr("value", r.id_tipo).text(r.tipo)
                );

                $("#id_categoria").append(
                    $("<option></option>").attr("value", r.id_categoria).text(r.categoria)
                );
            }
        });
    }
    function Save() {
        $.ajax({
            url: 'productos/save',
            type: 'POST',
            dataType: 'json',
            data: $('#form').serialize(), //ToDo - Investigar por no funciona con el selectpicker()
            //data: {'id_proyecto':cod1, 'nombre':cod2},
            beforeSend: function () {
                desactivar_inputs('form');
                mensaje_gbl('Procesando...', 'info', 'clock-o', 'mensaje_crud_apoderado');
            },
            success: function (data) {
                if (data) {
                    mensaje_gbl('Completado', 'success', 'check', 'mensaje_crud_apoderado');
                    message_box(data.success, data.times, data.closes);
                } else {
                    activar_inputs('form');
                    mensaje_gbl('Error', 'danger', 'times', 'mensaje_crud_apoderado');
                }
            }
        });

    }
    function Edit() {
        $.ajax({
            url: 'productos/edit',
            type: 'POST',
            dataType: 'json',
            data: $('#form').serialize(),
            beforeSend: function () {
                desactivar_inputs('form');
                mensaje_gbl('Procesando...', 'info', 'clock-o', 'mensaje_crud_apoderado');
            },
            success: function (data) {
                if (data) {
                    mensaje_gbl('Completado', 'success', 'check', 'mensaje_crud_apoderado');
                    message_box(data.success, data.times, data.closes);
                } else {
                    activar_inputs('form');
                    mensaje_gbl('Error', 'danger', 'times', 'mensaje_crud_apoderado');
                }
            }
        });
    }
    function Delete(id) {
        $('#div_textbox').hide(500);
        bootbox.confirm("Estas seguro que deseas eliminar este registro?, Recuerda que no se podr&aacute; recuperar.", function (result) {
            if (result) {
                $.ajax({
                    url: 'productos/delete',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id},
                    success: function (data) {
                        message_box(data.success, data.times, data.closes);
                    }
                });
            }
        });
    }
    function deleteMultipe(ids) {
        bootbox.confirm("Estas seguro que deseas eliminar "+ ids.length+" registro?, Recuerda que no se podr&aacute; recuperar.", function (result) {
            if (result) {
                $.ajax({
                    url: 'productos/deleteSelect',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: ids},
                    success: function (data) {
                        message_box(data.success, data.times, data.closes);
                    }
                });
            }
        });

    }


</script>
<!-- CABECERA -->
<div class="page-header">
    <h1>
        <i class="fa fa-cube grey"></i>
        Productos
        <small>
            <i class="fa fa-angle-double-right"></i>
            Gestionar Productos
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-sm-12 align-left">

            <!-- #section:pages/dashboard.infobox -->
            <div class="infobox infobox-green2">
                <div class="infobox-icon">
                    <i class="ace-icon fa fa-cube"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= count($getAllProductos);?></span>
                    <div class="infobox-content">
                        <a href="#modal-table_categoria" role="button" data-toggle="modal"
                           onclick="javascript:div_form_create('Registrar Productos');">
                            <i class="ace-icon fa fa-external-link"></i>
                            Registar Producto
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
                    <th>Proyecto</th>
                    <th>id_producto</th>
                    <th>Categoria</th>
                    <th>Tipo</th>
                    <th width="8%" style="width: 8%!important;" >Codigo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Detalles</th>
                    <th>Unidad Maxima</th>
                    <th>Detalle 2</th>
                    <th>Detalle 3</th>
                    <th>funciones</th>

                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-table_categoria" class="modal fade" tabindex="-3">
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
                    <input type="hidden" name="id_producto" id="id_producto">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">Proyectos: </label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_proyecto" id="id_proyecto"
                                            data-live-search="true" onchange="loadCategoria()">
                                        <option value="">Seleccione...</option>
                                        <?php foreach ($getAllProyectos as $keyList): ?>
                                            <option value="<?= $keyList->id_proyecto; ?>"><?= $keyList->id_proyecto; ?>
                                                - <?= $keyList->nombre; ?></option>
                                        <?php endforeach ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Categoria: </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="id_categoria" id="id_categoria"
                                            data-live-search="true" onchange="loadTipo()">
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Tipo: </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="id_tipo" id="id_tipo" data-live-search="true">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Unidad: </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="id_unidad" id="id_unidad"
                                            data-live-search="true">
                                        <?php foreach ($getAllUnidades as $keyList): ?>
                                            <option
                                                value="<?= $keyList->id_unidad; ?>"><?= $keyList->nombre; ?></option>
                                        <?php endforeach ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Codigo: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="codigo" id="codigo" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Nombre: </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="textbox" name="nombre" id="nombre" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Detalle 1: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="detalle_1" id="detalle_1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Detalle 2: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="detalle_2" id="detalle_2">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Detalle 3: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="detalle_3" id="detalle_3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="descripcion" id="descripcion"
                                              maxlength="500"></textarea>

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
                        "url": 'productos/getDataTable'
                    },
                    "columns": [
                        {
                            "data": null,
                            render: function (data, type, row) {
                                    return '<input type=\"checkbox\" name=\"id_producto[]\" value='+data.id_producto +'>';
                            }
                        },
                        {"data": "proyecto"},
                        {"data": "id_producto"},
                        {"data": "categoria"},
                        {"data": "tipo"},
                        {"data": "codigo"},
                        {"data": "nombre"},
                        {"data": "descripcion"},
                        {"data": "detalle_1"},
                        {"data": "unidad"},
                        {"data": "detalle_2"},
                        {"data": "detalle_3"},
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return '<div class=\"hidden-sm hidden-xs action-buttons\">'+
                                    '<a href="#modal-table_categoria" role="button" data-toggle="modal" data-rel="tooltip" title="Editar" onclick="div_form_edit('+data.id_producto +', \'Editar Producto\', \'productos\')">' +
                                    '<span class=\"green\">' +
                                    '<i class="ace-icon fa fa-pencil bigger-120"></i>' +
                                    '</span>' +
                                    '</a>'+
                                '<a href="#" class="tooltip-error" data-rel="tooltip" title="Eliminar" onclick="Delete('+data.id_producto +')">' +
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
                            "targets": [2, 7, 10, 11],
                            "visible": false,
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
                        var checkboxValues = new Array();
                        $('input[name="id_producto[]"]:checked').each(function () {
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

    })
</script>
<?php $this->load->view('global_views/footer_dashboard'); ?>
