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
function limpiarTabla() {
    $("#simple-table tbody").remove("tr");
}
function loadLibros(){
    $("#simple-table").show();
    limpiarTabla();
    $("#title_grado").empty(); //grado
    $("#title_grado").append($("#id_tipo option:selected").text());
    var id_tipo      = $("#id_tipo").find(":selected").val();
    if (id_tipo > 0) {
        $('#simple-table').DataTable({
            destroy: true,
            bAutoWidth: false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching" : false,
            "ajax": {
                "url": 'registrar/getDataTable_libros',
                "data": function ( d ) {
                    d.id_tipo       = $("#id_tipo").find(":selected").val();
                }
            },
            "columns": [
               
                 {
                     "data": null,
                     render: function (data, type, row) {
                         return  '<label class="pos-rel">'+
                             '<input type="checkbox" name=\"id_producto[]\" class="ace" value='+data.id_producto+'>'+
                             '<span class="lbl"></span>'+
                             '</label>';
                     }
                 },

                {"data": "nombre"},
                {"data": "detalle_1"},
                //ToDo - Calcular el saldo de material pasado a produccion
                {"data": null},
                {
                    "data": null,
                    render: function (data, type, row) {
                        return  '<label class="pos-rel">'+
                            '<input type="textbox" name=\"id_producto[]\">'+
                            '<span class="lbl"></span>'+
                            '</label>';
                    }
                }
            ],
        });
    } else {
        if (id_tipo == 0) {
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

