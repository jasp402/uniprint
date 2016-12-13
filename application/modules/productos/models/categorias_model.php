<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model
{
    private $tabla;
    private $primary_key;

    public function __construct(){
        parent::__construct();
        $this->tabla = 'sys_categorias';
        $this->primary_key = 'id_categoria';
    }

    public function getAll()
    {
        $this->db->select('sys_categorias.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->from($this->tabla);
        $this->db->join('sys_proyecto','sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->order_by($this->primary_key);
        $query = $this->db->get();
         //echo $this->db->last_query(); break;
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }

    public function getAllById($id)
    {
        $this->db->select('*');

        $this->db->from($this->tabla);
        $this->db->where($this->primary_key, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAllByWhere($id,$primary_key)
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->where($primary_key, $id);
        $this->db->order_by($this->primary_key);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function create($data)
    {
        $this->db->insert($this->tabla, $data);
        //echo $this->db->last_query(); break;
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'CREATE');
    }

    public function editById($data,$id){
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->tabla, $data);
        //echo $this->db->last_query();
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'UPDATE');
    }

    public function deleteById($id){
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->tabla);
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'DELETE');
    }
}
