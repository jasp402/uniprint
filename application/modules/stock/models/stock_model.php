<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function load_setting_in_model($schema)
    {
        $this->schema =$schema;
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->schema['table']);
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

    public function getAllLast_entrada()
    {
        $this->db->select($this->schema['pri_key']);
        $this->db->from($this->schema['table']);
        $this->db->order_by($this->schema['pri_key'], 'ASC');
        $query = $this->db->get();
        
        $items = array_pop($query->result());
        foreach ($items as $key=>$value){
            $items =  $value;
        }
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
        $this->db->from($this->schema['table']);
        $this->db->join('sys_ubicacion ', ' sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->join('sys_productos ', ' sys_inventario.id_producto = sys_productos.id_producto');
        $this->db->join('sys_tipos ', ' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias ', ' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->join('sys_proyecto ', ' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->join('sys_choferes ', ' sys_inventario.id_chofer = sys_choferes.id_chofer');
        $this->db->join('sys_vehiculos ', ' sys_inventario.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->where($this->schema['pri_key'], $items);
        $query = $this->db->get();
        //echo $this->db->last_query(); break;
        if ($query->num_rows() > 0) {
            $this->db->select('sys_ubicacion.nombre as nombre_destino');
            $this->db->from('sys_ubicacion');
            $this->db->where('id_ubicacion', $query->result()[0]->destino);
            $query_destino =  $this->db->get();
            $result1 = array();
            foreach ($query->result()[0]as $key=>$value){
                $result1[$key] = $value;
            }
            $result2 = array();
            foreach ($query_destino->result()[0] as $key=>$value){
                $result2[$key] = $value;
            }
            $result = array_merge($result1, $result2);
            $result = (object)$result;
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getAllLast_traslado()
    {
        $this->db->select($this->schema['pri_key']);
        $this->db->from($this->schema['table']);
        $this->db->order_by($this->schema['pri_key'], 'ASC');
        $query = $this->db->get();

        $items = array_pop($query->result());
        foreach ($items as $key=>$value){
            $items =  $value;
        }
        $this->db->select('sys_traslados.cod_traslado');
        $this->db->select('sys_traslados.fecha');
        $this->db->select('sys_ubicacion.nombre as nombre_origen');
        $this->db->select('sys_traslados.documento');
        $this->db->select('sys_proyecto.descripcion as proyecto');
        $this->db->select('sys_proyecto.descripcion as nombre_proyecto');
        $this->db->select('sys_categorias.nombre AS categoria');
        $this->db->select('sys_tipos.nombre AS tipo');
        $this->db->select('sys_productos.nombre AS producto');
        $this->db->select('sys_traslados.cant_lote');
        $this->db->select('sys_traslados.cant_unidades');
        $this->db->select('sys_traslados.total');
        $this->db->select('sys_traslados.destino');
        $this->db->select('sys_traslados.log_user as responsable');
        $this->db->select('sys_traslados.log_date as registro');
        $this->db->select(' sys_choferes.nombre_apellido as chofer');
        $this->db->select('sys_choferes.cedula');
        $this->db->select('sys_vehiculos.marca');
        $this->db->select('sys_vehiculos.modelo');
        $this->db->select('sys_vehiculos.placa');
        $this->db->from($this->schema['table']);
        $this->db->join('sys_ubicacion ', ' sys_traslados.origen = sys_ubicacion.id_ubicacion');
        $this->db->join('sys_productos ', ' sys_traslados.id_producto = sys_productos.id_producto');
        $this->db->join('sys_tipos ', ' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias ', ' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->join('sys_proyecto ', ' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->join('sys_choferes ', ' sys_traslados.id_chofer = sys_choferes.id_chofer');
        $this->db->join('sys_vehiculos ', ' sys_traslados.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->where($this->schema['pri_key'], $items);
        $query = $this->db->get();
//        echo $this->db->last_query(); break;
        if ($query->num_rows() > 0) {
            $this->db->select('sys_ubicacion.nombre as nombre_destino');
            $this->db->from('sys_ubicacion');
            $this->db->where('id_ubicacion', $query->result()[0]->destino);
            $query_destino =  $this->db->get();
            $result1 = array();
            foreach ($query->result()[0]as $key=>$value){
                $result1[$key] = $value;
            }
            $result2 = array();
            foreach ($query_destino->result()[0] as $key=>$value){
                $result2[$key] = $value;
            }
            $result = array_merge($result1, $result2);
            $result = (object)$result;
            return $result;
        } else {
            return FALSE;
        }
    }


    public function getLastCode($id,$table)
    {
        $this->db->select($id);
        $this->db->from($table);
        $this->db->order_by($id, 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $items = array();
        foreach ($query->result() as $key) {
            $items = $key;
        }

        //echo $this->db->last_query(); break;
        return $items;

    }

    public function getAllUbicacion()
    {
        $query=$this->db->query('select * from sys_ubicacion');
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

    public function getAllById($id)
    {
        $this->db->select('*');
        $this->db->from($this->schema['table']);
        $this->db->where($this->schema['pri_key'], $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getAllByWhere_documento_entrada($where)
    {
        $this->db->select('sys_inventario.cod_inventario');
        $this->db->select('sys_inventario.fecha');
        $this->db->select('sys_ubicacion.nombre AS origen');
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
        $this->db->from($this->schema['table']);
        $this->db->join('sys_ubicacion ',' sys_inventario.origen = sys_ubicacion.id_ubicacion');
        $this->db->join('sys_productos ',' sys_inventario.id_producto = sys_productos.id_producto');
        $this->db->join('sys_tipos ',' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias ',' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->join('sys_proyecto ',' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->join('sys_choferes ',' sys_inventario.id_chofer = sys_choferes.id_chofer');
        $this->db->join('sys_vehiculos ',' sys_inventario.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $value) {
                $result[][$key] = $value;
            }
            $data = array('success' => true, 'result' => $result);
            echo json_encode($data);

        } else {
            $data = array('success' => false);
            echo json_encode($data);

        }
    }


    public function getAllByWhere_documento_traslado($where)
    {
        $this->db->select('sys_traslados.cod_traslado');
        $this->db->select('sys_traslados.fecha');
        $this->db->select('sys_ubicacion.nombre AS origen');
        $this->db->select('sys_traslados.documento');
        $this->db->select('sys_proyecto.descripcion as proyecto');
        $this->db->select('sys_proyecto.descripcion as nombre_proyecto');
        $this->db->select('sys_categorias.nombre AS categoria');
        $this->db->select('sys_tipos.nombre AS tipo');
        $this->db->select('sys_productos.nombre AS producto');
        $this->db->select('sys_traslados.cant_lote');
        $this->db->select('sys_traslados.cant_unidades');
        $this->db->select('sys_traslados.total');
        $this->db->select('sys_traslados.destino');
        $this->db->select('sys_traslados.log_user as responsable');
        $this->db->select('sys_traslados.log_date as registro');
        $this->db->select(' sys_choferes.nombre_apellido as chofer');
        $this->db->select('sys_choferes.cedula');
        $this->db->select('sys_vehiculos.marca');
        $this->db->select('sys_vehiculos.modelo');
        $this->db->select('sys_vehiculos.placa');
        $this->db->from($this->schema['table']);
        $this->db->join('sys_ubicacion ',' sys_traslados.origen = sys_ubicacion.id_ubicacion');
        $this->db->join('sys_productos ',' sys_traslados.id_producto = sys_productos.id_producto');
        $this->db->join('sys_tipos ',' sys_tipos.id_tipo = sys_productos.id_tipo');
        $this->db->join('sys_categorias ',' sys_productos.id_categoria = sys_categorias.id_categoria');
        $this->db->join('sys_proyecto ',' sys_categorias.id_proyecto = sys_proyecto.id_proyecto');
        $this->db->join('sys_choferes ',' sys_traslados.id_chofer = sys_choferes.id_chofer');
        $this->db->join('sys_vehiculos ',' sys_traslados.id_vehiculo = sys_vehiculos.id_vehiculo');
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key => $value) {
                $result[][$key] = $value;
            }
            $data = array('success' => true, 'result' => $result);
            echo json_encode($data);

        } else {
            $data = array('success' => false);
            echo json_encode($data);

        }
    }


    public function getAllByWhereTwo($id1,$field1,$id2,$field2)
    {
        $this->db->select('*');
        $this->db->from($this->schema['table']);
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $query = $this->db->get();
        //echo $this->db->last_query();
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
                $dataDetail[$i]['codigo_barra'] = ($this->getLastCode('codigo_barra','sys_inventario_detalle')->codigo_barra) + 1;
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

    public function deleteselect($arrayId){
        for ($i=0; $i<count($arrayId); $i++){
            $this->db->where($this->primary_key, $arrayId[$i]);
            $this->db->delete($this->tabla);
            $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        }
        detail_message($items, 'DELETE');


    }

    public function sumarPaletas($cod){
        $this->db->select('Sum(cant_lote) as suma');
        $this->db->from($this->schema['table']);
        $this->db->where($this->schema['sec_key'], $cod);
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
        $this->db->from($this->schema['table']);
        $this->db->where($this->schema['sec_key'], $cod);
        $query = $this->db->get();
//        echo $this->db->last_query();
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