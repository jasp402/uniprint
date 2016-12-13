<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajustes_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getAll_byID($id){
		$this->db->select('usem.RUC,usem.nombre_comercial, usem.direccion, usem.correo, usem.telefono, usem.sitio_web, usem.facebook, usem.twitter, usem.representante');
		$this->db->from('user_empresa usem');
		$this->db->join('user_contusemp usu_cuemp', 'usu_cuemp.id_empresa = usem.id_empresa');
		$this->db->where('usu_cuemp.id_usuario', $id);
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
	}

	public function getAll_UserbyIDemp(){
		// $id_empresa = $this->getEmpresaId($id);
		$this->db->select('	  usua.id_usuario,
							  usua.nombre,
							  usua.correo,
							  usua.condicion,
							  usua.id_usuario,
							  usep.id_perfil,
							  usep.perfil,',FALSE);
		$this->db->from('user_usuario usua');
		$this->db->join('user_perfil usep', 'usep.id_perfil = usua.id_perfil',FALSE);
		$this->db->where('usep.id_perfil >=', 1);

		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function updateTheme($id,$data){
		$this->db->where('id_usuario', $id);
		$this->db->update('user_usuario', $data);
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function updateEmpresa($id,$data){
		$id_empresa = $this->getEmpresaId($id);
		$this->db->where('id_empresa',$id_empresa);
		$this->db->update('user_empresa', $data);
		// echo $this->db->last_query(); break;
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getEmpresaId($id){
		$this->db->select('id_empresa');
		$this->db->from('user_contusemp');
		$this->db->where('id_usuario', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $key) {
				return $key->id_empresa;
			}
		}
	}

	public function getAllContrato_ByIDUser($id){
		$this->db->select('*');
		$this->db->from('user_contrato usec');
		$this->db->join('user_contusemp usu_cuemp', 'usu_cuemp.id_contrato = usec.id_contrato');
		$this->db->where('usu_cuemp.id_usuario', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0 ) {
			return $query->result();
		}
	}

	public function getIdByCorreo($correo){
		$this->db->select('id_usuario');
		$this->db->from('user_usuario');
		$this->db->where('correo', $correo);
		$query = $this->db->get();
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $key) {
				return $key->id_usuario;
			}
		}
	}

	public function getCantidadUserByEmp($id){
		$this->db->select('COUNT(usu_u.id_usuario) AS cantidad,
							usu_cuemp.id_empresa,
							usu_c.id_tipo_contrato,
							usu_tc.tipo_contrato');
		$this->db->from('user_usuario usu_u');
		$this->db->join('user_contusemp usu_cuemp', 'usu_cuemp.id_usuario = usu_u.id_usuario');
		$this->db->join('user_contrato usu_c', 'usu_c.id_contrato = usu_cuemp.id_contrato');
		$this->db->join('user_tipo_contrato usu_tc', 'usu_tc.id_tipo_contrato = usu_c.id_tipo_contrato');
		$this->db->where('usu_cuemp.id_empresa', $id);
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0 ) {
			return $query->result();
		}
	}

	public function getIdContratoByIdUser($id){
		$this->db->select('id_contrato');
		$this->db->from('user_contusemp');
		$this->db->where('id_usuario', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $key) {
				return $key->id_contrato;
			}
		}
	}

	public function saveUserNew($id_usuario,$DNI,$nombre,$direccion,$telefono,$correo,$password){
		// $id_empresa = $this->getEmpresaId($id_usuario);
		
		$data_usuario = array(	'DNI' => $DNI,
			'nombre' => $nombre,
			'clave' => $password,
			'correo' => $correo,
			'telefono' => $telefono,
			'direccion' => $direccion,
			'id_perfil' => 3
			);

		$this->db->insert('user_usuario', $data_usuario);
        //echo $this->db->last_query(); break;

		$new_id_usuario = $this->db->insert_id();
		$this->db->query("UPDATE user_usuario SET clave = AES_ENCRYPT('".$password."','xWxZz') WHERE correo = '".$correo."' ");

		// $id_contrato = $this->getIdContratoByIdUser($id_usuario);

		// $dataContu = array('id_usuario' => $new_id_usuario, 'id_empresa' => $id_empresa, 'id_contrato' => $id_contrato);

		// $this->db->insert('user_contusemp', $dataContu);

		
		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function deleteUserById($id_usuario){
		$tables = array('user_contusemp','user_permiso','user_usuario');
		$this->db->where('id_usuario', $id_usuario);
		$this->db->delete($tables);
		// echo $this->db->last_query(); break;
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function updateUserById($id_usuario,$data){
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('user_usuario', $data);
		// echo $this->db->last_query(); break;
		// if ($this->db->affected_rows()) {
		// 	return TRUE;
		// }else{
		// 	return FALSE;
		// }
		return TRUE;
	}

	public function updateOnlyPassById($id_usuario,$password){
		$this->db->query("UPDATE user_usuario SET clave = AES_ENCRYPT('".$password."','xWxZz') WHERE id_usuario = ".$id_usuario." ");
		// echo $this->db->last_query(); break;
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function savePermisosByIdUser($id_usuario,$data){
		if ($data) {
			$queryLista = $this->deleteIdMenuByIdUser($id_usuario);

			for ($i=0; $i <count($data) ; $i++) { 
				$object = array('id_menu' => $data[$i], 'id_usuario' => $id_usuario);
				$this->db->insert('user_permiso', $object);
			}
			
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function deleteIdMenuByIdUser($id_usuario){
		$this->db->where('id_usuario', $id_usuario);
		$this->db->delete('user_permiso');
		// echo $this->db->last_query(); break;
		return TRUE;
	}

	public function getIdMenuByIdUsuario($id_usuario){
		$this->db->select('id_menu');
		$this->db->from('user_permiso');
		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			return $query->result();		
		}else{
			return FALSE;
		}
	}

}

/* End of file ajustes_model.php */
/* Location: ./application/modules/dashboard/models/ajustes_model.php */