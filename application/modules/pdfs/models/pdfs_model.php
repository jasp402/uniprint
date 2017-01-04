<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfs_model extends CI_Model
{
    private $tabla;
    private $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_inventario';
        $this->primary_key = 'id_inventario';
    }
    //----------------------------------------
    public function LabelFull($cod)
    {
        //$last = $this->getLastCode('cod_inventario','sys_inventario');

        $this->db->SELECT('DISTINCT(sys_inventario_detalle.codigo_barra)');
        $this->db->SELECT('sys_inventario.fecha');
        $this->db->SELECT('sys_inventario.documento as nota_entrega');
        $this->db->SELECT('sys_inventario_detalle.cantidad');
        $this->db->SELECT('sys_inventario.log_user');
        $this->db->SELECT('sys_inventario.log_date');
        $this->db->SELECT('sys_productos.nombre as producto');
        $this->db->SELECT('sys_productos.detalle_1 as detalle');
        $this->db->SELECT('sys_ubicacion.nombre as origen');
        $this->db->SELECT('sys_ubicacion.rif');
        $this->db->SELECT('sys_tipos.nombre as tipo');
        $this->db->SELECT('sys_categorias.nombre as categoria');
        $this->db->SELECT('sys_choferes.nombre_apellido as chofer');
        $this->db->SELECT('sys_choferes.cedula');
        $this->db->SELECT('sys_vehiculos.placa');
        $this->db->SELECT('sys_vehiculos.marca');
        $this->db->SELECT('sys_proyecto.nombre as proyecto');
        $this->db->SELECT('sys_vehiculos.marca');
        $this->db->FROM('sys_inventario_detalle');
        $this->db->JOIN('sys_inventario',   'sys_inventario.cod_inventario = sys_inventario_detalle.cod_inventario');
        $this->db->JOIN('sys_productos',    'sys_inventario_detalle.id_producto = sys_productos.id_producto');
        $this->db->JOIN('sys_ubicacion',    'sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->JOIN('sys_tipos',        'sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->JOIN('sys_categorias',   'sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->JOIN('sys_vehiculos',    'sys_inventario.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->JOIN('sys_choferes',     'sys_inventario.id_chofer = sys_choferes.id_chofer');
        $this->db->JOIN('sys_proyecto',     'sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->WHERE('sys_inventario_detalle.cod_inventario',$cod );
        $query = $this->db->get();
      // echo $this->db->last_query();
        if ($query->num_rows()>0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }

    }
}