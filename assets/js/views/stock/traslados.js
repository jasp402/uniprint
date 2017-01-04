/**
 * Impoortante: SERIE: YES || SERIE: NO
 * var lote = NO => (Serie YES)
 * var lote = SI => (Serie NO)
 *
 * **/

$(document).ready(function (){
    $('form').submit(function (event) {
        event.preventDefault();
    });
    //datePicker
    $('#fecha').datepicker({
        //startDate: '0d',
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yyyy',
        changeYear: false,
        language: 'es'
    });
    //SelectPicker
    $('#id_impresor').selectpicker({
        liveSearch: true,
        maxOptions: 1,
        liveSearchPlaceholder: 'Escriba...',
        title: 'seleccionar Impresores'
    });
    $('#id_proveedor').selectpicker({
        liveSearch: true,
        maxOptions: 1,
        liveSearchPlaceholder: 'Escriba...',
        title: 'seleccionar Proveedores'
    });
    $('#id_chofer, #id_vehiculo, #id_proyecto').selectpicker({
        liveSearch: true,
        maxOptions: 1,
        liveSearchPlaceholder: 'Escriba...',
        title: 'seleccionar'
    });
    $("#cod_contenedor").attr('disabled', 'disabled');
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

var nextinput = 0;
var lote='si';

function granel(){
    //Aqui iniciamos el contador de celdas para ambas tablas
    nextinput = 0;
    $("#campos_lote").html('');
    $("#campos_serie").html('');
    if ($("#id-pills-stacked-granel:checked").val() == 1) {
        lote = 'no'; //<--Default ||    Serie 'SI'
        // #Ocultar el <th> de la tabla y mostrar el de a granel
        $('#table_lote_total_serie').html('Total de Unidades');
        $("#thead_lote").hide();
        $("#thead_serie").fadeIn();
    }
    else {
        lote = 'si'; //<--------- ||    Serie 'NO'
        $('#table_lote_total').html('Total de Unidades');
        $("#thead_lote").fadeIn();
        $("#thead_serie").hide();
    }
}
function Save(){
    var f = toDateString($("#fecha").val());
    var impresor = $("#id_impresor").find(":selected").val();
    var proveedor = $("#id_proveedor").find(":selected").val();
    $.ajax({
        url: 'traslados/save',
        type: 'POST',
        dataType: 'json',
        data: $('#form').serialize()+'&fecha='+f+'&lote='+lote,
        success: function (data) {
            message_box(data.success, data.times, data.closes);
        }
    });
}

function loadAllSelect() {
    var id = $("#id_proyecto").find(":selected").val();
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
function loadCategoria(i) {
    var id = $("#id_proyecto").find(":selected").val();
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
                        $("#id_producto" + index).append(
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
        })
    }else{
        $("#id_producto").empty()
    }
}
function suma() {
    var j;
    if(nextinput>0){
        for(j=1; j<=nextinput; j++){
            $('#total'+j).val($('#cant_lote'+j).val()*$('#cant_unidades'+j).val());
        }
    }
}
function sumaTotales() {
    var j;
    var total=0;
    if(nextinput>0){
        for(j=1; j<=nextinput; j++){
            total = (parseInt($('#total'+j).val())+parseInt(total));
        }
        $('#table_lote_total').html(total.toLocaleString('es-ES'));
        $('#table_lote_total_serie').html(total.toLocaleString('es-ES'));
    }
}


//ToDo - $.ajax dañado en inventario - Revisar!
function disponible(index) {
    var pro = $("#id_producto" + index).find(":selected").val();
    var des = $("#origen").find(":selected").val();
    $.ajax({
        type: 'POST',
        url: 'traslados/unidades_disponible',
        data: {'id_producto': pro, 'destino': des},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success){
                var r = obj.result;
                if (r.length > 0) {
                    var sumaProducto = 0;
                    $.each(r, function (indice, valor) {
                        sumaProducto = parseInt(valor[indice].saldo) + parseInt(sumaProducto);
                    });
                    $("#disponible" + index).val(sumaProducto);
                    $('#disponible' + index).val(($('#disponible' + index).val() - $('#total' + index).val()));
                    if($('#disponible' + index).val()<0){alert('Te volviste loco! no puedes enviar mas porque no tienes!')}
                }
            }else{
                $("#disponible" + index).val(0);
            }

        }
    });
}
//----------------------------------//
function AgregarCampos_lote(){
    nextinput++;
    campo = '<tr id="campo'+nextinput+'">'+
        '<td  class="align-middle"><a href="#" onclick="elimCamp('+nextinput+')"><i class="ui-icon fa fa-trash red" aria-hidden="true"></i></a></td>'+
        '<td  class="align-middle">'+nextinput+'</td>'+
        '<td>' +
        '<select class="form-control" name="id_categoria[]'+nextinput+'" id="id_categoria'+nextinput+'" onchange="loadTipo('+nextinput+')">'+
        '<option value="">Seleccione un proyecto</option>'+
        '</select>' +
        '</td>'+

        '<td>'+
        '<select class="form-control" name="id_tipo[]'+nextinput+'" id="id_tipo'+nextinput+'" onchange="loadProducto('+nextinput+')">'+
        '<option value="">Seleccione un proyecto</option>'+
        '</select>'+
        '</td>'+
        '<td>'+
        '<select class="form-control" name="id_producto[]'+nextinput+'" id="id_producto'+nextinput+'" onchange="disponible('+nextinput+')">'+
        '</select>'+
        '</td>'+
        '<td>' +
        '<span class="block input-icon input-icon-right">'+
        '<input type="number" id="disponible'+nextinput+'" class="form-control" readonly>'+
        '<i class="ace-icon fa fa-info-circle open-event2" title="Unides disponibles"></i>'+
        '</span>'+
        '</td>'+
        '<td><input type="number" name="cant_lote[]'+nextinput+'" id="cant_lote'+nextinput+'" class="form-control"></td>'+
        '<td><input type="number" name="cant_unidades[]'+nextinput+'" id="cant_unidades'+nextinput+'" class="form-control" onchange="suma();sumaTotales();disponible('+nextinput+')"></td>'+
        '<td><input type="number" name="total[]'+nextinput+'" id="total'+nextinput+'" class="form-control" readonly></td>' +
        '</tr>';
    $("#campos_lote").append(campo);
    loadCategoria(nextinput);
    $(".open-event2").tooltip({
        show: null,
        position: {
            my: "left top",
            at: "left bottom"
        },
        open: function( event, ui ) {
            ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
        }
    });
}  //
function elimCamp(id) {
    bootbox.confirm('Seguro que desea eliminar este renglón?', function (r) {
        if(r) {
            $('#campo'+id+'').remove();
        }
    });
}         //
//----------------------------------//
function AgregarCampos_serie(){
    nextinput++;

    campo_serie = '<tr id="campo'+nextinput+'">'+
        '<td  class="align-middle"><a href="#" onclick="elimCamp_serie('+nextinput+')"><i class="ui-icon fa fa-trash red" aria-hidden="true"></i></a></td>'+
        '<td  class="align-middle">'+nextinput+'</td>'+
        '<td>' +
        '<select class="form-control" name="id_categoria[]'+nextinput+'" id="id_categoria'+nextinput+'"  data-live-search="true" onchange="loadTipo('+nextinput+')">'+
        '<option value="">Seleccione un proyecto</option>'+
        '</select>' +
        '</td>'+

        '<td>'+
        '<select class="form-control" name="id_tipo[]'+nextinput+'" id="id_tipo'+nextinput+'"  data-live-search="true" onchange="loadProducto('+nextinput+')">'+
        '<option value="">Seleccione un proyecto</option>'+
        '</select>'+
        '</td>'+
        '<td>'+
        '<select class="form-control" name="id_producto[]'+nextinput+'" id="id_producto'+nextinput+'" onchange="disponible('+nextinput+')">'+
        '</select>'+
        '</td>'+
        '<td>' +
        '<span class="block input-icon input-icon-right">'+
        '<input type="number" id="disponible'+nextinput+'" class="form-control" readonly>'+
        '<i class="ace-icon fa fa-info-circle open-event2" title="Unides disponibles"></i>'+
        '</span>'+
        '</td>'+
        '<td style="display:none"><input type="hidden" name="cant_lote[]'+nextinput+'" id="cant_lote'+nextinput+'" value="0"> </td>'+
        '<td style="display:none"><input type="hidden" name="cant_unidades[]'+nextinput+'" id="cant_unidades'+nextinput+'" value="0"></td>'+
        '<td><input type="number" name="total[]'+nextinput+'" id="total'+nextinput+'" min="1" class="form-control" onkeyup="sumaTotales();disponible('+nextinput+')"></td>' +
        '</tr>';
    $("#campos_serie").append(campo_serie);
    loadCategoria(nextinput);
    $(".open-event2").tooltip({
        show: null,
        position: {
            my: "left top",
            at: "left bottom"
        },
        open: function( event, ui ) {
            ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
        }
    });

} //
function elimCamp_serie(id) {
    bootbox.confirm('Seguro que desea eliminar este renglón?', function (r) {
        if(r) {
            $('#campo'+id+'').remove();
        }
    });
}   //
//----------------------------------//

//invoice
function loadInvoice() {
    $("#invoice_documento").empty(); //Nota de entrega
    $("#invoice_fecha").empty(); //Fecha de N/E
    $("#invoice_origenSelect").empty(); //Origen
    $("#invoice_origen").empty(); //Destino
    $("#invoice_chofer").empty(); //Chofer
    $("#invoice_vehiculo").empty(); //Vehiculo
    $("#invoice_destino").empty(); //Proyecto
    $("#invoice_proyecto").empty(); //Productos
    $("#invoice_result").empty(); //Productos
    $("#invoice_total").empty(); //cant Productos
    $("#invoice_comentario").empty(); //comentario
    //Asignacion de datos en Invoice
    if(origen =='Impresor'){
        $("#invoice_origen").append($("#id_impresor option:selected").text());
    }else{
        $("#invoice_origen").append($("#id_proveedor option:selected").text());
    }
    $("#invoice_documento").append($('#documento').val());
    $("#invoice_fecha").append($('#fecha').val());
    $("#invoice_origenSelect").append($("#origen option:selected").text());
    $("#invoice_chofer").append($("#id_chofer option:selected").text());
    $("#invoice_vehiculo").append($("#id_vehiculo option:selected").text());
    $("#invoice_destino").append($("#destino option:selected").text());
    $("#invoice_proyecto").append($("#id_proyecto option:selected").text());
    if($('#comentario').val()==''){
        $("#invoice_comentario").html('NO TIENE COMENTARIOS...');
    }else{
        $("#invoice_comentario").html($('#comentario').val());
    }


    //crear tabla Invoce

    var j=1;
    var total_global = 0;
    for(j; j<=nextinput;j++){
        datos ='<tr>'+
            '<td class="center">'+j+'</td>'+
            '<td>'+$("#id_categoria"+j+" option:selected").text()+'</td>'+
            '<td>'+$("#id_tipo"+j+" option:selected").text()+'</td>'+
            '<td>'+$("#id_producto"+j+" option:selected").text()+'</td>'+
            '<td>'+$("#cant_lote"+j).val()+'</td>'+
            '<td>'+$("#cant_unidades"+j).val()+'</td>'+
            '<td>'+$("#total"+j).val()+'</td>'+
            '</tr>';
        $("#invoice_result").append(datos);
        total_global = (Number($('#total'+j+'').val())+Number(total_global));
    }
    number = parseInt(total_global);
    $('#invoice_total').text(number.toLocaleString('es-ES'));
}
function validateStep_1() {
    var tag = 0;
    if(!$("#origen").find(":selected").val() && !$("#destino").find(":selected").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar <strong>(Origen / Destino)</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(!$("#id_chofer").find(":selected").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar <strong>Datos del Chofer</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(!$("#id_vehiculo").find(":selected").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar <strong>Datos del Vehiculo</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(tag==3){return true}
}
function validateStep_2() {
    console.log(validarDocumento())
    validarDocumento();
    var tag = 0;
    if(!$("#destino").find(":selected").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar <strong>Almacén de Destino</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(!$("#id_proyecto").find(":selected").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta Seleccionar <strong>Proyectos</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(!$("#fecha").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar <strong>Fecha</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(!$("#documento").val()) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar <strong>N° Nota de Entrega</strong></h4>');
        return false;
    }else{
        tag++
    }
    if(nextinput == 0) {
        bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Falta cargar al menos<strong>1 Producto</strong></h4>');
        return false;
    }else{
        var i;
        var chk = true;
        for(i=1; i <= nextinput; i++){
            //console.log($('#total'+i+'').val());
            if($('#total'+i+'').val() == 0){
                chk = false;
            }
        }
        //console.log(chk)
        if(chk == false){
            bootbox.alert('<h4 class="widget-title lighter"><i class="ace-icon fa fa-exclamation-triangle orange" aria-hidden="true"></i> Tiene campos <strong>Incompletos</strong></h4>');
        }else{
            tag++
        }
    }

    if(tag==5){return true}
}
function limpiarTabla() {
    $("#example tbody").remove("tr");
}
function elimDoc(){
    $("#documento").val('');
}
function validarDocumento() {
    id = $('#documento').val();
    $("#modal-doc").text(id);
    $.ajax({
        type: 'POST',
        url: 'traslados/search_documento',
        data: {'documento': id},
        success:function (data) {
            var obj = jQuery.parseJSON(data);
            if(obj.success){
                var r = obj.result;
                $.each(r, function () {
                    $("#example tbody tr").html('');
                });
                $.each(r, function (indice, valor) {
                    $("#example tbody tr:last").after('<tr>' +
                        '<td>' + (indice + 1) + '</td>' +
                        '<td>' + valor[indice].cod_traslado + '</td>' +
                        '<td>' + valor[indice].fecha + '</td>' +
                        '<td>' + valor[indice].origen + '</td>' +
                        '<td>' + valor[indice].documento + '</td>' +
                        '<td>' + valor[indice].categoria + '</td>' +
                        '<td>' + valor[indice].tipo + '</td>' +
                        '<td>' + valor[indice].producto + '</td>' +
                        '<td>' + valor[indice].cant_lote + '</td>' +
                        '<td>' + valor[indice].cant_unidades + '</td>' +
                        '<td>' + valor[indice].total + '</td>' +
                        '</tr>');
                });
                $('#modal-table').modal('show');
            }else{
                return true
            }
        }
    });
}
function SetDestino(val) {
    var id = val;
    if(id>0){
        $.ajax({
            type: 'POST',
            url: '../almacenes/almacen/LoadDestino',
            success: function (data) {
                $("#destino").empty();
                var obj = jQuery.parseJSON(data);
                var c = obj.result;
                $.each(c, function (indice, valor) {
                    if(valor[indice].id_ubicacion == val){

                    }else{
                        $("#destino").append(
                            $("<option></option>").attr("value", valor[indice].id_ubicacion).text(valor[indice].nombre)
                        );
                    }

                });
            }
        });
    }

}


jQuery(function($) {

    $('[data-rel=tooltip]').tooltip();

    $(".select2").css('width','200px').select2({allowClear:true})
        .on('change', function(){
            $(this).closest('form').validate().element($(this));
        });


    var $validation = false;
    $('#fuelux-wizard-container')
        .ace_wizard({
            //step: 2 //optional argument. wizard will jump to step "2" at first
            //buttons: '.wizard-actions:eq(0)'
        })
        .on('actionclicked.fu.wizard' , function(e, info){
            loadInvoice();
            if(info.step == 1)  if(!validateStep_1()) e.preventDefault();
            if(info.step == 2)  if(!validateStep_2()) e.preventDefault();
        })
        .on('finished.fu.wizard', function(e) {
            bootbox.confirm("Esta conforme con la información a registrar en sistema?", function (result) {
                if (result) {
                    Save()
                }
            });
        }).on('stepclick.fu.wizard', function(e){
        //e.preventDefault();//this will prevent clicking and selecting steps
    });


    //jump to a step
    /**
     var wizard = $('#fuelux-wizard-container').data('fu.wizard')
     wizard.currentStep = 3;
     wizard.setState();
     */

    //determine selected step
    //wizard.selectedItem().step



    //hide or show the other form which requires validation
    //this is for demo only, you usullay want just one form in your application
    $('#skip-validation').removeAttr('checked').on('click', function(){
        $validation = this.checked;
        if(this.checked) {
            $('#sample-form').hide();
            $('#validation-form').removeClass('hide');
        }
        else {
            $('#validation-form').addClass('hide');
            $('#sample-form').show();
        }
    })



    //documentation : http://docs.jquery.com/Plugins/Validation/validate


    $.mask.definitions['~']='[+-]';
    $('#phone').mask('(999) 999-9999');

    jQuery.validator.addMethod("phone", function (value, element) {
        return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
    }, "Enter a valid phone number.");

    $('#validation-form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        rules: {
            email: {
                required: true,
                email:true
            },
            password: {
                required: true,
                minlength: 5
            },
            password2: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            name: {
                required: true
            },
            phone: {
                required: true,
                phone: 'required'
            },
            url: {
                required: true,
                url: true
            },
            comment: {
                required: true
            },
            state: {
                required: true
            },
            platform: {
                required: true
            },
            subscription: {
                required: true
            },
            gender: {
                required: true,
            },
            agree: {
                required: true,
            }
        },

        messages: {
            email: {
                required: "Please provide a valid email.",
                email: "Please provide a valid email."
            },
            password: {
                required: "Please specify a password.",
                minlength: "Please specify a secure password."
            },
            state: "Please choose state",
            subscription: "Please choose at least one option",
            gender: "Please choose gender",
            agree: "Please accept our policy"
        },


        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },

        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
            if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if(element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if(element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element.parent());
        },

        submitHandler: function (form) {
        },
        invalidHandler: function (form) {
        }
    });




    $('#modal-wizard-container').ace_wizard();
    $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');


    /**
     $('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
			$(this).closest('form').validate().element($(this));
		});

     $('#mychosen').chosen().on('change', function(ev) {
			$(this).closest('form').validate().element($(this));
		});
     */


    $(document).one('ajaxloadstart.page', function(e) {
        //in ajax mode, remove remaining elements before leaving page
        $('[class*=select2]').remove();
    });
    $('[data-rel=tooltip]').tooltip();
    $('[data-rel=popover]').popover({html:true});
})
/**
 * Created by Jasp402 on 12/12/2016.
 */
