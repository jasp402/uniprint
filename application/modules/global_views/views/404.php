<?php echo $this->load->view('header'); ?>
</head>
<body>
<div class="row">
	<div class="main-content">
		<div class="main-content-inner">
			<div class="page-content">
				<div class="row">
					<div class="col-xs-12">
						<!-- PAGE CONTENT BEGINS -->
						<div class="error-container">
							<div class="well" style="text-align: center;">
								<h1 class="grey lighter smaller" >
									<span class="blue bigger-125">
										<i class="ace-icon fa fa-sitemap"></i>
										ERROR 404
									</span>
									Esta pagina no existe
								</h1>

								<hr>
								<h3 class="lighter smaller">Has intentado entrar a una pagina que no existe!</h3>

								<hr>
								<div class="space"></div>

								<div class="center">
									<a href="<?=base_url();?>" class="btn btn-grey">
										<i class="ace-icon fa fa-arrow-left"></i>
										Regresar
									</a>
								</div>
							</div>
						</div>

						<!-- PAGE CONTENT ENDS -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div>
</div>
</body>
</html>