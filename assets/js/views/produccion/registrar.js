/**
 * Created by Jasp402 on 27/12/2016.
 */
var nextinput = 0;
$(document).ready(function () {
    $('#id_ubicacion, #id_categoria, #id_producto').selectpicker({
        liveSearch: true,
        maxOptions: 1,
        liveSearchPlaceholder: 'Escriba...',
        title: 'seleccionar'
    });
    $('form').submit(function (event) {
        event.preventDefault();
    });
});
function validar() {


    $('form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            unidades:{
                required: true
            }

        },

        messages: {
            unidades: {
                required: "Por favor complete todos los campos"
            },
        },


        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },

        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
        },

        submitHandler: function (form) {
            Save();
            // alert("asd");
        },
        invalidHandler: function (form) {
            bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta completar algunos campos</strong></h4>');
        }
    });
}
function loadGrado() {
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
    $("#thead_lote").show();
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
                             '<input type="checkbox" name="id_producto[]" id="checkbox'+data.id_producto+'" class="ace" onclick="enable_cant_libros('+data.id_producto+')" value="'+data.id_producto+'" >'+
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
                            '<input type="number" min="1" name=\"cant_lote[]\" id="cant_libros'+data.id_producto+'" disabled="disabled">'+
                            '<span class="lbl"></span>'+
                            '</label>';
                    }
                }
            ]
        });
        $('#simple-table_wrapper').removeClass("dataTables_wrapper");
    } else {
        if (id_tipo == 0) {
            $("#id_tipo").empty()
        }
    }
    loadAllSelect();
}

//--------------------------


//AutoCarga el select[categoria]
function loadAllSelect() {
    var id = 2; //id_proyecto
    $.ajax({
        type: 'POST',
        url: '../productos/categorias/searchAllByWhere',
        data: {'id_proyecto': id},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            var c = obj.result;
            for (var i = 1; i <= nextinput; i++) {
                $("#id_categoria"+i).empty();
                $("#id_categoria"+i).append(
                    $("<option></option>").attr("value", '').text('Seleccione...')
                );
                $.each(c, function (indice, valor) {
                    $("#id_categoria"+i).append(
                        $("<option></option>").attr("value", valor[indice].id_categoria).text(valor[indice].nombre)
                    );
                });
            }
        }
    });
}

//AutoCarga el Select[categoria] -> según(nextinput)
function loadCategoria(i) {
    var id = 2;
    if(id>0){
        $.ajax({
            type: 'POST',
            url: '../productos/categorias/searchAllByWhere',
            data: {'id_proyecto': id},
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                var c = obj.result;
                $("#id_categoria" + i).empty();
                $("#id_categoria" + i).append(
                    $("<option></option>").attr("value", '').text('Seleccione...')
                );
                $.each(c, function (indice, valor) {
                    $("#id_categoria" + i).append(
                        $("<option></option>").attr("value", valor[indice].id_categoria).text(valor[indice].nombre)
                    );
                });
            }
        });
    }
}

//AutoCarga el Select[categoria] -> según(nextinput)
function loadTipo(index) {
    var id = $("#id_categoria"+index).find(":selected").val();
    if (id > 0) {
        $("#id_tipo"+index).empty();
        $.ajax({
            type: 'POST',
            url: '../productos/tipos/searchAllByWhere',
            data: {'id_categoria': id},
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                var r = obj.result;
                $("#id_tipo"+index).append(
                    $("<option></option>").attr("value","").text("Seleccione...")
                );
                $.each(r, function (indice, valor) {
                    $("#id_tipo"+index).append(
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

//AutoCarga el Select[categoria] -> según(nextinput)
function loadProducto(index) {
    var cat = $("#id_categoria"+index).find(":selected").val();
    var tip = $("#id_tipo"+index).find(":selected").val();
    if (cat && tip) {
        $("#id_producto"+index).empty();
        $.ajax({
            type: 'POST',
            url: '../productos/productos/searchAllByWhere',
            data: {'id_categoria':cat,'id_tipo':tip},
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                var r = obj.result;
                if(r.length >0){
                    $("#id_producto"+index).append(
                        $("<option></option>").attr("value", '').text('Seleccione...')
                    );
                    $.each(r, function (indice, valor) {
                        $("#id_producto"+index).append(
                            $("<option></option>")
                                .attr("title", valor[indice].detalle_1)
                                .attr("value", valor[indice].id_producto)
                                .text(valor[indice].nombre)
                        );
                    });
                }else{
                    $("#id_producto"+index).append(
                        $("<option></option>").attr("value", '').text('No hay productos')
                    );
                }

            }
        });
    }else{
        $("#id_producto").empty()
    }
}

//agrega campos de productos para Utiles escolares
function AgregarCampos_lote(){
    //loadAllSelect();
    nextinput++;
    campo = '<tr id="campo'+nextinput+'">'+
        '<td  class="align-middle"><a href="#" onclick="elimCamp('+nextinput+')"><i class="ui-icon fa fa-trash red" aria-hidden="true"></i></a></td>'+
        '<td  class="align-middle">'+nextinput+'</td>'+
        '<td>' +
        '<select class="form-control" id="id_categoria'+nextinput+'"  data-live-search="true" onchange="loadTipo('+nextinput+')">'+
        '<option value="">Seleccione un proyecto</option>'+
        '</select>' +
        '</td>'+
        '<td>'+
        '<select class="form-control" id="id_tipo'+nextinput+'"  data-live-search="true" onchange="loadProducto('+nextinput+')">'+
        '<option value="">Seleccione un proyecto</option>'+
        '</select>'+
        '</td>'+
        '<td>'+
        '<select class="form-control" name="id_producto[]'+nextinput+'" id="id_producto'+nextinput+'">'+
        '</select>'+
        '</td>'+
        '<td><input type="number" name="cant_lote[]'+nextinput+'" id="cant_lote'+nextinput+'" class="form-control"></td>' +
        '</tr>';
    $("#campos_lote").append(campo);
    loadCategoria(nextinput);
}

//multiplica la cantidad de morrales por paleta
function totalizar_Produccion(){
    var total;
    paletas = $('#lote').val();
    cantidad = $('#cant_lote').val();
    if(paletas && cantidad){
     total = paletas*cantidad;
    $('#total').val(total);
    }else{
        $('#total').val(0);

    }


}

function Save(){
    var f = hoy();
    var grado = $("#id_tipo option:selected").text();

    if($("#id_tipo option:selected").val()=='' || $("#id_ubicacion option:selected").val()==''){
        bootbox.alert('Falta completar algunos campos')
    }else{
        var i;
        var chk = true;
        for(i=1; i <= nextinput; i++){
            //console.log($('#total'+i+'').val());
            if($('#cant_lote'+i+'').val() == 0){
                chk = false;
            }
        }
        //console.log(chk)
        if(chk == false){
            bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Tienes campos <strong>Incompletos en Utilies Escolares</strong></h4>');
        }
        //sync
        $.ajax({
            url: 'registrar/save',
            type: 'POST',
            dataType: 'json',
            data: $('#form').serialize()+'&fecha='+f+'&grado='+grado,
            success: function (data) {
                console.log(data);
                message_box(data.success, data.times, data.closes);
            }
        });
    }

}

function enable_cant_libros(id){
    if ($("#checkbox"+id+":checked").val() == id) {
        $("#cant_libros"+id).removeAttr("disabled");
        $("#cant_libros"+id).val($("#cant_lote").val());
    }
    else {
        $("#cant_libros"+id).val('');
        $("#cant_libros"+id).attr('disabled', 'disabled');
    }
}
