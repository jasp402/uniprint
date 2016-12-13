<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inicio extends MX_Controller {
	public function __construct()
	{
		parent::__construct();

	}
	public function index(){
		if (tiene_logeo()) {
			$this->load->view('dashboard');
		}else{
			redirect(base_url());
		}
		
	}

}

/* End of file inicio.php */
/* Location: ./application/modules/dashboard/controllers/inicio.php */