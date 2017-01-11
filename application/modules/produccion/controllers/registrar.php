<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (produccion) > Registrar | Controllers
 * -------------------------------------------------------------------------------
 *
 * Registrar_Controllers version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 27/12/2016
 * Time: 01:16 AM
 *
 * @category   Controllers
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *  @property Produccion_model $models             Carga todos los metodos de la entidad padre [MODULO (Producción)]
 *  @var  array $items                             Load all models and set in view
 **/
class Registrar extends MX_Controller
{
    private $models;
    private $items = array();

    public function __construct(){

        parent::__construct();
        $this->schema['module']          = 'SUB MODULO 4';
        $this->schema['view']            = 'registrar';
        $this->schema['table']           = 'sys_produccion';
        $this->schema['detail']          = 'sys_produccion_detalle';
        $this->schema['pri_key']         = 'id_produccion';
        $this->schema['sec_key']         = 'cod_produccion';

        $this->models = $this->load->model('produccion_model');
        $this->items['getAll'] = $this->models;
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

    public function getDataTable()
    {
        $this->CRUD->read_data_table($this->schema['table'], $this->schema['options']);
    }
    public function getDataTable_libros()
    {
        $this->CRUD->read_data_table('sys_productos', $this->input->get());
    }

    public function searchAllById(){

        /**
         * @var array $result - (key & value)
         **/
        $id     = $this->input->post('id');
        $query  = $this->models->getAllById($id);




        if ($query) {
            foreach ($query as $key => $value) {
                $result = array($key => $value);
            }
            $data = array('success' => true, 'result' => $result);
            echo json_encode($data);
        } else {
            $data = array('success' => false);
            echo json_encode($data);
        }
    }

    public function searchAllByWhere(){
        /**
         * @var array $result - (key & value)
         **/
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $query = $this->models->getAllByWhere($id, $field);
        if ($query) {
            foreach ($query as $key => $value) {
                $result[] = array($key => $value);
            }
            $data = array('success' => true, 'result' => $result);
            echo json_encode($data);
        } else {
            $data = array('success' => false);
            echo json_encode($data);
        }
    }

    //ToDo - Esto se puede ejorar pasando solamente "$this->input->post()"
    public function save(){
        foreach ($this->input->post() as $key=>$value) {
            echo $key.' = '.$value;
        };
        //Static Date
        //$data           = array();
        //$cod_inventario = ($this->models->getLastCode('cod_inventario','sys_inventario')->cod_inventario)+1;
        //$origen         =$this->input->post('origen');
        //$id_chofer      =$this->input->post('id_chofer');
        //$id_vehiculo    =$this->input->post('id_vehiculo');
        //$destino        =$this->input->post('destino');
        //$operacion      ='+';
        //$lote           =$this->input->post('lote');
        //$comentario     =$this->input->post('comentario');
        //$documento      =$this->input->post('documento');
        //$fecha          =new DateTime($this->input->post('fecha'));

        //Dinamic Date
        /*
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
        */

        //Dinamic Date
        /*
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
*/
    }


    public function edit()
    {
        $id   = $this->input->post($this->models->primary_key);
        $data = ($this->input->post());
        $data = array_splice($data, 1);
        $this->models->editById($data, $id);
    }

    public function delete()
    {
        $this->CRUD->delete($this->schema['table'],$this->input->post());
    }

    public function deleteSelect()
    {
        $ids = $this->input->post('id');
        $this->CRUD->delete_much($this->schema['table'],$ids,$this->schema['pri_key']);
    }

}
