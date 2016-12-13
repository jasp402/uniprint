<?php echo $this->load->view('header'); ?>
<script type="text/javascript">
	function btn_cambiar(){
		var pass     = $('#pass').val();
		var new_pass = $('#new_pass').val();
		var char2    = $('#char2').val();
		if (pass.trim()== "" || new_pass.trim() == "") {
			mensaje_gbl('Ingrese las claves...','warning','exclamation','mensaje_cambiar');
		}else if (pass.trim() == new_pass.trim()){
			desactivar_inputs('inputs_pass');
			$.ajax({
			  url: "<?=base_url(); ?>"+'login/home/update_clave',
			  type: 'POST',
			  dataType: 'json',
			  data: {pass: pass, char2: char2},
			  beforeSend: function() {
			    mensaje_gbl('Procesando...','info','clock-o','mensaje_cambiar');
			  },
			  success: function(data) {
			  		if (data.success == true) {
			  			mensaje_gbl('Clave cambiada...','success','check','mensaje_cambiar');
			  			setTimeout(function() {window.location.href = '<?=base_url(); ?>';}, 1800);
			  		}else{
			  			mensaje_gbl('ERROR DEL SERVIDOR, INTENTELO MAS TARDE','danger','times','mensaje_cambiar');
			  		}
			  }
			});
			
		}else{
			mensaje_gbl('Las claves no coinciden...','warning','exclamation','mensaje_cambiar');
		}
	}
</script>
</head>
<input type="hidden" id="char1" value="<?php echo $this->uri->segment(4); ?>">
<input type="hidden" id="char2" value="<?php echo $this->uri->segment(5); ?>">
<body class="login-layout dark-login">
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">

						<div class="space-12"></div>
						<div class="space-12"></div>
						<div class="space-12"></div>
						<div class="space-12"></div>
						<div class="space-12"></div>
						<div class="space-12"></div>

						<div class="position-relative">
							<div id="login-box" class="login-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header blue lighter bigger center">
											<i class="ace-icon fa fa-server brown"></i>
											Cambiar clave
										</h4>

										<div class="space-6"></div>

										<form id="inputs_pass">
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input id="pass" type="password" class="form-control" placeholder="clave">
														<i class="ace-icon fa fa-key"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-right">
														<input id="new_pass" type="password" class="form-control" placeholder="repetir clave">
														<i class="ace-icon fa fa-key"></i>
													</span>
												</label>		

												<div class="space"></div>

												<div class="clearfix">
													<button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="javascript:btn_cambiar();">
														<i class="ace-icon fa fa-refresh"></i>
														<span class="bigger-110">Cambiar</span>
													</button>
												</div>
												<div class="space-4"></div>
												<div class="clearfix">
													<div class="space-4"></div>
													<div id="mensaje_cambiar"></div>
												</div>

												<div class="space-4"></div>
											</fieldset>
										</form>
									</div><!-- /.widget-main -->
								</div><!-- /.widget-body -->
							</div><!-- /.login-box -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->
	</div>
<?php echo $this->load->view('footer'); ?>