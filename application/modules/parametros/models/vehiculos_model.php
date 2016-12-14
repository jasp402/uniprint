<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiculos_model extends CI_Model
{
    public $tabla;
    public $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_vehiculos';
        $this->primary_key = 'id_vehiculo';
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->order_by('placa');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }

    public function statisct(){
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->WHERE('marca', '---');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $g3 = array();
            foreach ($query->result() as $key) {
                $g3[] = $key;
            }
        }
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->WHERE('modelo', '');
        $this->db->WHERE('color', '');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $g2 = array();
            foreach ($query->result() as $key) {
                $g2[] = $key;
            }
        }
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->order_by('placa');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $g1 = array();
            foreach ($query->result() as $key) {
                $g1[] = $key;
            }
        }
        bcscale(1);
        $prom1 = (count($g1)-count($g3));
        $success = bcdiv(($prom1*100),count($g1));
        //----------------------------
        $prom2 = count($g2);
        $regular = bcdiv(($prom2*100),count($g1));
        //----------------------------
        $prom3 = count($g3);
        $fail = bcdiv(($prom3*100),count($g1));
        //----------------------------
            return array("fail"=>$fail,
                         "regular"=>$regular,
                         "success"=>$success,
                        'count_fail'=>count($g3),
                        'count_regular'=>count($g2),
                        'count_success'=>$prom1,
                );
    }

    public function getDataTable()
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