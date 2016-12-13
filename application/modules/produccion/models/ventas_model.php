<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends CI_Model
{
    private $tabla;
    private $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_unidad';
        $this->primary_key = 'id_unidad';
    }

    public function ListData()
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $query = $this->db->get();
        $result = array(
            "draw"=>1,
            "recordsTotal"=> $query->num_rows(),
            "recordsFiltered"=> $query->num_rows(),
            'data'	=> $query->result());
        echo json_encode($result);
    }
    public function deleteById($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->tabla);
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'DELETE');
    }


}
// echo $this->db->last_query(); break;
/* End of file unidades_model.php */
/* Location: ./application/modules/configuracion/models/unidades_model.php */