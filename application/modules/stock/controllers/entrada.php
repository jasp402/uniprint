<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (stock) > entrada | Controllers
 * -------------------------------------------------------------------------------
 *
 * Entrada_Controllers version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 13/12/2016
 * Time: 09:58 AM
 *
 * @category   Controllers
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *  @property stock_model $models                   Carga todos los metodos de la entidad padre [MODULO (stock)]
 *  @var  array $items                                  Load all models and set in view
 **/
class Entrada extends MX_Controller {

    private $models;
    private $items =array();

    public function __construct(){
        parent::__construct();
        $this->schema['module']  =  'SUB MODULO 3';
        $this->schema['view']    =  'entrada';
        $this->schema['table']   =  'sys_inventario';
        $this->schema['detail']  =  'sys_inventario_detalle';
        $this->schema['pri_key'] =  'id_inventario';
        $this->schema['sec_key'] =  'cod_inventario';

        $this->models = $this->load->model('stock_model');
        $this->items['getAll']=$this->models;

        $this->models->load_setting_in_model($this->schema);
    }

    public function load_setting_in_view()
    {
        echo json_encode($this->schema);
    }

    public function index()
    {
        parent::__index($this->schema['module'], $this->schema['view'], $this->items);
    }

    public function  search_documento(){
        $this->models->getAllByWhere_documento_entrada($this->input->post());
    }

    //ToDo - Esto se puede ejorar pasando solamente "$this->input->post()"
    public function save(){
        //Static Date
        $data           = array();
        $cod_inventario = ($this->models->getLastCode('cod_inventario','sys_inventario')->cod_inventario)+1;
        $origen         =$this->input->post('origen');
        $id_chofer      =$this->input->post('id_chofer');
        $id_vehiculo    =$this->input->post('id_vehiculo');
        $destino        =$this->input->post('destino');
        $operacion      ='+';
        $lote           =$this->input->post('lote');
        $comentario     =$this->input->post('comentario');
        $documento      =$this->input->post('documento');
        $fecha          =new DateTime($this->input->post('fecha'));

        //Dinamic Date
        $StaticDate[0]  = array(
        'cod_inventario'=>$cod_inventario,
        'origen'        =>$origen,
        'id_chofer'     =>$id_chofer,
        'id_vehiculo'   =>$id_vehiculo,
        'destino'       =>$destino,
        'documento'     =>$documento,
        'fecha'         =>$fecha->format('Y-m-d'),
        'comentario'    => $comentario,
        'lote'          => $lote,
        'operacion'     =>$operacion
        );

        //Dinamic Date
            $items          = count($this->input->post('id_producto'));

            $id_producto    =$this->input->post('id_producto');
            $cant_lote      =$this->input->post('cant_lote');
            $cant_unidades  =$this->input->post('cant_unidades');
            $total          =$this->input->post('total');

        for($i=0;$i<$items; $i++){
            $DinamicDate[$i]= array(
                'id_producto'=>$id_producto[$i],
                'cant_lote'=>$cant_lote[$i],
                'cant_unidades'=>$cant_unidades[$i],
                'total'=>$total[$i]
            );
            $data[$i] = array_merge($StaticDate[0], $DinamicDate[$i], $this->auditoria);
        }
        $this->CRUD->create_much($this->schema['table'],$data);
        if($lote=='si'){$this->models->create_details($data);}

    }
}
