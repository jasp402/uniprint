/**
 * Created by Jasp402 on 14/01/2017.
 */

 function dataTable_descontar() {
    jQuery(function ($) {
        $('#dynamic-table').dataTable({
            destroy: true,
            bAutoWidth: false,
            "ordering": false,
            "searching": false,
            "iDisplayLength": 1,
            'bSort': false,
            'oLanguage': { 'oPaginate': { 'sPrevious': 'Prev' } },

            "ajax": {
                "url": 'descontar/getDataTable'
            },
            "columns": [
                {"data": "codigo_barra", 'class': 'align-middle'},
                {"data": "documento", 'class': 'align-middle'},
                {"data": "nombre_origen"},
                {"data": "tipo"},
                {"data": "producto"},
                {"data": "cantidad"}
            ]
        });
        $('#dynamic-table_wrapper div:first').remove();
        $('#dynamic-table_length').remove();
    });
    }

    dataTable_descontar();

function myFunction(x, y) {
    if (y.length == x.maxLength) {
        $.ajax({
            url: 'descontar/descontar_lote',
            type: 'POST',
            dataType: 'json',
            data: {'codigo_barra': y},
            success: function (data) {
                message_sync(data.title, data.text, data.image_url, data.time, data.class_name);

            }
        });
        $('#descontar').val('');
        dataTable_descontar();
    }

}
