
$(document).ready(function () {
    $('form').submit(function (event) {
        event.preventDefault();
    });
    $('#id_proyecto').selectpicker({
        liveSearch: true,
        maxOptions: 1,
        liveSearchPlaceholder: 'Escriba...',
        title: 'seleccionar'
    })
    $( ".open-event" ).tooltip({
        show: null,
        position: {
            my: "left top",
            at: "left bottom"
        },
        open: function( event, ui ) {
            ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
        }
    });
    // DataTable
    var table =  $('#dynamic-table_3').DataTable({
            "initComplete": function () {
                this.api().columns().every( function () {
                    var i = this.index();
                    //console.log(i);
                    var column = this;
                        if(i!=10 && i!=9 &&  i!=8 && i!=12 && i!=0){

                            var select = $('<select id=\'select'+i+'\' data-style="btn-info input-sm" data-width="80px"  data-size="auto"><option value="" data-icon="glyphicon-remove">Delete Filter</option></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                            $('#select'+i+'').selectpicker({
                                liveSearch: true,
                                maxOptions: 1,
                                liveSearchPlaceholder: 'Busca...',
                                title: ''
                            });
                        }

                } );
            },
            // scrollY:        true,
            // scrollCollapse: false,
            bAutoWidth: false,
            "ajax": {
                "url": 'inventario/getDataTable'
            },
            "columns": [
                /** ### Btn Eliminar Multiple - CheckedBottom
                 {
                     "data": null,
                     render: function (data, type, row) {
                         return '<input type=\"checkbox\" name=\"id_producto[]\" value='+data.id_producto +'>';
                     }
                 },
                 **/
                {"data": "cod_inventario"},
                {"data": "fecha"},
                {"data": "origen"},
                {"data": "documento"},
                {"data": "proyecto"},
                {"data": "categoria"},
                {"data": "tipo"},
                {"data": "producto"},
                {"data": "cant_lote","class":"align-center"},
                {"data": "cant_unidades","class":"align-right",
                    render: function (data, type, row) {
                        number = parseInt(data);
                        return number.toLocaleString('es-ES');
                    }},
                {"data": "total","class":"align-right bolder",
                    render: function (data, type, row) {
                        number = parseInt(data);
                        return number.toLocaleString('es-ES');
                    }
                },
                {"data": "log_user","class":"text-mute"},
                {"data": "log_date",
                    render: function (data, type, row) {
                        return "<small><i class=\"text-muted\"> "+data+"</i></small>";
                    }
                },                {
                    "data": null,
                    render: function (data, type, row) {
                        return '<div class=\"hidden-sm hidden-xs action-buttons\">'+
                            '<a href="#modal-table" role="button" data-toggle="modal" data-rel="tooltip" title="Editar" onclick="div_form_edit('+data.id_inventario+',\'Editar Inventario\', \'inventario\')">' +
                            '<span class=\"green\">' +
                            '<i class="ace-icon fa fa-pencil bigger-120"></i>' +
                            '</span>' +
                            '</a>'+
                            '<a href="#" class="tooltip-error" data-rel="tooltip" title="Eliminar" onclick="Delete('+data.id_inventario+','+data.cod_inventario+')">' +
                            '<span class="red">' +
                            '<i class="ace-icon fa fa-trash-o bigger-120"></i>' +
                            '</span>' +
                            '</div>'
                    }
                }

            ],
            "order": [[1, 'desc']],
            "columnDefs": [
                {
                    "targets": [4,13],
                    "visible": false,
                    "searchable": false
                }],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows().nodes();
                var last=null;

                api.column(0).data().each( function ( group, i ) {
                    id = api.column(0).data(); //cod_inventario
                    ne = api.column(3).data();
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group info"><td colspan="13"><a href="#" onclick="loadInfo('+id[i]+')">' +
                            '<span class="label label-success arrowed-right arrowed-in">Entrada</span>' +
                            '  Nota de Entrega <b>#'+ne[i]+'</b></a> </td></tr>'
                        );

                        last = group;
                    }
                } );
            }
        });
});
// ---------------------
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
            $("#cant_lote").val(data.result[0].cant_lote).prop('readonly', true);
            $("#cant_unidades").val(data.result[0].cant_unidades);
            $("#id_inventario").val(data.result[0].id_inventario);
            $("#cod_inventario").val(data.result[0].cod_inventario);
            $("#id_producto").val(data.result[0].id_producto);
            //suma
            $("#total").val((data.result[0].cant_lote*data.result[0].cant_unidades));
        }
    });

}
function Edit() {
    $.ajax({
        url: 'inventario/editWhere',
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
function Delete(id,cod) {
    $('#div_textbox').hide(500);
    bootbox.confirm("Estas seguro que deseas eliminar este registro?, No lo podr&aacute; recuperar. <br>" +
        "<small class='red'><cite>¡Recuerde! si elimina los registros procesados en <b>producción <i class=\"fa fa-angle-double-right\"></i> Descontar Lote</b> podrian causar inconsistencia en los <b>Reportes</b></cite></small> ", function (result) {
        if (result) {
            $.ajax({
                url: 'inventario/delete',
                type: 'POST',
                dataType: 'json',
                data: {'id_inventario': id,'cod_inventario':cod},
                success: function (data) {
                    message_box(data.success, data.times, data.closes);
                }
            });
        }
    });
}
function loadInfo(id) {
    console.log(id);
    $.ajax({
        url: 'inventario/search_entrada',
        type: 'POST',
        dataType: 'json',
        data: {'cod_inventario': id},
        beforeSend: function () {
            message_load('Procesando...', 'info', 'clock-o', '_load','_profile');
        },
        success: function (data) {
            //console.log(data);
            console.log(data.result[0][0]);
            $('#widget-title').text('Documento de Entrada #'+data.result[0][0].documento+'');
            $('#_documento').text(data.result[0][0].documento);
            $('#_origen').text(data.result[0][0].origen);
            SetByIdDestino(data.result[0][0].destino);
            $('#_chofer').text(data.result[0][0].chofer+' - '+data.result[0][0].cedula);
            $('#_vehiculo').text(data.result[0][0].marca+' '+data.result[0][0].modelo+' - '+data.result[0][0].placa);
            $('#_fecha').text(data.result[0][0].fecha);
            $('#_cod_inventario').text(data.result[0][0].cod_inventario);
            $('#_proyecto').text(data.result[0][0].nombre_proyecto);
            $('#_loguser').text(data.result[0][0].responsable);
            $('#_logdate').text(data.result[0][0].registro);
            $('#_comentario').text(data.result[0][0].comentario);
            SetSumaUnid(data.result[0][0].cod_inventario);
            SetSumaPaletas(data.result[0][0].cod_inventario);
            $("#_etiqueta").attr("href", "../pdfs/pdfs?labelBookIn="+data.result[0][0].cod_inventario+"");
            $("#_etiquetaBtn").attr("href", "../pdfs/pdfs?labelBookIn="+data.result[0][0].cod_inventario+"");
            message_hide('_load','_profile');
        }
    });
}
function SetByIdDestino(id) {
    $.ajax({
        url: '../almacenes/almacen/searchAllById',
        type: 'POST',
        dataType: 'JSON',
        data: {id: id},
        success: function (data) {
            $('#_destino').text(data.result[0].nombre);
        }
    });
}
function SetSumaUnid(id) {
    $.ajax({
        url: 'inventario/sumarTotal',
        type: 'POST',
        dataType: 'JSON',
        data: {id: id},
        success: function (data) {
            number = parseInt(data[0].suma);
            $('#_total').text(number.toLocaleString('es-ES'));
        }
    });
}
function SetSumaPaletas(id) {
    $.ajax({
        url: 'inventario/sumarPltas',
        type: 'POST',
        dataType: 'JSON',
        data: {id: id},
        success: function (data) {
            console.log(data);
            number = parseInt(data[0].suma);
            $('#_pltas').text(number.toLocaleString('es-ES'));
        }
    });
}

var module = 'Registro de Inventario';
var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
var f = new Date();
var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " del " + f.getFullYear();
jQuery(function ($) {
    //initiate dataTables plugin
    var oTable1 =
        $('#dynamic-table_3')
            .dataTable();

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
            /** ###Btn Eliminar Multiple ###
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

             }
             **/
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
        //"aiExclude": [0],
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

});

/**
 * Created by Jasp402 on 08/12/2016.
 */
