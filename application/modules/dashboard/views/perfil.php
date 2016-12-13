<?php echo $this->load->view('global_views/header_dashboard'); ?>
<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-ui.custom.css" />
<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery.gritter.css" />
<link rel="stylesheet" href="<?=base_url();?>assets/css/select2.css" />
<script type="text/javascript">
	$(document).ready(function() {
		$('form').submit(function(event) {
			event.preventDefault();
		});
	});
	function guardar_perfil(){
		$('#mensaje_perfil_guardar').empty();
		var id_form      = 'form_subir';
		var id_contenido = 'home';
		var formData     = new FormData($("#form_subir")[0]);
		disa_form(id_form);
		jQuery.ajax({
		  url: 'perfil/guardar',
		  type: 'POST',
		  dataType: 'json',
		  contentType: false,
		  processData: false,
		  cache: false,
		  data: formData,
		  success: function(data) {
		  	if (data.success == true){
		  		desactivar_inputs(id_contenido);
					var tipo    = data.tipo_msj;
					var icono   = data.icono;
					var mensaje = data.mensaje;
			  	mensaje_perfil(tipo,icono,mensaje);
			  	setTimeout(function(){location.reload();},1000);
			  }else{
			  	ena_form(id_form);
					var tipo    = data.tipo_msj;
					var icono   = data.icono;
					var mensaje = data.mensaje;
			  	mensaje_perfil(tipo,icono,mensaje);
			  }
		  	
		  }
		});
	}

	function mensaje_perfil(tipo,icono,mensaje){
		var msj = "<div class='pull-left alert alert-"+tipo+" btn-sm' id='alert_login_danger'><strong><i class='ace-icon fa fa-"+icono+"'></i>"+mensaje+"</strong></div>";
		$('#mensaje_perfil_guardar').html(msj);
	}

	function mensaje_pass(tipo,icono,mensaje){
		var msj = "<div class='pull-left alert alert-"+tipo+" btn-sm' id='alert_login_danger'><strong><i class='ace-icon fa fa-"+icono+"'></i> "+mensaje+"</strong></div>";
		$('#mensaje_pass_guardar').html(msj);
	}

	function mostrar_editar(){
		$('.datos_actual').hide(200);
		$('.datos_editar').show(200);
	}

	function volver_actual(){
		$('.datos_editar').hide(200);
		$('.datos_actual').show(200);
	}

	function guardar_password(){
		desactivar_inputs('form_pass');
		$('#mensaje_pass_guardar').html("");
		var n_pass  = $('#n_pass').val().trim();
		var vn_pass = $('#vn_pass').val().trim();
		var pass_ac = $('#pass_actual').val().trim();
		if (pass_ac == "") {
			mensaje_pass('info','exclamation-triangle','El password Actual no puede estar vacio...');
			activar_inputs('form_pass');
		}else{
			if (n_pass == vn_pass){
				$.ajax({
				  url: 'perfil/guardar_password',
				  type: 'POST',
				  dataType: 'json',
				  data: {n_pass: n_pass, pass_ac:pass_ac},
				  success: function(data) {
				    if (data.success == true){
				  		mensaje_pass(data.tipo_msj,data.icono,data.mensaje);
				    }else{
				    	activar_inputs('form_pass');
				    	mensaje_pass(data.tipo_msj,data.icono,data.mensaje);
				    }
				  }
				});
			}else{
				mensaje_pass('warning','exclamation-triangle','Las nuevas claves no coinciden...');
				$('#form_pass')[0].reset();
				activar_inputs('form_pass');
			}
		}
		
	}

</script>
</head>
<?php echo $this->load->view('global_views/contenedor');?>
<div class="page-header">
	<h1>
		Pagina de Perfil 
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			Actualiza tus datos de la cuenta.
		</small>
	</h1>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="user-profile">
			<div class="tabbable">
				<ul class="nav nav-tabs padding-18">
					<li class="active">
						<a data-toggle="tab" href="#home" aria-expanded="true">
							<i class="green ace-icon fa fa-user bigger-120"></i>
							Perfil
						</a>
					</li>

					<li class="">
						<a data-toggle="tab" href="#feed" aria-expanded="false">
							<i class="blue ace-icon fa fa-key bigger-120"></i>
							Password
						</a>
					</li>
				</ul>
				<div class="tab-content no-border padding-24">
					<div class="tab-content no-border padding-24">
						<div id="home" class="tab-pane active">
							<div class="row datos_actual">
								<div class="col-xs-12 col-sm-3 center">
									<span class="profile-picture">
										<?php 
											if ($perfil['ruta_foto'] == "") {
												$ruta_provi = "perfil_avatar.png";
											}else{
												$ruta_provi = $perfil['ruta_foto'];
											}
										?>
										<img class="img-responsive" id="avatar2" src="<?=base_url()."images/upload/avatar/".$ruta_provi;?>">
									</span>
									<div class="space space-4"></div>
								</div><!-- /.col -->
								<div class="col-xs-12 col-sm-9">
									<h4 class="blue">
										<span class="middle"><?=$perfil['nombre'];?><b> - </b><?=$perfil['perfil'];?></span>
									</h4>

									<div class="profile-user-info">
										<div class="profile-info-row">
											<div class="profile-info-name"> DNI </div>

											<div class="profile-info-value">
												<span><?=$perfil['DNI'];?></span>
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> Telefono </div>
											<div class="profile-info-value">
												<span><?=$perfil['telefono'];?></span>
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> Direccion </div>

											<div class="profile-info-value">
												<i class="fa fa-map-marker light-orange bigger-110"></i>
												<span><?=$perfil['direccion'];?></span>
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> Rango </div>

											<div class="profile-info-value">
												<span><?=$perfil['detalles'];?></span>
											</div>
										</div>
									</div>
								</div><!-- /.col -->
								<div class="col-xs-12 col-sm-9 center">
									<button class="btn btn-sm btn-warning" onclick="javascript:mostrar_editar();">
										<i class="ace-icon fa fa-pencil bigger-110"></i>
										<span class="bigger-110 no-text-shadow">Editar</span>
									</button>
								</div>
							</div><!-- /.row -->
							<div class="row datos_editar" style="display:none;">
								<div class="col-xs-7 col-sm-offset-5 center">
									<div id="mensaje_perfil_guardar"></div>
		                        </div>
								<div class="col-xs-12 col-sm-3 center">
									<div class="col-xs-12">
										<span class="profile-picture">
											<img class="img-responsive" id="avatar2" src="<?=base_url()."images/upload/avatar/".$ruta_provi;?>">
										</span>
										<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Tamaño: 500 KB, 800x600" title="" data-original-title="Imagen aceptable">?</span>
										<?php echo form_open_multipart('',"id='form_subir' "); ?>
										<input type="hidden" name="foto_actual" value="<?=$perfil['ruta_foto'];?>" />
										<input type="file" name="file" id="file" class="id-input-file-2" accept="image/*"/>
									</div>
								</div><!-- /.col -->
								<div class="col-xs-12 col-sm-6">
									<div class="profile-user-info">
										<div class="profile-info-row">
											<div class="profile-info-name"> Nombre </div>
											<div class="profile-info-value">
												<input type="text" name="nombre" value="<?=$perfil['nombre'];?>" maxlength="512">
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> DNI </div>
											<div class="profile-info-value">
												<input readonly type="text" value="<?=$perfil['DNI'];?>">
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> Direccion </div>
											<div class="profile-info-value">
												<input type="text" value="<?=$perfil['direccion'];?>" name="direccion" maxlength="500">
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> Telefono </div>
											<div class="profile-info-value">
												<input type="text" value="<?=$perfil['telefono'];?>" name="telefono" maxlength="25">
											</div>
										</div>

									</div>
								</div><!-- /.col -->
								<div class="col-xs-12 col-sm-10 center">
									<button class="btn btn-sm btn-info" type="button" onclick="javascript:guardar_perfil();">
										<i class="ace-icon fa fa-save bigger-110"></i>
										Guardar
									</button>&nbsp;
									<?php echo form_close(); ?>
									<button class="btn btn-sm btn-danger" onclick="javascript:volver_actual();">
										<i class="ace-icon fa fa-arrow-left bigger-110"></i>
										<span class="bigger-110 no-text-shadow">Volver</span>
									</button>
									<div id="total_1"></div>
								</div>
							</div><!-- /.row -->
						</div><!-- /#home -->
						<div id="feed" class="tab-pane">
							<div class="col-xs-7 col-sm-offset-5 center">
									<div id="mensaje_pass_guardar"></div>
		                       </div>
							<?php echo form_open('', "id='form_pass' class='form-horizontal' "); ?>
								<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right"> Password Actual </label>
									<div class="col-sm-9">
									<span class="input-icon">
										<input id="pass_actual" maxlength="250" data-rel="tooltip" type="password" data-placement="top" data-original-title="Ingresa tu password actual">
										<i class="ace-icon fa fa-key brown"></i>
									</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> Nuevo Password </label>
									<div class="col-sm-9">
									<span class="input-icon">
										<input maxlength="200" id="n_pass" data-rel="tooltip" type="password" data-placement="top" data-original-title="Ingresa tu nuevo password" />
										<i class="ace-icon fa fa-key green"></i>
									</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-3"> Repetir Nuevo Password </label>
									<div class="col-sm-9">
									<span class="input-icon">
										<input maxlength="200" id="vn_pass" data-rel="tooltip" type="password" data-placement="top" data-original-title="vuelve a ingresar tu nuevo password" />
										<i class="ace-icon fa fa-key green" ></i>
									</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-10 center">
								<button class="btn btn-sm btn-primary" type="button" onclick="javascript:guardar_password();">
									<i class="ace-icon fa fa-save bigger-110"></i>
										Guardar Password
								</button>
							</div>
							<?php echo form_close(); ?>
						</div><!-- /#feed -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.id-input-file-2').ace_file_input({
					no_file:'Cargar ...',
					btn_choose:'Escoger',
					btn_change:'Cambiar',
					droppable:false,
					onchange:null,
					thumbnail:false, //| true | large
					whitelist:'gif|png|jpg|jpeg'
					// blacklist:'exe|php'
					//onchange:''
					//
				});
		$('[data-rel=popover]').popover({container:'body'});
	});
</script>
<?php $this->load->view('global_views/footer_dashboard');?>