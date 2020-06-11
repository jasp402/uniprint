<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Produccion_model extends CI_Model
{
    public $tabla;
    public $primary_key;

    public function __construct()
    {
        parent::__construct();
    }

    public function load_setting_in_model($schema){
        $this->schema = $schema;
    }
    public function dataTable_inventario_inactivo($table,$where)
    {
        $this->db->select('sys_inventario.cod_inventario');
        $this->db->select('sys_inventario.fecha');
        $this->db->select('sys_ubicacion.nombre as nombre_origen');
        $this->db->select('sys_inventario.documento');
        $this->db->select('sys_proyecto.descripcion as proyecto');
        $this->db->select('sys_proyecto.descripcion as nombre_proyecto');
        $this->db->select('sys_categorias.nombre AS categoria');
        $this->db->select('sys_tipos.nombre AS tipo');
        $this->db->select('sys_productos.nombre AS producto');
        $this->db->select('sys_inventario.cant_lote');
        $this->db->select('sys_inventario.cant_unidades');
        $this->db->select('sys_inventario.total');
        $this->db->select('sys_inventario.operacion');
        $this->db->select('sys_inventario.destino');
        $this->db->select('sys_inventario.log_user as responsable');
        $this->db->select('sys_inventario.log_date as registro');
        $this->db->select(' sys_choferes.nombre_apellido as chofer');
        $this->db->select('sys_choferes.cedula');
        $this->db->select('sys_vehiculos.marca');
        $this->db->select('sys_vehiculos.modelo');
        $this->db->select('sys_vehiculos.placa');
        $this->db->select('sys_inventario_detalle.estado');
        $this->db->select('sys_inventario_detalle.cantidad');
        $this->db->select('sys_inventario_detalle.codigo_barra');
        $this->db->from($table);
        $this->db->join('sys_inventario_detalle ', ' sys_inventario.cod_inventario = sys_inventario_detalle.cod_inventario');
        $this->db->join('sys_ubicacion ', ' sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->join('sys_productos ', ' sys_inventario.id_producto = sys_productos.id_producto');
        $this->db->join('sys_tipos ', ' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias ', ' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->join('sys_proyecto ', ' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->join('sys_choferes ', ' sys_inventario.id_chofer = sys_choferes.id_chofer');
        $this->db->join('sys_vehiculos ', ' sys_inventario.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = array(
            "draw"=>1,
            "recordsTotal"=> $query->num_rows(),
            "recordsFiltered"=> $query->num_rows(),
            'data'	=> $query->result());
        echo json_encode($result);
    }

    public function inventario_activo($table)
    {
        $this->db->select('sys_inventario_detalle.estado');
        $this->db->select('Sum(sys_inventario_detalle.cantidad) AS procesado');
        $this->db->select('sys_ubicacion.nombre AS origen_nombre');
        $this->db->select('sys_productos.nombre AS producto');
        $this->db->select('sys_tipos.nombre AS tipo');
        $this->db->select('sys_categorias.nombre as categoria');
        $this->db->from($table);
        $this->db->join('sys_inventario', 'sys_inventario.cod_inventario = sys_inventario_detalle.cod_inventario');
        $this->db->join('sys_ubicacion', 'sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->join('sys_productos', 'sys_inventario.id_producto = sys_productos.id_producto');
        $this->db->join('sys_tipos', 'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias', 'sys_tipos.id_categoria = sys_categorias.id_categoria');
        $this->db->where('sys_categorias.id_categoria < 3');
        $this->db->group_by('sys_inventario_detalle.estado');
        $this->db->group_by('sys_inventario.origen');
        $this->db->group_by('sys_inventario.id_producto');
        $this->db->group_by('sys_productos.nombre');
        $this->db->group_by('sys_tipos.nombre');
        $this->db->group_by('sys_categorias.nombre');
        $this->db->order_by('sys_categorias.nombre, sys_tipos.nombre,sys_productos.nombre','ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}