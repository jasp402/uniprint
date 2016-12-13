<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Global_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getAll_byID($id){
		$this->db->SELECT("usu.id_usuario, usu.DNI, usu.clave, usu.nombre, usu.correo, usu.ruta_foto, usu.id_perfil, usu_sett.skin, usu_sett.tipo_menu, usu_sett.tipo_menu_activo, usu_sett.tm_compact_hover",FALSE);
		$this->db->from('user_usuario usu');
		$this->db->join('user_settings_theme usu_sett', 'usu.id_settings_theme = usu_sett.id_settings_theme');
		$this->db->where('usu.id_usuario', $id);

		
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			return $query->result();
		}
	}

	public function getAll_Menu_byID($id){
		$this->db->select('usua.condicion,usua.id_usuario, usep.perfil, usem.MenTitulo, usem.MenNavegacion, usem.MenPagina, usem.MenIcono, usem.MenPosicion, usem.id_menu, usem.MenParentId, usem.MenIcono_flecha, usem.MenRedirect,usem.MenUrlActive');
		$this->db->from('user_usuario usua');
		$this->db->join('user_perfil usep', 'usua.id_perfil = usep.id_perfil');
		$this->db->join('user_permiso useo', 'usua.id_usuario = useo.id_usuario');
		$this->db->join('user_menu usem', 'useo.id_menu = usem.id_menu');
		$this->db->where('usua.id_usuario', $id);
		$this->db->order_by('usem.MenPosicion', 'ASC');
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function getAll_SubMenu_byID($id,$idusu){
		$this->db->select('usua.condicion,usua.id_usuario, usep.perfil, usem.MenTitulo, usem.MenNavegacion, usem.MenPagina, usem.MenIcono, usem.MenPosicion, usem.id_menu, usem.MenParentId');
		$this->db->from('user_usuario usua');
		$this->db->join('user_perfil usep', 'usua.id_perfil = usep.id_perfil');
		$this->db->join('user_permiso useo', 'usua.id_usuario = useo.id_usuario');
		$this->db->join('user_menu usem', 'useo.id_menu = usem.id_menu');
		$this->db->where('usem.MenParentId', $id);
		$this->db->where('usem.MenEliminado', '0');
		$this->db->where('usua.id_usuario', $idusu);
		$this->db->order_by('usem.MenPosicion', 'ASC');
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function getIdEmpresaByIdUser($id){
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

	public function getCMenu_ByIdUser($id){
		$this->db->select('usum.MenTitulo');
		$this->db->from('user_menu usum');
		$this->db->join('user_permiso usp', 'usp.id_menu = usum.id_menu');
		$this->db->where('usp.id_usuario', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function getCondicionByIdUser($id){
		$this->db->select('condicion');
		$this->db->from('user_usuario');
		$this->db->where('id_usuario', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $key) {
				return $key->condicion;
			}
		}
	}

	public function getAll_OnlyUserByIdUser($id){
		$this->db->select('*');
		$this->db->from('user_usuario');
		$this->db->where('id_usuario', $id);
		$this->db->limit(1);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function getOnlyPassByIdUser($id){
		$this->db->select('clave');
		$this->db->from('user_usuario');
		$this->db->where('id_usuario', $id);
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $key) {
				return $key->clave;
			}
		}
	}

	public function getOnlyMenu(){
		$this->db->select('*');
		$this->db->from('user_menu');
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function getOnlyMenuByHijo($id_hijo){
		$this->db->select('*');
		$this->db->from('user_menu');
		$this->db->where('MenParentId', $id_hijo);
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function getOnlyIdUserByCorreo($correo){
		$this->db->select('id_usuario');
		$this->db->from('user_usuario');
		$this->db->where('correo', $correo);
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				return $key->id_usuario;
			}
		}else{
			return FALSE;
		}
	}

	public function getOnlyDNIByCorreo($correo){
		$this->db->select('DNI');
		$this->db->from('user_usuario');
		$this->db->where('correo', $correo);
		$query = $this->db->get();
		// echo $this->db->last_query();break;
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				return $key->DNI;
			}
		}else{
			return FALSE;
		}
	}

	public function ValidateAccessAdmin($id){
		$where_or = "correo = '".correo_webmaster."' OR correo = '".correo_auxiliar."' ";
		$this->db->select('*');
		$this->db->from('user_usuario');
		$this->db->where('id_perfil', '1');
		$this->db->where('id_usuario', $id);
		$this->db->where($where_or);
		$this->db->limit(1);
		$query = $this->db->get();
		// echo $this->db->last_query(); break;
		if ($query->num_rows() > 0 ) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

}

/* End of file getLogin.php */
/* Location: ./application/modules/global_views/models/getLogin.php */