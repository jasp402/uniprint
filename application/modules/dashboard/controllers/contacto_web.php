<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contacto_web extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->gbl_mdls = $this->load->model('global_views/global_model');
		$this->load->model('contacto_web_model');
		$this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
		$this->load->library('email');
	}

	public function index(){
		if (tiene_logeo()) {
			$xValQuery = $this->gbl_mdls->getCMenu_ByIdUser($this->idus);
			$xValCi = "CI_contacto_web";
			$xValMeNu = array();
			if ($xValQuery) {
				foreach ($xValQuery as $key) {
					$xValMeNu[] = $key->MenTitulo;
				}
				if (in_array($xValCi, $xValMeNu)) {
					$query = $this->contacto_web_model->getAll_byID($this->idus);
						foreach ($query as $row) {
		  					$data = array('contacto_web' => $row);
		  			}
					$this->load->view('contacto_web',$data);
				}else{
					$this->load->view('global_views/acceso_restringido');
				}
			}else{
				$this->load->view('global_views/404');
			}
		}else{
			redirect(base_url());
		}
	}
	public function enviar_correo(){
		$nombre  = $this->input->post('nombre');
		$correo  = $this->input->post('correo');
		$empresa = $this->input->post('empresa');
		$asunto  = $this->input->post('asunto');
		$mensaje = $this->input->post('mensaje');
			
		if ($this->enviar_mail_master($empresa,$nombre,$correo,$asunto,$mensaje)) {
			$data = array('success' => true);
		}else{
			$data = array('success' => false);
		}
		echo json_encode($data);
	}

	public function enviar_mail_master($empresa,$nombre,$correo,$asunto,$mensaje){
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://single-priva4.privatednsorg.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = "noreply@gunuweb.net";
		$config['smtp_pass'] = '1JAO3+.csz-8';
		$config['mailtype'] = 'html';
		$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";

		date_default_timezone_set('America/Lima');
		$hora = date('H:i d-m-Y');
		$this->email->initialize($config);
		$this->email->from('noreply@appsystem.net','Sistema APP System V1.0');
		$this->email->to(correo_webmaster);
		 // $this->email->bcc($correocc); COPIA OCULTA
		$this->email->subject($asunto);
		$message  = '<html>';
		$message .= '<head>';
		$message .= '<body>';
		$message .= "<div class='break-18'></div>
		<div class='space-8'></div>
		<div class='row'>
			<div class='col-xs-12'>
				<h3 class='blue' style='font-size: 18px;'>".$empresa."</h3>
				<div style='line-height: 20px;'>
					<b class='grey'>Nombre: </b> ".$nombre."
					<br />
					<b class='grey'>Correo: </b> ".$correo."
					<br />
					<b class='grey'>Asunto: </b> ".$asunto."
					<br />
					<b class='grey'>Fecha: </b> ".$hora."
					<br />
					<b class='grey'>Mensaje: </b> ".$mensaje."
					<br />
				</div>
			</div>
		</div>";
		$message .= '</body>';
		$message .= '</html>';

		$this->email->message($message);
		if ($this->email->send()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	

}

/* End of file contacto_web.php */
/* Location: ./application/modules/dashboard/controllers/contacto_web.php */