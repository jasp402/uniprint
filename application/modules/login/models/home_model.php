<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
	}

	public function validar($usuario,$password){
		// $this->db->query("CALL ActualizaEstadoProceso");
		// $this->db->SELECT("usu.id_usuario, usu_co.estado AS estado_contrato");
		// $this->db->from('user_usuario usu');
		// $this->db->join('user_contusemp usu_cuemp', 'usu.id_usuario = usu_cuemp.id_usuario');
		// $this->db->join('user_contrato usu_co', 'usu_co.id_contrato = usu_cuemp.id_contrato');
		$this->db->select('usu.*');
		$this->db->from('user_usuario usu');
		$this->db->where('usu.correo', $usuario);
		$this->db->where("AES_DECRYPT(usu.clave,'xWxZz')", $password);
		$query = $this->db->get();
				// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function validarCondicion($correo){

		$this->db->select('condicion');
		$this->db->from('user_usuario');
		$this->db->where('correo', $correo);

		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$condicion = $key->condicion;
			}
			if ($condicion == '0') {
				return '0';
			}else{
				return '1';
			}
		}else{
			return false;
		}
		
	}

	public function insertar($correo){
			// $query = $this->db->query("INSERT INTO user_usuario (correo,id_empresa,id_perfil) VALUES ('".$correo."','1','2')");
       		// return $query ? TRUE : FALSE;
       		// try {
       			// $query = 
       			$query = $this->db->query("INSERT INTO user_usuario (correo,id_empresa,id_perfil) VALUES ('".$correo."','1','2')");

       			if(!$query) {
       				return $this->db->_error_number();
       			}else{
       				return "BUENA - GRANDIOSO";
       			}

       		// } catch (Exception $e) {
       		// 	return $e;
       		// }
	} 

	public function get_clave($correo){
		
		$query = $this->db->query("SELECT nombre, correo, AES_DECRYPT(clave,'xWxZz') AS clave FROM user_usuario WHERE correo = '".$correo."' ");
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function up_clave($correo,$clave){
		$query = $this->db->query("UPDATE user_usuario SET clave = AES_ENCRYPT('".$clave."','xWxZz') WHERE correo = '".$correo."' ");
		// echo $this->db->last_query(); break;
		if ($this->db->affected_rows()) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file home_model.php */
/* Location: ./application/modules/login/models/home_model.php */