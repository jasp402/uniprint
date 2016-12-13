<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Perfil_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getAll_byID($id){
		$this->db->select('usu.id_usuario,usu.DNI, usu.nombre, usu.telefono, usu.direccion, usu.ruta_foto, usp.perfil, usp.detalles');
		$this->db->from('user_usuario usu');
		$this->db->join('user_perfil usp', 'usu.id_perfil = usp.id_perfil');
		$this->db->where('usu.id_usuario', $id);
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}
	}

	public function update_byID($data,$id){
		$this->db->where('id_usuario', $id);
		$this->db->update('user_usuario', $data);
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function update_byID_pass($id,$pass_actual,$nuevo_passw){
		// $this->db->where('id_usuario', $id);
		// $this->db->where('clave', $pass_actual);
		// $this->db->update('user_usuario', $data);
		$this->db->query("UPDATE user_usuario SET clave = AES_ENCRYPT('".$nuevo_passw."','xWxZz') WHERE id_usuario = ".$id." AND clave = AES_ENCRYPT('".$pass_actual."','xWxZz') ");
		// echo $this->db->last_query(); break;
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file perfil_model.php */
/* Location: ./application/modules/dashboard/models/perfil_model.php */