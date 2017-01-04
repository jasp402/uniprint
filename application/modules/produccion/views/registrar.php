<?php echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/bootstrap-select-master/docs/docs/dist/css/bootstrap-select.css">

<script type="text/javascript" src='<?= base_url(); ?>assets/plugins/bootstrap-select-master/js/bootstrap-select.js'></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script src="<?=base_url()?>assets/js/bootbox.js"></script>

</head>
<?php echo $this->load->view('global_views/contenedor'); ?>
<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            event.preventDefault();
        });
    });
    function div_form_create(text) {
        $('#titulo_div').html(text);
        $("#form")[0].reset();
        $('#div_btn_edit').hide();
        $('#div_btn_save').show();
        $('#selectlive_1').selectpicker('refresh');
    }
    function div_form_edit(id,text,models) {
        $('#titulo_div').html(text);
        $('#div_btn_save').hide();
        $('#div_btn_edit').show();

        $.ajax({
            url: models+'/searchAllById',
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function(data) {
                var r = data.result[0];
                $.each(r, function(indice, valor) {
                    $("#"+indice).val(valor);
                });
            }
        });
    }


    function Save() {
        var cod = $('#nombre').val().trim();
        if (cod == "" ) {
            bootbox.alert("complete todos campo");
        } else {
            $.ajax({
                url: 'proveedor/save',
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
    }
    function Edit() {
        $.ajax({
            url: 'proveedor/edit',
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
                    url: 'proveedor/delete',
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
                    url: 'proveedor/deleteSelect',
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
        <i class="fa fa-sliders grey"></i>
        Parametros
        <small>
            <i class="fa fa-angle-double-right"></i>
            Gestionar Proveedores
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-12">

        <div class="infobox infobox-blue">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-handshake-o"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?= count($getAll)?></span>
                <div class="infobox-content">
                    <a href="#modal-table_categoria" role="button" data-toggle="modal"
                       onclick="javascript:div_form_create('Agregar nuevo Proveedor');">
                        <i class="ace-icon fa fa-external-link"></i>
                        Registar Proveedor
                    </a>
                </div>
            </div>
        </div>
<!--
        <div class="infobox infobox-blue">
            <div class="infobox-icon">
                <i class="ace-icon fa fa-book"></i>
            </div>

            <div class="infobox-data">
                <span class="infobox-data-number"><?=count($getAllImpresor)?></span>
                <div class="infobox-content">
                    <a href="./impresor">
                        <i class="ace-icon fa fa fa-external-link"></i>
                        Impresores
                    </a></div>
            </div>
        </div>
-->

        <div class="space-6"></div>

       <div class="clearfix">
           <div class="pull-right tableTools-container"></div>
       </div>
       <div>
           <table id="dynamic-table_3" class="table table-striped table-bordered table-hover">
               <thead>
               <tr>
                   <th><input type="checkbox"></th>
                   <th>Nombre</th>
                   <th>RIF</th>
                   <th>e-mail</th>
                   <th>Telefono</th>
                   <th>Dirección</th>
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
                                <label class="col-sm-4 control-label no-padding-right">RIF: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="rif" id="rif" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Nombre: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="nombre" id="nombre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">e-Mail: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="email" name="email" id="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">telefono: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="tel" name="telefono" id="telefono" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Dirección: </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-pencil-square-o grey bigger-110"></i>
                                        </span>
                                        <input class="form-control" type="textbox" name="direccion" id="direccion" required>
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
                        "url": 'proveedor/getDataTable'
                    },
                    "columns": [
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return '<input type=\"checkbox\" name=\"id_ubicacion[]\" value='+data.id_ubicacion +'>';
                            }
                        },
                        {"data": "nombre"},
                        {"data": "rif"},
                        {"data": "email"},
                        {"data": "telefono"},
                        {"data": "direccion"},
                        {
                            "data": null,
                            render: function (data, type, row) {
                                return '<div class=\"hidden-sm hidden-xs action-buttons\">'+
                                    '<a href="#modal-table_categoria" role="button" data-toggle="modal" data-rel="tooltip" title="Editar" onclick="div_form_edit('+data.id_ubicacion +', \'Editar Proveedor\', \'proveedor\')">' +
                                    '<span class=\"green\">' +
                                    '<i class="ace-icon fa fa-pencil bigger-120"></i>' +
                                    '</span>' +
                                    '</a>'+
                                    '<a href="#" class="tooltip-error" data-rel="tooltip" title="Eliminar" onclick="Delete('+data.id_ubicacion +')">' +
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
                        },
                        {
                            "targets": [2,3,4],
                            "visible": false,
                            "searchable": true
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
                        $('input[name="id_ubicacion[]"]:checked').each(function() {
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
