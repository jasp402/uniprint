<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyectos_model extends CI_Model
{
    private $tabla;
    private $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_proyecto';
        $this->primary_key = 'id_proyecto';
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from('sys_proyecto');
        $query = $this->db->get();
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

//save_alumno
    public function create($data)
    {
        $this->db->insert($this->tabla, $data);
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'CREATE');
    }

//UpdateAlumnoById
    public function editById($data,$id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->tabla, $data);
//        echo $this->db->last_query();
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'UPDATE');
    }

//deleteAlumnoById
    public function deleteById($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->tabla);
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'DELETE');
    }


}
// echo $this->db->last_query(); break;
/* End of file alumnos_model.php */
/* Location: ./application/modules/configuracion/models/alumnos_model.php */
/**
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 17/11/2016
 * Time: 03:00 PM
 */