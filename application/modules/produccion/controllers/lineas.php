<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (produccion) > Lineas | Controllers
 * -------------------------------------------------------------------------------
 *
 * Lineas_Controllers version 0.0.1
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
class Lineas extends MX_Controller
{
    private $models;
    private $items = array();

    public function __construct(){

        parent::__construct();
        $this->schema['module']          = 'SUB MODULO 4';
        $this->schema['view']            = 'lineas';
        $this->schema['table']           = 'sys_ubicacion';
        $this->schema['pri_key']         = 'id_ubicacion';
        $this->schema['options']['tipo'] = 'linea';

        $this->models = $this->load->model('produccion_model');
        $this->items['getAll'] = $this->models;
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

    public function searchAllById(){

        $id         = $this->input->post('id');
        $whereId    = array($this->schema['pri_key'] => $id);
        $this->CRUD->read_id($this->schema['table'], $whereId, 'ajax');
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

    public function save()
    {
        $data = $this->input->post();
        $data = array_merge($data, $this->schema['options']);
        $data = array_splice($data, 1);
        $this->CRUD->create($this->schema['table'],$data);
    }

    public function edit()
    {
        $id         = $this->input->post($this->schema['pri_key']);
        $whereId    = array($this->schema['pri_key'] => $id);
        $data       = ($this->input->post());
        $data       = array_splice($data, 1);
        $this->CRUD->edit($this->schema['table'], $data, $whereId);
    }

    public function delete(){
        $id         = $this->input->post('id');
        $whereId    = array($this->schema['pri_key'] => $id);
        $this->CRUD->delete($this->schema['table'],$whereId,'ajax');
    }

    public function deleteSelect(){
        $arrayId    = $this->input->post('id');
        $fieldKey   = $this->schema['pri_key'];
        $this->CRUD->delete_much($this->schema['table'],$arrayId,$fieldKey);
    }

}
