<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Webs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function web404(){
		if (!tiene_logeo()) {
			redirect(base_url());
		}else{
			$this->load->view('404');
		}
		
	}
	public function end_contrato(){
		$this->load->view('contrato_finalizado');
	}

}

/* End of file webs.php */
/* Location: ./application/modules/global_views/controllers/webs.php */