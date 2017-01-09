/**
 * Created by Jasp402 on 27/12/2016.
 */
$(document).ready(function () {
    $('form').submit(function (event) {
        event.preventDefault();
    });
    $('#id_ubicacion, #id_categoria').selectpicker({
        liveSearch: true,
        maxOptions: 1,
        liveSearchPlaceholder: 'Escriba...',
        title: 'seleccionar'
    });
});
function loadTipo() {
    var id = $("#id_categoria").find(":selected").val();
    if (id > 0) {
        $("#id_tipo").empty();

        $.ajax({
            type: 'POST',
            url: '../productos/tipos/searchAllByWhere',
            data: {'id_categoria': id},
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                var r = obj.result;
                $("#id_tipo").append(
                    $("<option></option>").attr("value","").text("Seleccione...")
                );
                $.each(r, function (indice, valor) {
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
function text_grado(){

}
function loadLibros(){
    $("#title_grado").empty(); //grado
    $("#title_grado").append($("#id_tipo option:selected").text());
    alert('nose porque no funciona');
    var id_categoria = $("#id_categoria").find(":selected").val();
    var id_tipo      = $("#id_tipo").find(":selected").val();
    if (id_tipo > 0) {
        $('#simple-table').DataTable({
            bAutoWidth: false,
            "ajax": {
                "url": '../productos/tipos/getDataTableWhere',
                "type": "POST",
                "data": {'id_categoria': id_categoria,'id_tipo':id_tipo}
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

