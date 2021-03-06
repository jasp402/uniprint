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

    public function save(){

        $data = $this->input->post();
        $data = array_merge($data,$this->auditoria);
        $data[$this->schema['sec_key']] = $this->CRUD->read_last($this->schema['sec_key'], $this->schema['table']);
            unset($data['id_producto'],$data['cant_lote']);

        //$this->CRUD->create($this->schema['table'], $data);

        //-------------------------------------------------------------------------------
        $data_detail['id_producto'] = $this->input->post('id_producto');
        $data_detail['cant_lote'] = $this->input->post('cant_lote');

        $a = count($data_detail['id_producto']);
        $b = count($data_detail['cant_lote']);

            if($a == $b){
                for($i=0; $i<$a; $i++){
                    $data_detail[$this->schema['sec_key']][$i]=$data[$this->schema['sec_key']];

                }
                $this->CRUD->create_much($this->schema['detail'],$data_detail);
               print_r($data_detail);

            }else{
                return false;
            }
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
