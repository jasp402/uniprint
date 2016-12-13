<?php echo $this->load->view('global_views/header_dashboard'); ?>
<script src="<?=base_url();?>assets/js/ace-extra.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/select2.css" />
<?php 
	$glidus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('form').submit(function(event) {
			event.preventDefault();
		});
		localStorage.clear();

			// cuando cambia el valor del padre hacemos lo mismo con sus hijos
			$('.padre_menu input[type=checkbox]').change(function() {
			  $(this).closest('.padre_menu').next('ul').find('.hijo_menu input[type=checkbox]').prop('checked', this.checked);
			});


			// cuando cambia el valor de un hijo determinamos si el padre debe ser 'chequeado' o no
			$('.hijo_menu input[type=checkbox]').change(function() {
			  var closestUl = $(this).closest('ul');
			  var checkedParent = true;
			  if(closestUl.find('input[type=checkbox]:checked').length == 0) {
			    checkedParent = false;
			  }
			  
			  closestUl.prev('.padre_menu').find('input[type=checkbox]').prop('checked', checkedParent);
			});

			$('#us_pc_permiso').on('change', function() {
				var id = this.value;
			  	$.ajax({
			  	  url: 'ajustes/cargar_menu_usuario',
			  	  type: 'POST',
			  	  dataType: 'json',
			  	  data: {id:id},
			  	  beforeSend: function() {
			  	    $('#us_pc_permiso').attr('disabled', 'disabled');
			  	  },
			  	  success: function(data) {
			  	    if (data.success == true){
			  	    	$('input[type=checkbox]').each(function(){ 
							this.checked = false; 
						});
			  	    	var p = data.menu;
			  	    	var padre = [];
			  	    	var hijo = []; 
			  	    	$("input[name='padre[]']").each(function(){padre.push($(this).val());});
			  	    	$("input[name='hijo[]']").each(function(){hijo.push($(this).val());});
			  	    	var padre_hijo = padre.concat(hijo);

			  	    	for (var i = 0; i <p.length; i++) {
			  	    		if(p[i] in padre_hijo){
								$('input[type=checkbox][value='+p[i]+']').prop('checked',true);
							}
			  	    	}
			  	    	setTimeout(function() {$('#us_pc_permiso').removeAttr('disabled');}, 300);
			  	    	
			  	    }else{
			  	    	$('input[type=checkbox]').each(function(){ 
							this.checked = false; 
						});
						setTimeout(function() {$('#us_pc_permiso').removeAttr('disabled');}, 300); 
			  	    }
			  	  }
			  	});
			});
		
	});

	function div_form_empresa() {
		$('#div_empresa').hide(200);
		$('#div_form_empresa').show(200);
	}

	function volver_div_empresa() {
		$('#div_form_empresa').hide(200);
		$('#div_empresa').show(200);
	}

	/*================================
	=            Usuarios            =
	================================*/

		function agregar_user_package(){
			$('#div_update_user').hide(200);
			$('#div_agregar_user').show(250);
			setTimeout(function() {mover_vista_top('btn_save_new_user');}, 400);
		}
		function save_user_package(){
			var DNI = $('#DNI').val();
			var us_pc_password_2 = $('#us_pc_password_2').val();
			if(DNI == "" || us_pc_password_2 == ""){
				alert("Complete los campos");
			}else{
				$.ajax({
				  url: 'ajustes/guardar_usuario',
				  type: 'POST',
				  dataType: 'json',
				  data: $('#form_user_save').serialize(),
				  beforeSend: function(){
					desactivar_inputs('form_user_save');
					mensaje_gbl('Procesando...','info','clock-o','mensaje_user_crud_package');
				  },
				  success: function(data) {
				    switch(data.success){

				    	case true:
				    		mover_vista_top('mensaje_user_crud_package');
				    		mensaje_gbl('Usuario Registrado correctamente','success','check','mensaje_user_crud_package');
				    		setTimeout(function(){location.reload();},1000);
				    	break;

				    	default:
				    		mover_vista_top('mensaje_user_crud_package');
				    		mensaje_gbl('Error, por favor verifique...','danger','times','mensaje_user_crud_package');
				    		activar_inputs('form_user_save');
							setTimeout(function(){$('#mensaje_user_crud_package').empty();},4500);
				    }
				  }
				});
			}
		}

		function delete_user_package(id,user){
			bootbox.confirm("Estas seguro que deseas eliminar al personal <b>"+user+"</b> ?, Recuerda que no se podr&aacute; recuperar y todo los datos ser&aacute;n eliminados definitivamente", function(result) {
				if(result) {
					$.ajax({
					  url: 'ajustes/eliminar_user_package',
					  type: 'POST',
					  dataType: 'json',
					  data: {id:id},
					  success: function(data) {
					  	if (data.success == true){
					  		bootbox.dialog({
							message: "<span class='bigger-110 red'>Usuario <b>"+user+"</b> eliminado</span>"
							});
							setTimeout(function(){location.reload();},1500);
					  	}else{
					  		bootbox.dialog({
							message: "<span class='bigger-110 blue'>No se pudo eliminar a <b>"+user+"</b> Por favor, contact&eacute; al administrador del sistema.</span>"
							});
					  	}
					  }
					});	
				}
			});
		}

		function div_up_user_package(id){
			$('#div_agregar_user').hide(200);
			$('#div_update_user').show(250);
			$.ajax({
			  url: 'ajustes/form_inputs_ususario',
			  type: 'POST',
			  dataType: 'json',
			  data: {id: id},
			  success: function(data) {
			  	if (data.success == true){
			  		var p = data.user;

			  		$('#us_up_pc_nombre').val(p.nombre);
			  		$('#us_up_pc_direccion').val(p.direccion);
			  		$('#us_up_pc_telefono').val(p.telefono);
			  		$('#us_up_pc_id').val(id);
			  		$('#nombre_ac_cab').html(p.nombre);

			  		var select_con = "";
			  			select_con += "<select class='form-control' id='us_up_pc_acceso'>";
				  		if (p.acceso == 1){
				  			select_con += "<option value='0'>Restringido</option>";
				  			select_con += "<option value='1' selected>Permitido</option>";
				  		}else{
				  			select_con += "<option value='0' selected>Restringido</option>";
				  			select_con += "<option value='1'>Permitido</option>";
				  		}
				  		select_con += "</select>";
				  		$('#select_up_us').html(select_con);

				  		setTimeout(function() {mover_vista_top('btn_save_update_user');}, 400);

			  	}else{
			  		mensaje_gbl('Error, por favor intente luego...','danger','times','mensaje_user_crud_package');
			  	}
			  }
			});
		}

		function save_up_us_package(){
			var nombre    = $('#us_up_pc_nombre').val().trim();
			var direccion = $('#us_up_pc_direccion').val().trim();
			var telefono  = $('#us_up_pc_telefono').val().trim();
			var password  = $('#us_up_pc_pass').val().trim();
			var acceso    = $('#us_up_pc_acceso').val();
			var id        = $('#us_up_pc_id').val();
			$.ajax({
			  url: 'ajustes/save_form_inputs_ususario',
			  type: 'POST',
			  dataType: 'json',
			  data: {nombre: nombre, direccion: direccion, telefono: telefono, password: password, acceso: acceso, id: id },
			  beforeSend: function() {
			  	desactivar_inputs('form_update_user');
				mensaje_gbl('Procesando...','info','clock-o','mensaje_user_crud_package');
			  },
			  success: function(data) {
			    if (data.success == true){
			    	mensaje_gbl('Datos Cambiados','success','check','mensaje_user_crud_package');
			    	setTimeout(function(){location.reload();},1500);
			    }else{
			    	mensaje_gbl('Error, por favor intente luego...','danger','times','mensaje_user_crud_package');
			    	activar_inputs('form_update_user');
			    }
			  }
			});
		}

		function save_permisos_user(){
			if ($('#us_pc_permiso').val() == ""){
				mensaje_gbl('Por favor seleccione el personal...','info','exclamation-triangle','mensaje_save_permisos_package');
				setTimeout(function() {mover_vista_top('mensaje_save_permisos_package');}, 400);
			}else{
				$('#save_permisos_user').prop('disabled', true);
				$.ajax({
				  url: 'ajustes/save_new_permisos',
				  type: 'POST',
				  dataType: 'json',
				  data: $('#id_padre:checked,#id_hijo:checked,#us_pc_permiso').serialize(),
				  beforeSend: function(){
				  	mensaje_gbl('Procesando...','info','clock-o','mensaje_save_permisos_package');
				  },
				  success: function(data) {
				    if (data.success == true){
				    	mensaje_gbl('Permisos Cambiados','success','check','mensaje_save_permisos_package');
				    	setTimeout(function() {$('#save_permisos_user').prop('disabled', false);}, 1500);
				    	setTimeout(function(){$('#mensaje_save_permisos_package').empty();},4500);
				    }else{
				    	mensaje_gbl('Error, por favor intente luego...','danger','times','mensaje_save_permisos_package');
				    	$('#save_permisos_user').prop('disabled', false);
				    }
				    setTimeout(function() {mover_vista_top('mensaje_save_permisos_package');}, 400);
				  }
				});
			}
		}

	
</script>
<style type="text/css">
	.profile-info-name{
		width: 150px !important;
	}
</style>
</head>
<?php echo $this->load->view('global_views/contenedor');?>
<div class="page-header">
	<h1>
		<i class="fa fa-cogs grey"></i>
		Configuración general
		<small>
			<i class="fa fa-angle-double-right"></i>
			Datos generales de la empresa
		</small>
	</h1>
</div>
<div class="space-12"></div>
<div class="col-sm-12">
	<div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
			<li class="active">
				<a data-toggle="tab" href="#usuarios_l" aria-expanded="true">
					<i class="purple ace-icon fa fa-users bigger-120"></i>
					Usuarios
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#roles_l" aria-expanded="false">
					<i class="brown ace-icon fa fa-sort-amount-desc bigger-120"></i>
					Permisos
				</a>
			</li>
		</ul>

		<div class="tab-content">

			<div id="usuarios_l" class="tab-pane fade active in">
				<button class="btn btn-white btn-info btn-bold" onclick="javascript:agregar_user_package();">
						<i class="ace-icon fa fa-plus bigger-120 blue"></i>
						Agregar Usuario
				</button>
				<div class="space-8"></div>
					<table id="simple-table" class="table  table-bordered table-hover">
						<thead>
							<tr>
								<th>Nombre</th>
								<th class="hidden-480">Correo</th>
								<th class="hidden-320">Perfil</th>
								<th>Acceso</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
						<?php foreach ($userBy as $userByEmp): ?>
							<tr>
								<td><?=$userByEmp->nombre;?></td>
								<td class="hidden-480"><?=$userByEmp->correo;?></td>
								<td class="hidden-320"><?=$userByEmp->perfil;?></td>
								<?php if ($userByEmp->condicion == 1): ?>
									<td><span class="label label-sm label-success">Permitido</span></td>
								<?php else: ?>
									<td><span class="label label-sm label-warning">Restringido</span></td>
								<?php endif ?>
								<td>
									<?php if ($userByEmp->id_perfil > 2): ?>
									<div class="hidden-sm hidden-xs btn-group">
										<button class="btn btn-xs btn-info" onclick="javascript:div_up_user_package('<?=url_enco($this->encrypt->encode($userByEmp->id_usuario));?>')" data-rel="tooltip" data-placement="top" data-original-title="Modificar datos y accesos del usuario">
											<i class="ace-icon fa fa-pencil bigger-120"></i>
										</button>
										<button class="btn btn-xs btn-danger" onclick="javascript:delete_user_package('<?=url_enco($this->encrypt->encode($userByEmp->id_usuario));?>','<?=$userByEmp->nombre;?>')" data-rel="tooltip" data-placement="top" data-original-title="Eliminar definitivamente al usuario">
											<i class="ace-icon fa fa-trash-o bigger-120"></i>
										</button>
									</div>
									<div class="hidden-md hidden-lg">
										<div class="inline pos-rel">
											<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
												<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
											</button>
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
												<li>
													<a href="#" onclick="div_up_user_package('<?=url_enco($this->encrypt->encode($userByEmp->id_usuario));?>')" class="tooltip-info" data-rel="tooltip" title="Editar">
														<span class="green">
															<i class="ace-icon fa fa-pencil bigger-120"></i>
														</span>
													</a>
												</li>
												<li>
													<a href="#" onclick="delete_user_package('<?=url_enco($this->encrypt->encode($userByEmp->id_usuario));?>','<?=$userByEmp->nombre;?>')" class="tooltip-info" data-rel="tooltip" title="Eliminar">
														<span class="warning">
															<i class="ace-icon fa fa-trash bigger-120"></i>
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
									<?php else: ?>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				
					<div class="row" id="div_agregar_user" style="display:none;">
						<div class="hr hr-18 hr-double dotted"></div>
						<div class="col-xs-12 center">
							<span class="bigger-140 blue">Agregar personal al sistema</span>
						</div><br/>
						<div class="hr hr-18 hr-double dotted"></div>
						<form id="form_user_save" class="form-horizontal" method="post" novalidate="novalidate">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label col-xs-12 col-sm-5 no-padding-right">DNI:</label>

									<div class="col-xs-12 col-sm-7">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-list-alt"></i>
											</span>
											<input type="number" name="DNI" id="DNI" class="col-xs-12 col-sm-3">
										</div>
									</div>
								</div>
							</div>			
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label no-padding-right"> Nombre: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-user grey bigger-110"></i>
											</span>
											<input class="form-control" type="text" name="us_pc_nombre" id="us_pc_nombre">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label no-padding-right"> Dirección: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-map-marker grey bigger-110"></i>
											</span>
											<input maxlength="500" class="form-control" type="text" name="us_pc_direccion" id="us_pc_direccion">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label no-padding-right"> Telefono: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-phone grey bigger-110"></i>
											</span>
											<input class="form-control" type="phone" name="us_pc_telefono" id="us_pc_telefono">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Correo: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-envelope grey bigger-110"></i>
											</span>
											<input maxlength="256" class="form-control" type="email" name="email" id="email">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Clave: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-key grey bigger-110"></i>
											</span>
											<input class="form-control" type="password" name="us_pc_password" id="us_pc_password">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Confirmar Clave:  </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-key grey bigger-110"></i>
											</span>
											<input maxlength="500" class="form-control" type="password" id="us_pc_password_2" name="us_pc_password_2">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 center">
								<button class="btn btn-primary" id="btn_save_new_user" onclick="javascript:save_user_package();">
								<i class="fa fa-save bigger-120"></i>
								Registrar</button>
							</div>
						</form>
					</div>
					<div class="row" id="div_update_user" style="display:none">
						<div class="hr hr-18 hr-double dotted"></div>
						<div class="col-xs-12 center">
							<span class="bigger-140 brown">Actualizar datos de <b><span id="nombre_ac_cab" class="red"></span></b></span>
						</div><br/>
						<div class="hr hr-18 hr-double dotted"></div>
						<?php echo form_open('', "id='form_update_user' class='form-horizontal'"); ?>
							<input type="hidden" value="" id="us_up_pc_id">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-4 control-label no-padding-right"> Acceso: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-unlock grey bigger-110"></i>
											</span>
											<div id="select_up_us"></div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label no-padding-right"> Dirección: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-map-marker grey bigger-110"></i>
											</span>
											<input maxlength="500" class="form-control" type="text" name="us_up_pc_direccion" id="us_up_pc_direccion">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label no-padding-right"> Telefono: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-phone grey bigger-110"></i>
											</span>
											<input class="form-control" type="phone" name="us_up_pc_telefono" id="us_up_pc_telefono">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Nombre: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-user grey bigger-110"></i>
											</span>
											<input class="form-control" type="text" name="us_up_pc_nombre" id="us_up_pc_nombre">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Clave: </label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="ace-icon fa fa-key grey bigger-110"></i>
											</span>
											<input class="form-control" type="password" name="us_up_pc_pass" id="us_up_pc_pass">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 center">
								<button onclick="javascript:save_up_us_package();" class="btn btn-warning" id="btn_save_update_user">
								<i class="fa fa-pencil bigger-120"></i>
								Guardar Cambios</button>
							</div>
							<div class="col-xs-12 col-sm-12 center"><br></div>
							<div class="col-md-12">
								<div class="well well-sm grey">
									<i class="ace-icon fa fa-asterisk red bigger-125"></i>
									El correo electronico no puede ser modificado, si quieres modificar el correo electronico, por favor, elimine al personal y vuelva a registrarlo.
								</div>
								<div class="well well-sm grey">
									<i class="ace-icon fa fa-asterisk red bigger-125"></i>
									Si quiere que el personal <b>NO ENTRE</b> al sistema, puede cambiar el acceso a "Restringido".
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
					<div class="space-8"></div>
					<div class="row" id="mensaje_user_crud_package"></div>
			</div>

			<div id="roles_l" class="tab-pane fade">
				<div class="row">
					<div class="col-sm-12 center">
						<div class="widget-box transparent">
							<div class="widget-header widget-header-large">
								<h3 class="widget-title grey lighter">
									<i class="ace-icon fa fa-plus-circle green"></i>
									Administraci&oacute;n de Permisos
								</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="input-group">
							<span class="input-group-addon">
							<i class="fa fa-user bigger-110 brown"></i>
							</span>
							<select class="form-control" id="us_pc_permiso" name="us_pc_permiso">
								<option value="">Seleccione al personal</option>
								<?php foreach ($userBy as $userByPermisos): ?>
									<?php if ($userByPermisos->id_perfil == 3): ?>
										<option value="<?=url_enco($this->encrypt->encode($userByPermisos->id_usuario));?>"><?=$userByPermisos->nombre?></option>
									<?php endif ?>
								<?php endforeach ?>
							</select>
						</div>
						<div class="widget-box widget-color-blue2">
							<div class="widget-header">
								<h4 class="widget-title lighter smaller">Seleccionar Permisos</h4>
							</div>

							<div class="widget-body">
								<div class="widget-main padding-8">
								<ul>
								<?php $glMenu = $this->global_model->getOnlyMenu();?>
									<?php foreach ($glMenu as $key_m): ?>
										<?php if ($key_m['MenParentId'] == 0): ?>
												<li class="padre_menu">
												<div class="checkbox">
													<label>
														<input name="padre[]" type="checkbox" class="ace ace-checkbox-2" id="id_padre" value="<?=$key_m['id_menu']?>">
														<span class="lbl"> <?=$key_m['MenNavegacion'];?></span>
													</label>
												</div>
												</li>
											<?php $glSubMenu = $this->global_model->getOnlyMenuByHijo($key_m['id_menu']); ?>
											<?php if ($glSubMenu): ?>
												<ul>
												<?php foreach ($glSubMenu as $key_sm): ?>
													<?php if ($key_m['id_menu'] == $key_sm['MenParentId']): ?>
														
															<li class="hijo_menu">
															<div class="checkbox">
																<label>
																	<input name="hijo[]" type="checkbox" id="id_hijo" class="ace" value="<?=$key_sm['id_menu']?>">
																	<span class="lbl"> <?=$key_sm['MenNavegacion'];?></span>
																</label>
															</div>
															</li>
														
													<?php else: ?>
													<?php endif ?>
													
												<?php endforeach ?>
												</ul>
											<?php endif ?>
											
										<?php endif ?>
									<?php endforeach ?>
								</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-8 center">
						<i class="fa fa-cogs fa-6 hidden-480" style="font-size: 35em" aria-hidden="true"></i>
					</div>
					<div class="space-8"></div>
					<div class="col-xs-12 col-sm-12 center">
						<br/>
						<button id="save_permisos_user" class="btn btn-primary" onclick="javascript:save_permisos_user();">
							<i class="fa fa-save bigger-120"></i>
							Guardar</button><br/>
					</div>
					<div class="col-xs-12 col-sm-12 center">
						<br/>
					</div>
					<div id="mensaje_save_permisos_package"></div>
				</div>
			</div>
		</div>
	</div>
</div>

		<script src="<?=base_url()?>assets/js/fuelux/fuelux.tree.js"></script>
		<script src="<?=base_url()?>assets/js/fuelux/fuelux.wizard.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.validate.js"></script>
		<script src="<?=base_url()?>assets/js/additional-methods.js"></script>
		<script src="<?=base_url()?>assets/js/bootbox.js"></script>
		<script src="<?=base_url()?>assets/js/jquery.maskedinput.js"></script>
		<script src="<?=base_url()?>assets/js/select2.js"></script>
		<script src="<?=base_url()?>assets/js/ace/elements.typeahead.js"></script>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var $validation = true;
				$.mask.definitions['~']='[+-]';
				$('#us_pc_telefono').mask('999-999-999');
				jQuery.validator.addMethod("lettersonly", function(value, element) {
					return this.optional(element) || /^[a-z," "]+$/i.test(value);
				}, "Este campo solo acepta letras");
				jQuery.validator.addMethod("numbersonly", function(value, element) {
					return this.optional(element) || /^[0-9," "]+$/i.test(value);
				}, "Este campo solo acepta numeros"); 

				$('#form_user_save').validate({
					errorElement: 'div',
					errorClass: 'help-block',
					focusInvalid: false,
					ignore: "",
					rules: {
						DNI:{
							required: true,
							minlength: 8,
							maxlength: 10,
							remote: {
								url: "<?=base_url()?>login/registro/validate_DNI",
								type: "post"
							}
						},
						us_pc_nombre:{
							required: true,
							lettersonly: true
						},
						email: {
							required: true,
							email:true,
							remote: {
								url: "<?=base_url()?>login/registro/validate_email",
								type: "post"
							}
						},
						us_pc_password: {
							required: true,
							minlength: 5,
							maxlength: 20
						},
						us_pc_password_2: {
							required: true,
							equalTo: "#us_pc_password"
						}
					},

					messages: {
						us_pc_nombre: {
							required: "Por favor ingresa el nombre"
						},
						DNI: {
							required: "Por favor ingresa el DNI",
							remote: "Este DNI ya existe"
						},
						email: {
							required: "Por favor ingresa el correo",
							email: "El correo tiene que ser valido",
							remote: "Este correo ya existe"
						}
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
						// save_user_package();
						// alert("asd");
					},
					invalidHandler: function (form) {
					}
				});
			});
		</script>
<?php $this->load->view('global_views/footer_dashboard');?>