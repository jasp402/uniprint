<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model
{
    private $tabla;
    private $primary_key;
    //foraneas
    private $foreign_cat;
    private $foreign_tip;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_productos';
        $this->primary_key = 'id_producto';
        //foraneas
        $this->foreign_cat = 'id_categoria';
        $this->foreign_tip = 'id_tipo';
    }

    public function getAll()
    {
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($this->tabla);
        $this->db->join('sys_tipos', 'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias', 'sys_categorias.id_categoria = sys_productos.id_categoria');
        $this->db->join('sys_proyecto', 'sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->join('sys_unidades', 'sys_unidades.id_unidad = sys_productos.id_unidad');
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

    public function getDataTable()
    {
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($this->tabla);
        $this->db->join('sys_tipos', 'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias', 'sys_categorias.id_categoria = sys_productos.id_categoria');
        $this->db->join('sys_proyecto', 'sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->join('sys_unidades', 'sys_unidades.id_unidad = sys_productos.id_unidad');
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
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_proyecto.id_proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($this->tabla);
        $this->db->join('sys_tipos', 'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias', 'sys_categorias.id_categoria = sys_productos.id_categoria');
        $this->db->join('sys_proyecto', 'sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->join('sys_unidades', 'sys_unidades.id_unidad = sys_productos.id_unidad');
        $this->db->where($this->primary_key, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAllByWhere($id1, $field1,$id2,$field2)
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $query = $this->db->get();
        //echo $this->db->last_query(); break;
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

    public function editById($data, $id){
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

    public function deleteSelect($arrayId){
        for ($i=0; $i<count($arrayId); $i++){
            $this->db->where($this->primary_key, $arrayId[$i]);
            $this->db->delete($this->tabla);
            $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        }
        detail_message($items, 'DELETE');


    }
}