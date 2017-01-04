<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Almacenes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function load_setting_in_model($schema){
        $this->schema = $schema;
    }
    /**
     * -------------------------------------------------------------------------------
     * MODULO (almacenes) > almacen | models
     * -------------------------------------------------------------------------------
     **/
}