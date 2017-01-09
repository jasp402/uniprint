<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (productos) > productos | models
 * -------------------------------------------------------------------------------
 *
 * Productos_model version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 13/12/2016
 * Time: 09:58 AM
 *
 * @category   Models
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 **/
class Productos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function load_setting_in_model($schema)
    {
        $this->schema =$schema;
    }
    /**
     * -------------------------------------------------------------------------------
     * MODULO (productos) > productos | models
     * -------------------------------------------------------------------------------
     **/
    public function getAll_productos()
    {
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($this->schema['table']);
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
        }else{
            return FALSE;
        }
    }

    public function getDataTable_productos()
    {
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($this->schema['table']);
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

    public function getDataTableWhere_productos($table, $where)
    {
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($table);
        $this->db->join('sys_tipos', 'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias', 'sys_categorias.id_categoria = sys_productos.id_categoria');
        $this->db->join('sys_proyecto', 'sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->join('sys_unidades', 'sys_unidades.id_unidad = sys_productos.id_unidad');
        $this->db->where($where);
        $query = $this->db->get();
        $result = array(
        "draw"=>1,
        "recordsTotal"=> $query->num_rows(),
        "recordsFiltered"=> $query->num_rows(),
        'data'	=> $query->result());
        echo json_encode($result);
    }

    public function getAllById_productos($id)
    {
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->select('sys_tipos.nombre as tipo');
        $this->db->select('sys_productos.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->select('sys_proyecto.id_proyecto');
        $this->db->select('sys_unidades.nombre as unidad');
        $this->db->from($this->schema['table']);
        $this->db->join('sys_tipos', 'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias', 'sys_categorias.id_categoria = sys_productos.id_categoria');
        $this->db->join('sys_proyecto', 'sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->join('sys_unidades', 'sys_unidades.id_unidad = sys_productos.id_unidad');
        $this->db->where($this->schema['pri_key'], $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * -------------------------------------------------------------------------------
     * MODULO (productos) > tipos | models
     * -------------------------------------------------------------------------------
     **/
    public function getAll_tipos()
    {
        $this->db->select('sys_tipos.*');
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->from($this->schema['table']);
        $this->db->join('sys_categorias','sys_categorias.id_categoria = sys_tipos.id_categoria');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }else{
            return FALSE;
        }
    }

    /**
     * -------------------------------------------------------------------------------
     * MODULO (productos) > tipos | models
     * -------------------------------------------------------------------------------
     **/
    public function getAll_categorias()
    {
        $this->db->select('sys_categorias.*');
        $this->db->select('sys_proyecto.nombre as proyecto');
        $this->db->from($this->schema['table']);
        $this->db->join('sys_proyecto','sys_proyecto.id_proyecto = sys_categorias.id_proyecto');
        $this->db->order_by($this->schema['pri_key']);
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

}