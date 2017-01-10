/**
 * Created by Jasp402 on 27/12/2016.
 */
var nextinput = 0;
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
function loadLibros(){
    $("#simple-table").show();
    $("#simple-table tbody").remove("tr");
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
        $('#simple-table_wrapper').removeClass("dataTables_wrapper");
    } else {
        if (id_tipo == 0) {
            $("#id_tipo").empty()
        }
    }
}
