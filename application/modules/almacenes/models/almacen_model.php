<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Almacen_model extends CI_Model
{
    public $tabla;
    public $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_ubicacion';
        $this->primary_key = 'id_ubicacion';
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->where('tipo','interno');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }

    public function getDataTable()
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->where('tipo','interno');
        $query = $this->db->get();
        $result = array(
            "draw"=>1,
            "recordsTotal"=> $query->num_rows(),
            "recordsFiltered"=> $query->num_rows(),
            'data'	=> $query->result());
        echo json_encode($result);
    }

    public function getAllById($id)
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->where($this->primary_key, $id);
//                echo $this->db->last_query(); break;
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
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function create($data){
        $this->db->insert($this->tabla, $data);
//        echo $this->db->last_query();
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'CREATE');
    }

    public function editById($data,$id){
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->tabla, $data);
//      echo $this->db->last_query();
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'UPDATE');
    }

    public function deleteById($id){
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->tabla);
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'DELETE');
    }

    public function deleteSelect($arrayId){
        for ($i=0; $i<count($arrayId); $i++){
            $this->db->where($this->primary_key, $arrayId[$i]);
            $this->db->delete($this->tabla);
            $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        }
        detail_message($items, 'DELETE');


    }
}