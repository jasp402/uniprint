<?php echo $this->load->view('global_views/header_dashboard'); ?>
	</head>
	<?php echo $this->load->view('global_views/contenedor');?>
	

	<div class="space-24"></div>
	<hr>
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='<?=base_url();?>assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
	</script>
	<script src="<?=base_url();?>assets/js/jquery-ui.custom.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.ui.touch-punch.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.gritter.js"></script>
	<!-- inline scripts related to this page -->
	<script type="text/javascript">

		$.gritter.add({
			title: 'This is a regular notice!',
			text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" class="blue">magnis dis parturient</a> montes, nascetur ridiculus mus.',
			image: '../assets/avatars/avatar1.png', //in Ace demo ../assets will be replaced by correct assets path
			sticky: false,
			time: '',
			//class_name: (!$('#gritter-light').get(0).checked ? 'gritter-light' : '')
		});


		$('#gritter-regular').on(ace.click_event, function(){
			$.gritter.add({
				title: 'This is a regular notice!',
				text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" class="blue">magnis dis parturient</a> montes, nascetur ridiculus mus.',
				image: '../assets/avatars/avatar1.png', //in Ace demo ../assets will be replaced by correct assets path
				sticky: false,
				time: '',
				//class_name: (!$('#gritter-light').get(0).checked ? 'gritter-light' : '')
			});

			return false;
		});

		$('#gritter-sticky').on(ace.click_event, function(){
			var unique_id = $.gritter.add({
				title: 'This is a sticky notice!',
				text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" class="red">magnis dis parturient</a> montes, nascetur ridiculus mus.',
				image: '../assets/avatars/avatar.png',
				sticky: true,
				time: '',
				class_name: 'gritter-info'
			});

			return false;
		});


		$('#gritter-without-image').on(ace.click_event, function(){
			$.gritter.add({
				// (string | mandatory) the heading of the notification
				title: 'This is a notice without an image!',
				// (string | mandatory) the text inside the notification
				text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" class="orange">magnis dis parturient</a> montes, nascetur ridiculus mus.',
				class_name: 'gritter-success'
			});

			return false;
		});


		$('#gritter-max3').on(ace.click_event, function(){
			$.gritter.add({
				title: 'This is a notice with a max of 3 on screen at one time!',
				text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit. Cum sociis natoque penatibus et <a href="#" class="green">magnis dis parturient</a> montes, nascetur ridiculus mus.',
				image: '../assets/avatars/avatar3.png', //in Ace demo ../assets will be replaced by correct assets path
				sticky: false,
				before_open: function(){
					if($('.gritter-item-wrapper').length >= 3)
					{
						return false;
					}
				},
				class_name: 'gritter-warning'
			});

			return false;
		});


		$('#gritter-center').on(ace.click_event, function(){
			$.gritter.add({
				title: 'This is a centered notification',
				text: 'Just add a "gritter-center" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
				class_name: 'gritter-info gritter-center'
			});

			return false;
		});

		$('#gritter-error').on(ace.click_event, function(){
			$.gritter.add({
				title: 'This is a warning notification',
				text: 'Just add a "gritter-light" class_name to your $.gritter.add or globally to $.gritter.options.class_name',
				class_name: 'gritter-error'
			});

			return false;
		});


		$("#gritter-remove").on(ace.click_event, function(){
			$.gritter.removeAll();
			return false;
		});

	</script>

<h1>Texto en el Dashboard
</h1>
	<?php $this->load->view('global_views/footer_dashboard');?>

