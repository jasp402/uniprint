<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (productos) > proyectos | Controllers
 * -------------------------------------------------------------------------------
 *
 * Proyectos_Controllers version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 17/11/2016
 * Time: 03:00 AM
 *
 * @category   Controllers
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *  @property Productos_model $models                   Carga todos los metodos de la entidad padre [MODULO (productos)]
 *  @var  array $items                                  Load all models and set in view
 **/
class proyectos extends MX_Controller {

    private $models;
    private $items =array();

    public function __construct(){
        parent::__construct();
        $this->schema['module']          = 'SUB MODULO 1 - Proyectos';
        $this->schema['view']            = 'proyectos';
        $this->schema['table']           = 'sys_proyecto';
        $this->schema['pri_key']         = 'id_proyecto';

        $this->models = $this->load->model('productos_model');
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

    public function searchAllById()
    {
        $id         = $this->input->post('id');
        $whereId    = array($this->schema['pri_key'] => $id);
        $this->CRUD->read_id($this->schema['table'],$whereId,'ajax');
    }

    public function save()
    {
        $data = $this->input->post();
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
        $this->CRUD->delete($this->schema['table'],$whereId);
    }
}