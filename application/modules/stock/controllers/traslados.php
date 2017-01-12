<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (stock) > traslados | Controllers
 * -------------------------------------------------------------------------------
 *
 * Traslados_Controllers version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 03/01/2017
 * Time: 03:23 AM
 *
 * @category   Controllers
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *  @property stock_model $models                   Carga todos los metodos de la entidad padre [MODULO (stock)]
 *  @var  array $items                                  Load all models and set in view
 **/
class Traslados extends MX_Controller {

    private $models;
    private $items =array();
//O.K.
    public function __construct(){
        parent::__construct();
        $this->schema['module']  =  'SUB MODULO 3';
        $this->schema['view']    =  'traslados';
        $this->schema['table']   =  'sys_traslados';
        $this->schema['pri_key'] =  'id_traslado';
        $this->schema['sec_key'] =  'cod_traslado';

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
        $this->models->getAllByWhere_documento_traslado($this->input->post());
    }

    //ToDo - Esto se puede mejorar pasando solamente "$this->input->post()"
    //ToDo - Hay Que eliminar el campo contenedor de la tabla 'sys_traslados'
    public function save(){
        $data = array();
        //Static Date
        $cod_traslado = ($this->models->getLastCode('cod_traslado','sys_traslados')->cod_traslado)+1;
        $origen         =$this->input->post('origen');
        $id_chofer      =$this->input->post('id_chofer');
        $id_vehiculo    =$this->input->post('id_vehiculo');
        $destino        =$this->input->post('destino');
        $comentario     =$this->input->post('comentario');
        $documento      =$this->input->post('documento');
        $fecha          =new DateTime($this->input->post('fecha'));
        $StaticDate[0]  = array(
            'cod_traslado'=>$cod_traslado,
            'origen' =>$origen,
            'id_chofer' =>$id_chofer,
            'id_vehiculo' =>$id_vehiculo,
            'destino' =>$destino,
            //'id_proyecto' =>$id_proyecto,
            'documento' =>$documento,
            'fecha' =>$fecha->format('Y-m-d'),
            'comentario' => $comentario
        );

        //Dinamic Date

        $items = count($this->input->post('id_producto'));

        $id_producto    =$this->input->post('id_producto');
        $cant_lote      =$this->input->post('cant_lote');
        $cant_unidades  =$this->input->post('cant_unidades');

        for($i=0;$i<$items; $i++){
            $DinamicDate[$i]= array(
                'id_producto'=>$id_producto[$i],
                'cant_lote'=>$cant_lote[$i],
                'cant_unidades'=>$cant_unidades[$i],
                'total'=>($cant_lote[$i]*$cant_unidades[$i])
            );
            $data[$i] = array_merge($StaticDate[0], $DinamicDate[$i], $this->auditoria);
        }
        //$data = $this->input->post();
        //$data = array_splice($data, 1);
        $this->CRUD->create_much($this->schema['table'],$data);
        //$this->models->create_details($data);
    }

    public function unidades_disponible(){

        $where = $this->input->post();
        $where['origen'] = $this->input->post('destino');
        unset($where['destino']);

        $entrada    = $this->CRUD->read_field_table('sum(total) as entro','sys_inventario',$this->input->post());
        $traslado   = $this->CRUD->read_field_table('sum(total) as salio','sys_traslados',$where);

        $saldo = ($entrada[0]->entro)-$traslado[0]->salio;
        $data = array('success' => true, 'result' => $saldo);
        echo json_encode($data);
    }
}
