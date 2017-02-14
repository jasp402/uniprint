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
    if (cod == "") {
        bootbox.alert("complete todos campo");
    } else {
        $.ajax({
            url: 'lineas/save',
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
        url: 'lineas/edit',
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
    bootbox.confirm("Estas seguro que deseas eliminar el registro?, Recuerda que no se podr&aacute; recuperar.", function (result) {
        if (result) {
            $.ajax({
                url: 'lineas/delete',
                type: 'POST',
                dataType: 'json',
                data: {'id': id},
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
                url: 'lineas/deleteSelect',
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

//#DataTable.js
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
                    "url": 'lineas/getDataTable'
                },
                "columns": [
                    {
                        "data": null,'class':'align-middle',
                        render: function (data, type, row) {
                            return '<input type=\"checkbox\" name=\"id_ubicacion[]\" value='+data.id_ubicacion +'>';
                        }
                    },
                    {"data": "label",'class':'align-middle'},
                    {"data": "nombre",'class':'align-middle'},
                    {"data": "telefono"},
                    {
                        "data": null,
                        render: function (data, type, row) {
                            return '<div class=\"hidden-sm hidden-xs action-buttons\">'+
                                '<a href="#modal-table_categoria" role="button" data-toggle="modal" data-rel="tooltip" title="Editar" onclick="div_form_edit('+data.id_ubicacion +', \'Editar Linea\', \'lineas\')">' +
                                '<span class=\"green\">' +
                                '<i class="ace-icon fa fa-pencil bigger-120"></i>' +
                                '</span>' +
                                '</a>'+
                                '<a href="#" class="tooltip-error" data-rel="tooltip" title="Eliminar" onclick="Delete('+data.id_ubicacion+')">' +
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
                    }
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