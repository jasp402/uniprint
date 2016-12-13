<?php echo $this->load->view('header_dashboard'); ?>
	</head>
<?php echo $this->load->view('contenedor'); ?>

								<div class="col-sm-12 infobox-container">
									<div class="error-container">
										<div class="well">
											<h1 class="grey lighter smaller">
												<span class="red bigger-125">
													<i class="ace-icon fa fa-ban"></i>
												</span>
												ACCESO RESTRINGIDO
											</h1>

											<hr>
											<h3 class="lighter smaller"></h3>

											<div>
												<div class="space"></div>
												<h4 class="smaller">Usted no tiene permisos para acceder a esta secci&oacute;n, por favor comuniquese con su supervisor o persona encargada del sistema.</h4>
											</div>

											<hr>
											<div class="space"></div>

											<div class="center">
												<a href="<?=base_url();?>" class="btn btn-danger">
													<i class="ace-icon fa fa-arrow-left"></i>
													REGRESAR
												</a>
											</div>
										</div>
									</div>
								</div>
							<!-- PAGE CONTENT ENDS -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->
	</div><!-- /.main-container -->
<?php echo $this->load->view('footer'); ?>