<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traslados_model extends CI_Model
{
    private $tabla;
    private $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_traslados';
        //$this->tabla_detalle = 'sys_inventario_detalle';
        $this->primary_key = 'id_traslado';
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }

    public function getAllLast()
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
       $this->db->order_by($this->primary_key,'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }

    public function getLastCode($id,$table)
    {
        $this->db->select($id);
        $this->db->from($table);
        $this->db->order_by($id, 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query(); break;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key) {
                $result =  $key->$id;
            }
            return $result;
        }else{
            return 0;
        }

    }

    public function getAllUbicacion()
    {
        $query=$this->db->query('SELECT * FROM sys_ubicacion');
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
        $this->db->SELECT('sys_inventario.id_inventario');
        $this->db->SELECT('sys_inventario.cod_inventario');
        $this->db->SELECT('sys_inventario.fecha');
        $this->db->SELECT('sys_ubicacion.nombre AS origen');
        $this->db->SELECT('sys_inventario.documento');
        $this->db->SELECT('sys_proyecto.descripcion as proyecto');
        $this->db->SELECT('sys_categorias.nombre AS categoria');
        $this->db->SELECT('sys_tipos.nombre AS tipo');
        $this->db->SELECT('sys_productos.nombre AS producto');
        $this->db->SELECT('sys_inventario.cant_lote');
        $this->db->SELECT('sys_inventario.cant_unidades');
        $this->db->SELECT('sys_inventario.total');
        $this->db->SELECT('sys_inventario.operacion');
        $this->db->SELECT('sys_inventario.id_producto');
        $this->db->SELECT('sys_inventario.lfoh');
        $this->db->SELECT('sys_inventario.id_producto');
        $this->db->FROM('sys_inventario');
        $this->db->JOIN('sys_ubicacion ',' sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->JOIN('sys_productos ',' sys_inventario.id_producto = sys_productos.id_producto');
        $this->db->JOIN('sys_tipos ',' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->JOIN('sys_categorias ',' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->JOIN('sys_proyecto ',' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        //$this->db->ORDER_BY('fecha', 'DESC');

        $query = $this->db->get();
        //echo $this->db->last_query();
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
        $this->db->SELECT('sys_inventario.cod_inventario');
        $this->db->SELECT('sys_inventario.fecha');
        $this->db->SELECT('sys_ubicacion.nombre AS origen');
        $this->db->SELECT('sys_inventario.documento');
        $this->db->SELECT('sys_proyecto.descripcion as proyecto');
        $this->db->SELECT('sys_proyecto.descripcion as nombre_proyecto');
        $this->db->SELECT('sys_categorias.nombre AS categoria');
        $this->db->SELECT('sys_tipos.nombre AS tipo');
        $this->db->SELECT('sys_productos.nombre AS producto');
        $this->db->SELECT('sys_inventario.cant_lote');
        $this->db->SELECT('sys_inventario.cant_unidades');
        $this->db->SELECT('sys_inventario.total');
        $this->db->SELECT('sys_inventario.operacion');
        $this->db->SELECT('sys_inventario.destino');
        $this->db->SELECT('sys_inventario.log_user as responsable');
        $this->db->SELECT('sys_inventario.log_date as registro');
        $this->db->SELECT(' sys_choferes.nombre_apellido as chofer');
        $this->db->SELECT('sys_choferes.cedula');
        $this->db->SELECT('sys_vehiculos.marca');
        $this->db->SELECT('sys_vehiculos.modelo');
        $this->db->SELECT('sys_vehiculos.placa');

        $this->db->FROM('sys_inventario');
        $this->db->JOIN('sys_ubicacion ',' sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->JOIN('sys_productos ',' sys_inventario.id_producto = sys_productos.id_producto');
        $this->db->JOIN('sys_tipos ',' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->JOIN('sys_categorias ',' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->JOIN('sys_proyecto ',' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->JOIN('sys_choferes ',' sys_inventario.id_chofer = sys_choferes.id_chofer');
        $this->db->JOIN('sys_vehiculos ',' sys_inventario.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->where($primary_key, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAllByWhereTwo($id1,$field1,$id2,$field2)
    {
        $this->db->select('*');
        $this->db->from($this->tabla);
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $query = $this->db->get();
        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }


    public function create_details($data){
        for($i=0,$c=count($data); $i<$c; $i++) {
            //$this->db->insert($this->tabla, $data[$i]);
            $details = $data[$i]['cant_lote'];
            //$cod_inventario = ($this->getLastCode('codigo_barra','sys_inventario_detalle') + 1);
            $dataDetail[$i]= array(
                'cod_inventario'=>$data[$i]['cod_inventario'],
                'id_producto'=>$data[$i]['id_producto'],
                'cantidad'=>$data[$i]['cant_unidades'],
                //'codigo_barra'=>$cod_inventario,
                'log_user' =>$data[$i]['log_user'],
                'log_date' =>$data[$i]['log_date']
            );
            for($j=0; $j<$details; $j++){
                $dataDetail[$i]['codigo_barra'] = ($this->getLastCode('codigo_barra','sys_inventario_detalle') + 1);
                $this->db->insert('sys_inventario_detalle',$dataDetail[$i]);
                //echo $this->db->last_query().'<br>';
            }
        }
    }

    public function create($data){
        $this->db->insert($this->tabla, $data);
        //echo $this->db->last_query();
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'CREATE');
    }

    public function createMultiple($data)
    {
        for($i=0,$c=count($data); $i<$c; $i++) {
            $this->db->insert($this->tabla, $data[$i]);
            //echo $data[$i]['cant_lote'];
            $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        }
        //break;
        //tomara el ultimo valor de num_err //ToDo - Mejorar esta función
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

    public function sumarPaletas($cod){
        $this->db->select('Sum(cant_lote) as suma');
        $this->db->from($this->tabla);
        $this->db->where('cod_traslado', $cod);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function sumarTotal($cod){
        $this->db->select('Sum(total) as suma');
        $this->db->from($this->tabla);
        $this->db->where('cod_traslado', $cod);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function editByIdWhere($data, $where){
        $this->db->where($where);
        $this->db->update($this->tabla, $data);
        //echo $this->db->last_query();
        $where = array_splice($where, 1);
        $this->db->where($where);
        $ajuste = array('cantidad'=>$data['cant_unidades']);
        $this->db->update($this->tabla_detalle, $ajuste);
        //echo $this->db->last_query(); break;
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'UPDATE');
    }
}