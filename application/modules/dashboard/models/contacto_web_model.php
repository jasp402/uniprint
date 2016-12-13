<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contacto_web_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function getAll_byID($id){
		$this->db->select('usu.nombre AS nombre_personal,usu.correo AS correo_personal,usem.nombre_comercial, usem.representante');
		$this->db->from('user_empresa usem');
		$this->db->join('user_contusemp contse', 'contse.id_empresa = usem.id_empresa');
		$this->db->join('user_usuario usu', 'usu.id_usuario = contse.id_usuario');
		$this->db->where('usu.id_usuario', $id);
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}

	}

}

/* End of file contacto_web_model.php */
/* Location: ./application/modules/dashboard/models/contacto_web_model.php */