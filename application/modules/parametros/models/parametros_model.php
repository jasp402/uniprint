<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (parametros) > parametros | models
 * -------------------------------------------------------------------------------
 *
 * Paramatros_model version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 13/12/2016
 * Time: 09:58 AM
 *
 * @category   Models
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 **/
class Parametros_model extends CI_Model
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
     * MODULO (parametros) > chofer | models
     * -------------------------------------------------------------------------------
     **/
    public function getAll_choferes()
    {
        $this->db->select('*');
        //$this->db->from('sys_choferes');
        $this->db->from($this->schema['table']);
        $this->db->order_by('cedula');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        } else {
            return FALSE;
        }
    }

    /**
     * -------------------------------------------------------------------------------
     * MODULO (parametros) > impresor | Models
     * -------------------------------------------------------------------------------
     **/
    public function getAll_impresores()
    {
        $where = $this->schema['options'];
        $this->db->select('*');
        $this->db->from($this->schema['table']);
        $this->db->where(key($where), $where[key($where)]);
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

    /**
     * -------------------------------------------------------------------------------
     * MODULO (parametros) > proveedores | Models
     * -------------------------------------------------------------------------------
     **/
    public function getAll_proveedores()
    {

        $this->db->select('*');
        $this->db->from($this->schema['table']);
        $this->db->where(key($where), $where[key($where)]);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        } else {
            return FALSE;
        }
    }

    /**
     * -------------------------------------------------------------------------------
     * MODULO (parametros) > vehiculos | Models
     * -------------------------------------------------------------------------------
     * + Incluye (graphic_statistics_vehiculo)
     **/
    public function getAll_vehiculos()
    {
        $this->db->select('*');
        $this->db->from($this->schema['table']);
        $this->db->order_by('placa');
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

    public function graphic_vehiculos(){

        $tabla = 'sys_vehiculos';
        $result = array();

        $this->db->select('*');
        $this->db->from($tabla);
        $this->db->where('marca', '---');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $g3 = array();
            foreach ($query->result() as $key) {
                $g3[] = $key;
            }
        }

        $this->db->select('*');
        $this->db->from($tabla);
        $this->db->where('modelo', '');
        $this->db->where('color', '');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $g2 = array();
            foreach ($query->result() as $key) {
                $g2[] = $key;
            }
        }


        $this->db->select('*');
        $this->db->from($tabla);
        $this->db->order_by('placa');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $g1 = array();
            foreach ($query->result() as $key) {
                $g1[] = $key;
            }
        }

        if(isset($g1) && isset($g2) && isset($g3)){
            bcscale(1);
            $prom1 = (count($g1)-count($g3)-count($g2));
            $success = bcdiv(($prom1*100),count($g1));
            //----------------------------
            $prom2 = count($g2);
            $regular = bcdiv(($prom2*100),count($g1));
            //----------------------------
            $prom3 = count($g3);
            $fail = bcdiv(($prom3*100),count($g1));
            //----------------------------
            $result['fail'] = $fail;
            $result['regular'] = $regular;
            $result['success'] = $success;
            $result['count_fail'] = count($g3);
            $result['count_regular'] = count($g2);
            $result['count_success'] = $prom1;
        }
        return $result;
    }

}
