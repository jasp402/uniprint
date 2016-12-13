
		<script type="text/javascript" src="<?=base_url();?>assets/js/spin.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('form').submit(function(event) {
					event.preventDefault();
				});
				$('#alert_login_danger').css('display', 'none');
				$('#alert_login_success').css('display', 'none');
				$('#alert_login_warning').css('display', 'none');
				$('#alert_login_acceso').css('display', 'none');
			});
			function iniciar_sesion(){
				$('#alert_login_danger').css('display', 'none');
				$('#alert_login_warning').css('display', 'none');
				var correo_log = $('#correo_log').val();
				var id_form = 'form_login';
				if (ValidarCorreo(correo_log)) {
					$.ajax({
					  url: 'login/home/validar',
					  type: 'POST',
					  dataType: 'json',
					  data: $('#form_login').serialize(),
					  beforeSend: function() {
					  	disa_form(id_form);
					  	$(".spin_back").css("opacity", 0.2);
					  	$("#icon_spin_load").css({"display": "block"});
					  },
					  success: function(data) {
					  	$(".spin_back").css("opacity", 1);
					  	$("#icon_spin_load").css({"display": "none"});
					    if (data.success == true) {
					    	$('#alert_login_success').css('display', 'block');
					    	setTimeout(function() {window.location.replace('dashboard/inicio');}, 1000);
					    }else if (data.success == "RESTRINGIDO"){
					    	$('#alert_login_danger').css('display', 'none');
					    	$('#alert_login_acceso').css('display', 'block');
					    }else{
					    	$('#alert_login_danger').css('display', 'block');
					    	ena_form(id_form);
					    }
					  }
					});
				}else{
					$('#alert_login_warning').css('display', 'block');
				}
				
			}

			function recuperar_clave(){
				var correo = $('#correo_recuperar').val();
				if (ValidarCorreo(correo.trim())) {
					desactivar_inputs('body_recuperar');
					$.ajax({
					  url: 'login/home/recuperar',
					  type: 'POST',
					  dataType: 'json',
					  data: {correo: correo},
					  beforeSend: function(xhr, textStatus) {
					    $(".spin_back").css("opacity", 0.2);
					  	$("#icon_spin_load").css({"display": "block"});
					  },
					  success: function(data) {
					  	$(".spin_back").css("opacity", 1);
					  	$("#icon_spin_load").css({"display": "none"});
					  	if (data.success == true) {
					  		mensaje_gbl('Se ha enviado la clave a su correo...','success','check','mensaje_recuperar');
					  	}else{
					    	mensaje_gbl('Este correo no existe!','danger','times','mensaje_recuperar');
					    	activar_inputs('body_recuperar');
					    	$('#correo_recuperar').val("");
					  	}
					  }
					});
					
				}else{
					mensaje_gbl('Correo incorrecto...','warning','exclamation-triangle','mensaje_recuperar');
				}
			}

			function mostrar_body_principal(){
				$(".body_recuperar").hide(200);
				$(".body_principal").show(200);
			}
			function mostrar_body_recuperar(){
				$(".body_principal").hide(200);
				$(".body_recuperar").show(200);
			}
		</script>
		<style type="text/css">
			#icon_spin_load {
				display: none;
				height: 100px;
				width: 100px;
				position: absolute;
				top: 40%;
				left: 1%;
				right: 1%;
				margin: auto;
				text-align: center;
			}
		</style>