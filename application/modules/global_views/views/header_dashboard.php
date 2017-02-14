<!DOCTYPE html>
<html>
	<head>
		<title>SysGiD - Uniprint S.A.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		  <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- CSS -->
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css" />
		<link rel="stylesheet" href="<?=base_url();?>assets/css/font-awesome.css" />
		<!-- text fonts -->
		<link rel="stylesheet" href="<?=base_url();?>assets/css/ace-fonts.css"/>
		<!-- ace styles -->
		<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery.gritter.css" />

		<link rel="stylesheet" href="<?=base_url();?>assets/css/ace.css" />
		<link type="text/css" rel="stylesheet" id="ace-skins-stylesheet" href="<?=base_url();?>assets/css/ace-skins.css">
		<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/ace-part2.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?=base_url();?>assets/css/ace-rtl.css" />
		<!-- JS -->
		<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/global_jp.js"></script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/ace-extra.js"></script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap.js"></script>
		<script type="text/javascript" src="<?=base_url();?>assets/js/ace-elements.js"></script>
		<script type="text/javascript" src="<?=base_url();?>/assets/js/ace.js"></script>
		<script src="<?=base_url();?>assets/js/ace/elements.onpage-help.js"></script>
		<script src="<?=base_url();?>assets/js/ace/ace.onpage-help.js"></script>
		<script src="<?=base_url();?>assets/js/jquery.easypiechart.js"></script>
		<script src="<?=base_url();?>assets/js/jquery.validate.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				var oldie = /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase());
				$('.easy-pie-chart.percentage').each(function(){
					$(this).easyPieChart({
						barColor: $(this).data('color'),
						trackColor: '#EEEEEE',
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: 8,
						animate: oldie ? false : 1000,
						size:75
					}).css('color', $(this).data('color'));
				});
				$('[data-rel=tooltip]').tooltip();
			});
		</script>
		<?php if ($this->uri->segment(2)==='perfil'): ?>
			<script type="text/javascript">
				function btn_guardar_theme() {
					$('#btn_guardar_theme').prop( "disabled", true );
					var skin_class = $('#skin-colorpicker').find('option:selected').data('skin');
					var compact    = "";
					var highlight  = "";
					if ($('#ace-settings-compact').is(":checked")){
						compact = 'compact';
					}else{
						compact = "";
					}
					if ($('#ace-settings-highlight').is(":checked")){
						highlight = 'highlight';
					}else{
						highlight = "";
					}
					jQuery.ajax({
					  url: 'ajustes/guardar_tema',
					  type: 'POST',
					  dataType: 'json',
					  data: {skin_class:skin_class, compact:compact, highlight:highlight},
					  success: function(data) {
					    if (data.success == true){
					    	alert("Tema Cambiado");
					    	setTimeout(function() {$('#btn_guardar_theme').prop( "disabled", false );}, 800);
					    }else{
					    	$('#btn_guardar_theme').prop( "disabled", false );
					    }
					  }
					});
					
				}
			</script>
		<?php else: ?>
		<?php endif ?>