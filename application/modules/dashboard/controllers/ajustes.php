<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajustes extends MX_Controller {
	private $idus;
	public function __construct()
	{
		parent::__construct();
		$this->gbl_mdls = $this->load->model('global_views/global_model');
		$this->load->model('ajustes_model');
		$this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
	}

	public function index()
	{
		if (tiene_logeo()) {
				$axx_val = $this->gbl_mdls->getAll_byID($this->idus);
				foreach ($axx_val as $key_axx) {
					$axx_personal = $key_axx->id_perfil;
				}
				if ($axx_personal == 3) {
					$this->load->view('global_views/acceso_restringido');
				}else{
					// $data['ajuste'] = $this->ajustes_model->getAll_byID($this->idus);
					$data['userBy'] = $this->ajustes_model->getAll_UserbyIDemp();
					$this->load->view('ajustes',$data);
				}
		}else{
			redirect(base_url());
		}
	}

	public function guardar_tema(){
		$skin_class = $this->input->post('skin_class');
		$compact    = $this->input->post('compact');
		$highlight  = $this->input->post('highlight');

		$idtema = 0;

		if ($skin_class == "no-skin" && $compact == "" && $highlight == "") {
			$idtema = 1;
		}else if ($skin_class == "skin-1" && $compact == "" && $highlight == "") {
			$idtema = 2;
		}else if ($skin_class == "skin-2" && $compact == "" && $highlight == "") {
			$idtema = 3;
		}else if ($skin_class == "skin-3" && $compact == "" && $highlight == "") {
			$idtema = 4;
		}else if ($skin_class == "no-skin" && $compact == "compact" && $highlight == "") {
			$idtema = 5;
		}else if ($skin_class == "skin-1" && $compact == "compact" && $highlight == "") {
			$idtema = 6;
		}else if ($skin_class == "skin-2" && $compact == "compact" && $highlight == "") {
			$idtema = 7;
		}else if ($skin_class == "skin-3" && $compact == "compact" && $highlight == "") {
			$idtema = 8;
		}else if ($skin_class == "no-skin" && $compact == "compact" && $highlight == "highlight") {
			$idtema = 9;
		}else if ($skin_class == "skin-1" && $compact == "compact" && $highlight == "highlight") {
			$idtema = 10;
		}else if ($skin_class == "skin-2" && $compact == "compact" && $highlight == "highlight") {
			$idtema = 11;
		}else if ($skin_class == "skin-3" && $compact == "compact" && $highlight == "highlight") {
			$idtema = 12;
		}else if ($skin_class == "no-skin" && $compact == "" && $highlight == "highlight") {
			$idtema = 13;
		}else if ($skin_class == "skin-1" && $compact == "" && $highlight == "highlight") {
			$idtema = 14;
		}else if ($skin_class == "skin-2" && $compact == "" && $highlight == "highlight") {
			$idtema = 15;
		}else if ($skin_class == "skin-3" && $compact == "" && $highlight == "highlight") {
			$idtema = 16;
		}else{
			$idtema = 1;
		}

		$data = array('id_settings_theme' => $idtema);
		$query = $this->ajustes_model->updateTheme($this->idus,$data);

		if ($query) {
			$dataJ = array('success' => true);
			echo json_encode($dataJ);
		}else{
			$dataJ = array('success' => false);
			echo json_encode($dataJ);
		}
	}

	public function guardar_empresa(){
		$data = array();
		foreach($_POST as $key => $value){
		     $data[$key] = $this->input->post($key);
		}

		$query = $this->ajustes_model->updateEmpresa($this->idus,$data);
		if ($query) {
			$dataJ = array('success' => true);
			echo json_encode($dataJ);
		}else{
			$dataJ = array('success' => false);
			echo json_encode($dataJ);
		}
	}

	public function guardar_usuario(){
		
		$id_usuario = $this->idus;
		$DNI        = $this->input->post('DNI');
		$nombre     = $this->input->post('us_pc_nombre');
		$direccion  = $this->input->post('us_pc_direccion');
		$telefono   = $this->input->post('us_pc_telefono');
		$correo     = $this->input->post('email');
		$password   = $this->input->post('us_pc_password');

		$query = $this->ajustes_model->saveUserNew($id_usuario,$DNI,$nombre,$direccion,$telefono,$correo,$password);
		if ($query) {
			$data = array('success' => true);
			echo json_encode($data);
		}else{
			$data = array('success' => false);
			echo json_encode($data);
		}
		// $id_empresa = $this->ajustes_model->getEmpresaId($id_usuario);

		// $query_getCantidadUserByEmp = $this->ajustes_model->getCantidadUserByEmp($id_empresa);

		// foreach ($query_getCantidadUserByEmp as $rowUBE) {
		// 	$cantidad_UserByEmp   = $rowUBE->cantidad;
		// 	$idcontrato_UserByEmp = $rowUBE->id_tipo_contrato;
		// }

		// switch ($idcontrato_UserByEmp) {
		// 	case '2':
		// 		if ($cantidad_UserByEmp < 3) {
		// 			$query = $this->ajustes_model->saveUserNew($id_usuario,$DNI,$nombre,$direccion,$telefono,$correo,$password);
		// 			if ($query) {
		// 				$data = array('success' => true);
		// 				echo json_encode($data);
		// 			}else{
		// 				$data = array('success' => false);
		// 				echo json_encode($data);
		// 			}
		// 		}else{
		// 			$data = array('success' => 999999);
		// 			echo json_encode($data);
		// 		}
		// 		break;
			
		// 	case '3':
		// 		if ($cantidad_UserByEmp < 4) {
		// 			$query = $this->ajustes_model->saveUserNew($id_usuario,$DNI,$nombre,$direccion,$telefono,$correo,$password);
		// 			if ($query) {
		// 				$data = array('success' => true);
		// 				echo json_encode($data);
		// 			}else{
		// 				$data = array('success' => false);
		// 				echo json_encode($data);
		// 			}
		// 		}else{
		// 			$data = array('success' => 999999);
		// 			echo json_encode($data);
		// 		}
		// 		break;
		// 	default:
		// 		$data = array('success' => false);
		// 		echo json_encode($data);
		// 		break;
		// }
	}

	public function eliminar_user_package(){
		$id_usuario = $this->encrypt->decode(url_deco($this->input->post('id')));

		$query = $this->ajustes_model->deleteUserById($id_usuario);
		if ($query) {
			$data = array('success' => true);
		}else{
			$data = array('success' => false);
		}
		
		echo json_encode($data);
	}

	public function form_inputs_ususario(){
		$id_usuario = $this->encrypt->decode(url_deco($this->input->post('id')));

		$query = $this->gbl_mdls->getAll_OnlyUserByIdUser($id_usuario);

		if ($query) {
			$nombre = ""; $direccion = ""; $telefono = ""; $acceso = "";
			foreach ($query as $key) {
				$nombre    = $key->nombre;
				$direccion = $key->direccion;
				$telefono  = $key->telefono;
				$acceso    = $key->condicion;
			}
			$data_user = array(
								'nombre'    => $nombre,
								'direccion' => $direccion,
								'telefono'  => $telefono,
								'acceso'    => $acceso
								);
			$data = array('success' => true, 'user' => $data_user);
			echo json_encode($data);
		}else{
			$data = array('success' => false);
			echo json_encode($data);
		}
	}

	public function save_form_inputs_ususario(){
		$id_usuario = $this->encrypt->decode(url_deco($this->input->post('id')));
		$nombre    = $this->input->post('nombre');
		$direccion = $this->input->post('direccion');
		$telefono  = $this->input->post('telefono');
		$password  = $this->input->post('password');
		$acceso    = $this->input->post('acceso');

		if (!empty($password)) {
			$this->ajustes_model->updateOnlyPassById($id_usuario,$password);
			$password_re = $this->gbl_mdls->getOnlyPassByIdUser($id_usuario);
			$data_user = array(
								'clave'     => $password_re,
								'nombre'    => $nombre,
								'direccion' => $direccion,
								'telefono'  => $telefono,
								'condicion' => $acceso
								);
		}else{
			$data_user = array(
								'nombre'    => $nombre,
								'direccion' => $direccion,
								'telefono'  => $telefono,
								'condicion' => $acceso
								);
		}

		

		$query = $this->ajustes_model->updateUserById($id_usuario,$data_user);

		if ($query) {
			$data = array('success' => true);
			echo json_encode($data);
		}else{
			$data = array('success' => false);
			echo json_encode($data);
		}
	}

	public function save_new_permisos(){
		$padre = array(); $hijo = array(); $result = array();
		$id_usuario = $this->encrypt->decode(url_deco($this->input->post('us_pc_permiso')));
		$padre = $this->input->post('padre');
		$hijo  = $this->input->post('hijo');

		if (empty($padre)) {
			$result = $hijo;
		}else if (empty($hijo)) {
			$result = $padre;
		}else if (empty($padre) && empty($hijo)) {
			$result == false;
		}else{
			$result = array_merge($padre,$hijo);
		}
		if ($result == false) {
			$this->ajustes_model->deleteIdMenuByIdUser($id_usuario);
			$data = array('success' => true);
		}else{
			$query = $this->ajustes_model->savePermisosByIdUser($id_usuario,$result);
			if ($query) {
				$data = array('success' => true);
			}else{
				$data = array('success' => false);
			}
		}
		echo json_encode($data);
	}

	public function cargar_menu_usuario(){
		$id_usuario = $this->encrypt->decode(url_deco($this->input->post('id')));
		$query = $this->ajustes_model->getIdMenuByIdUsuario($id_usuario);
		if ($query) {
			$menu = array();
			foreach ($query as $key) {
				$menu[] = $key->id_menu;
			}
			$data = array('success' => true, 'menu' => $menu);
			echo json_encode($data);
		}else{
			$data = array('success' => false);
			echo json_encode($data);
		}
	}

}

/* End of file ajustes.php */
/* Location: ./application/modules/dashboard/controllers/ajustes.php */