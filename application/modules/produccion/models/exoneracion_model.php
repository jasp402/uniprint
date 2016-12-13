<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exoneracion_model extends CI_Model
{
    private $tabla;
    private $primary_key;

    public function __construct()
    {
        parent::__construct();
        $this->tabla = 'sys_exoneracion';
        $this->primary_key = 'cod_exoneracion';
        $this->autoChecked();
    }

    public function getAll()
    {
        $query=$this->db->query('SELECT DISTINCT
sys_alumno.nombre_1,
sys_alumno.nombre_2,
sys_exoneracion.cod_alumno,
sys_exoneracion.f_inicio,
sys_exoneracion.f_fin,
sys_exoneracion.dias,
sys_exoneracion.comentario,
sys_alumno.apellido_paterno,
sys_alumno.apellido_materno,
sys_exoneracion.cod_exoneracion,
sys_exoneracion.estado
FROM
sys_alumno
JOIN sys_exoneracion ON sys_exoneracion.cod_alumno = sys_alumno.cod_alumno
WHERE estado = 1
GROUP BY
sys_alumno.cod_alumno,
sys_exoneracion.fecha,
sys_alumno.nombre_1,
sys_alumno.nombre_2,
sys_exoneracion.f_inicio,
sys_exoneracion.f_fin,
sys_exoneracion.dias,
sys_exoneracion.comentario,
sys_alumno.apellido_paterno,
sys_alumno.apellido_materno,
sys_exoneracion.cod_exoneracion,
sys_exoneracion.estado
ORDER BY sys_exoneracion.cod_exoneracion DESC');
        //  $query = $this->db->get();
        // echo $this->db->last_query(); break;
        if ($query->num_rows()) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }
    public function getAllDetails()
    {
        $this->db->select('alumno.*, exoneracion.* ');
        $this->db->from('sys_exoneracion exoneracion');
        $this->db->join('sys_alumno alumno', 'alumno.cod_alumno = exoneracion.cod_alumno');
        $this->db->where('estado',1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }
    }

    public function ListData($id)
    {

        $this->db->select('alumno.*, exoneracion.* ');
        $this->db->from('sys_exoneracion exoneracion');
        $this->db->join('sys_alumno alumno', 'alumno.cod_alumno = exoneracion.cod_alumno');
//        $this->db->where('estado',1);
        $this->db->where('exoneracion.cod_alumno',$id);
        $this->db->order_by('exoneracion.fecha', 'asc');

        $query = $this->db->get();
//        echo $this->db->last_query(); break;
        $result = array(
            "draw"=>1,
            "recordsTotal"=> $query->num_rows(),
            "recordsFiltered"=> $query->num_rows(),
            'data'	=> $query->result());
        echo json_encode($result);
    }

    public function getCod_tra_especial()
    {
        $this->db->select('cod_tra_especial');
        $this->db->from('sys_tratamiento_especial');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $key) {
                $result =  $key->cod_tra_especial;
            }
            return $result;
        }else{
            return 1;
        }

    }


    public function createMultiple($data)
    {
        for($i=0,$c=count($data); $i<$c; $i++) {
            $this->db->insert($this->tabla, $data[$i]);
//            echo $this->db->last_query();
            $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        }
        //tomara el ultimo valor de num_err //ToDo - Mejorar esta función
        detail_message($items, 'CREATE');
    }

    public function actualizarEstado($cod){
        // '0' Desactivado
        // '1' Activo
        $data = array('estado' => '0');
        $this->db->where('cod_alumno',$cod);
        $this->db->update($this->tabla,$data);
        return true;
    }

    public function archivarTodo($cod){
        $data = array('estado' => '0');
        $this->db->where('cod_alumno',$cod);
        $this->db->update($this->tabla,$data);
        $items = array('num_err' => $this->db->_error_number(), 'mens_err' => $this->db->_error_message());
        detail_message($items, 'ARCHIVE');
    }

    private function autoChecked(){
        //Chequea el dia. lo comprara en la bd y cambia el status
        $fecha = new DateTime();
        $fecha->sub(new DateInterval('P1D')); //Ayer
        $data = array('estado' => '0','fecha' => $fecha->format('Y-m-d'));
        $this->db->where('fecha',$fecha->format('Y-m-d'));
        $this->db->update($this->tabla,$data);
    }
}


// echo $this->db->last_query(); break;
/* End of file unidades_model.php */
/* Location: ./application/modules/configuracion/models/unidades_model.php */