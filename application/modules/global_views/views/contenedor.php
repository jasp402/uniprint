<?php 
	$glidus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
	$glquery = $this->global_model->getAll_byID($glidus);
		foreach ($glquery as $row) {
			$glruta_foto   = $row->ruta_foto;
			$glnombre      = $row->nombre;
			$glcorreo      = $row->correo;
			$gltipo_perf   = $row->id_perfil;
			$glskin        = $row->skin;
			$gltipo_menu   = $row->tipo_menu;
			$gltipo_menu_a = $row->tipo_menu_activo;
			$gltm_compac_h = $row->tm_compact_hover;
		}
	$glMenu = $this->global_model->getAll_Menu_byID($glidus);
	// if ($glskin == "") {
	// 	redirect(base_url('login/home/salir'));
	// }
?>
<body class="<?=$glskin;?>">
	<!-- #section:basics/navbar.layout -->
	<div id="navbar" class="navbar navbar-default">
		<script type="text/javascript">
			try{ace.settings.check('navbar' , 'fixed')}catch(e){}
		</script>

		<div class="navbar-container" id="navbar-container">
			<!-- #section:basics/sidebar.mobile.toggle -->
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Navegador</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<!-- /section:basics/sidebar.mobile.toggle -->
			<div class="navbar-header pull-left">
				<!-- #section:basics/navbar.layout.brand -->
				<a href="<?=base_url();?>" class="navbar-brand">
					<small>
						<i class="fa fa-building"></i>
						UNIPRINT S.A.
					</small>
				</a>
			</div>

			<!-- #section:basics/navbar.dropdown -->
			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<!-- #section:basics/navbar.user_menu -->
					<li class="light-blue">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<?php 
							if ($glruta_foto == "") {
								$ruta_provi = "perfil_avatar.png";
							}else{
								$ruta_provi = $glruta_foto;
							}
							?>
							<img class="nav-user-photo" src="<?=base_url()."images/upload/avatar/".$ruta_provi; ?>">
							<span class="user-info">
								<small><b>Bienvenido(a),</b></small>
								<?=$glnombre;?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>

						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="<?=base_url()?>dashboard/perfil">
									<i class="ace-icon fa fa-user"></i>
									Perfil
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a href="<?=base_url()?>login/home/salir">
									<i class="ace-icon fa fa-power-off"></i>
									Desconectar
								</a>
							</li>
						</ul>
					</li>

					<!-- /section:basics/navbar.user_menu -->
				</ul>
			</div>
			<!-- /section:basics/navbar.dropdown -->
		</div><!-- /.navbar-container -->
	</div>
	<!-- /section:basics/navbar.layout -->
	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>

		<!-- #section:basics/sidebar -->
		<div id="sidebar" class="sidebar responsive <?=$gltipo_menu;?> ">
			<script type="text/javascript">
				try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
			</script>

			<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<?php if ($gltipo_perf == 2 || $gltipo_perf == 1): ?>
						<a href="<?=base_url()."dashboard/perfil";?>">
							<button class="btn btn-sm btn-info" title="Perfil">
								<i class="ace-icon fa fa-user"></i>
							</button>
						</a>
						<a href="<?=base_url()."dashboard/ajustes";?>">
							<button class="btn btn-sm btn-danger" title="Ajustes">
								<i class="ace-icon fa fa-cogs"></i>
							</button>
						</a>
					<?php else: ?>
						<a href="<?=base_url()."dashboard/perfil";?>">
							<button class="btn btn-sm btn-info" title="Perfil">
								<i class="ace-icon fa fa-user"></i>
							</button>
						</a>
					<?php endif ?>
					

					<!-- /section:basics/sidebar.layout.shortcuts -->
				</div>

				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
					<span class="btn btn-success"></span>

					<span class="btn btn-info"></span>

					<span class="btn btn-warning"></span>

					<span class="btn btn-danger"></span>
				</div>
			</div><!-- /.sidebar-shortcuts -->

			<ul class="nav nav-list" style="top: 0px;">
				<li class="<?=($this->uri->segment(2)==='inicio')?'active':'hover'?> <?=$gltipo_menu_a;?>">
					<a href="<?=base_url();?>">
						<i class="menu-icon fa fa-home"></i>
						<span class="menu-text"> Inicio </span>
					</a>

					<b class="arrow"></b>
				</li>
				<?php if ($glMenu): ?>
				<?php foreach ($glMenu as $key_m): ?>
					<?php if ($key_m['MenParentId'] == 0): ?>
						<li class="<?=($this->uri->segment(1)===$key_m['MenUrlActive'])?'active':''?> <?=$gltipo_menu_a;?> <?=$gltm_compac_h;?>">
							<a href="<?=base_url().$key_m['MenPagina'];?>" class="<?=$key_m['MenRedirect'];?> ">
								<i class="menu-icon <?=$key_m['MenIcono'];?>"></i>
								<span class="menu-text"> <?=$key_m['MenNavegacion'];?> </span>
								<b class="<?=$key_m['MenIcono_flecha'];?>"></b>
							</a>
							<b class="arrow"></b>
							<?php $glSubMenu = $this->global_model->getAll_SubMenu_byID($key_m['id_menu'],$key_m['id_usuario']); ?>
							<?php if ($glSubMenu): ?>
								<ul class="submenu">
									<?php foreach ($glSubMenu as $key_sm): ?>
										<?php if ($key_m['id_menu'] == $key_sm['MenParentId']): ?>
											<li class="">
												<a href="<?=base_url().$key_sm['MenPagina'];?>">
													<i class="menu-icon <?=$key_sm['MenIcono'];?>-right"></i>
													<?=$key_sm['MenNavegacion'];?>
												</a>
												<b class="arrow"></b>
											</li>
										<?php else: ?>
										<?php endif ?>
									<?php endforeach ?>
								</ul>
							<?php else: ?>
							<?php endif ?>
						</li>
					<?php else: ?>
					<?php endif ?>
				<?php endforeach ?> 
				<?php else: ?>
				<?php endif ?>

				<?php if ($gltipo_perf == 2 || $gltipo_perf == 1): ?>
					<li class="<?=($this->uri->segment(2)==='ajustes')?'active':'hover'?> <?=$gltipo_menu_a;?>">
						<a href="<?=base_url();?>dashboard/ajustes">
							<i class="menu-icon fa fa-cogs"></i>
							<span class="menu-text"> Ajustes </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="hover <?=$gltipo_menu_a;?>">
						<a href="<?=base_url()?>login/home/salir">
							<i class="menu-icon fa fa-power-off"></i>
							<span class="menu-text">
								Salir
								<span class="badge badge-transparent tooltip-error">
									<i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
								</span>
							</span>
						</a>
					</li>
				<?php else: ?>
				<?php endif ?>
			</ul>

			<!-- /section:basics/sidebar.layout.minimize -->
			<script type="text/javascript">
				try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
			</script>
		</div>
		<!-- /section:basics/sidebar -->
		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<div class="row">
						<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<?php if ($this->uri->segment(2)==='perfil'): ?>
								<!-- #section:settings.box -->
								<div class="ace-settings-container" id="ace-settings-container">
									<div class="btn btn-app btn-xs btn-success ace-settings-btn" id="ace-settings-btn">
										<i class="ace-icon fa fa-cog bigger-130"></i>
									</div>

									<div class="ace-settings-box clearfix" id="ace-settings-box">
										<div class="pull-left width-50">
											<!-- #section:settings.skins -->
											<div class="ace-settings-item">
												<div class="pull-left">
													<select id="skin-colorpicker" class="hide opcolo">
														<?php if ($glskin == 'no-skin'): ?>
															<?php $glskinSelected = "selected"; ?>
														<?php else: ?>
															<?php $glskinSelected = ""; ?>
														<?php endif ?>
														<?php if ($glskin == 'skin-1'): ?>
															<?php $glskinSelected1 = "selected"; ?>
														<?php else: ?>
															<?php $glskinSelected1 = ""; ?>
														<?php endif ?>
														<?php if ($glskin == 'skin-2'): ?>
															<?php $glskinSelected2 = "selected"; ?>
														<?php else: ?>
															<?php $glskinSelected2 = ""; ?>
														<?php endif ?>
														<?php if ($glskin == 'skin-3'): ?>
															<?php $glskinSelected3 = "selected"; ?>
														<?php else: ?>
															<?php $glskinSelected3 = ""; ?>
														<?php endif ?>
														<option data-skin="no-skin" value="#438EB9" <?=$glskinSelected?> >#438EB9</option>
														<option data-skin="skin-1" value="#222A2D" <?=$glskinSelected1?> >#222A2D</option>
														<option data-skin="skin-2" value="#C6487E" <?=$glskinSelected2?> >#C6487E</option>
														<option data-skin="skin-3" value="#D0D0D0" <?=$glskinSelected3?> >#D0D0D0</option>
													</select>
												</div>
												<span>&nbsp; Escoger Tema</span>
											</div>

											<!-- /section:settings.skins -->
											<?php if ($gltipo_menu == 'compact'): ?>
												<?php $gltipo_menu_cheked = 'checked'; ?> 
											<?php else: ?>
												<?php $gltipo_menu_cheked = ''; ?> 
											<?php endif ?>
											<div class="ace-settings-item">
												<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" <?=$gltipo_menu_cheked;?>/>
												<label class="lbl" for="ace-settings-compact"> Reducir Menu</label>
											</div>
											<?php if ($gltipo_menu_a == 'highlight'): ?>
												<?php $gltipo_menu_a_cheked = 'checked'; ?> 
											<?php else: ?>
												<?php $gltipo_menu_a_cheked = ''; ?> 
											<?php endif ?>
											<div class="ace-settings-item">
												<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" <?=$gltipo_menu_a_cheked;?>/>
												<label class="lbl" for="ace-settings-highlight"> Menu activo</label>
											</div>
											<div class="ace-settings-item center">
												<button id="btn_guardar_theme" class="btn btn-xs btn-info" onclick="javascript:btn_guardar_theme();">
													<i class="ace-icon fa fa-save bigger-110"></i>
													Guardar
												</button>
											</div><div class="space-8"></div>
											<!-- /section:settings.container -->
										</div><!-- /.pull-left -->
									</div><!-- /.ace-settings-box -->
								</div><!-- /.ace-settings-container -->

								<script src="<?=base_url();?>assets/js/ace/ace.settings.js"></script>
								<script src="<?=base_url();?>assets/js/ace/ace.settings-rtl.js"></script>
								<script src="<?=base_url();?>assets/js/ace/ace.settings-skin.js"></script>
							<?php else: ?>

							<?php endif ?>