$(document).ready(function () {
    schema = jQuery.parseJSON($.ajax({
        url: 'vehiculos/load_setting_in_view',
        type: 'POST',
        async:false,
        success: function(data) {
            return jQuery.parseJSON(data);
        }
    }).responseText);
    //---------------------------------------------
    $('form').submit(function (event) {
        event.preventDefault();
    });
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
            SelectAjaxRefresh(r.id_proyecto,'selectlive_1');
        }
    });
}
function Save() {
    var cod = $('#marca').val().trim();
    var pla = $('#placa').val().trim();
    if (!cod || !pla) {
        bootbox.alert("complete todos campo; por lo minimo Marca & Placa");
    } else {
        $.ajax({
            url: 'vehiculos/save',
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
        url: 'vehiculos/edit',
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
                url: 'vehiculos/delete',
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
                url: 'vehiculos/deleteSelect',
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
