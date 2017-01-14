<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (produccion) > descontar | Controllers
 * -------------------------------------------------------------------------------
 *
 * Descontar_Controllers version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 14/01/2017
 * Time: 10:18 AM
 *
 * @category   Controllers
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *  @property Produccion_model $models             Carga todos los metodos de la entidad padre [MODULO (Producción)]
 *  @var  array $items                             Load all models and set in view
 **/
class Descontar extends MX_Controller
{
    private $models;
    private $items = array();
    public function __construct(){
        parent::__construct();
        $this->schema['module']     =  'SUB MODULO 4';
        $this->schema['view']       =  'descontar';
        $this->schema['table']      =  'sys_inventario';
        $this->schema['detail']     =  'sys_inventario_detalle';
        $this->schema['pri_key']    =  'id_inventario';
        $this->schema['sec_key']    =  'cod_inventario';
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
}