<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exoneracion extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->gbl_mdls = $this->load->model('global_views/global_model');
        $this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
        $this->models = $this->load->model('exoneracion_model');
        $this->alumnos_model = $this->load->model('configuracion/alumnos_model');

        //Datos de Auditoria
        $this->fecha_actual = date('Y-m-d h:m:i');
        $this->nombre_usuario = $this->session->userdata('nombre_usuario');
        $this->auditoria = array(
            'usuario_insertar' => $this->nombre_usuario,
            'fecha_insertar' => $this->fecha_actual
        );
    }

    public function index()
    {
        if (tiene_logeo()) {
            $xValQuery = $this->gbl_mdls->getCMenu_ByIdUser($this->idus);
            $xValCi = "SUB MODULO 3 - Exoneracion";
            $xValMeNu = array();
            if ($xValQuery) {
                foreach ($xValQuery as $key) {
                    $xValMeNu[] = $key->MenTitulo;
                }
                if (in_array($xValCi, $xValMeNu)) {
                    $queryAll = $this->models->getAll();
                    $queryAlumno = $this->alumnos_model->getAll();
                    $items = array(
                        'setByAll' => $queryAll,
                        'setByAlumno' => $queryAlumno,
                    );
                    $this->load->view('exoneracion', $items);
                } else {
                    $this->load->view('global_views/acceso_restringido');
                }
            } else {
                $this->load->view('global_views/404');
            }
        } else {
            redirect(base_url());
        }
    }

    public function save_trataminto()
    {
        $rango = $this->input->post('rango');
        $cod = $this->input->post('cod_alumno');
        $this->input->post('start1');
        $fecha = new DateTime($this->input->post('start1')); //La que va a Cambiar
        $inicio = new DateTime($this->input->post('start1')); //la de Incio
        $fin = new DateTime($this->input->post('start2')); //La de fin
        $cod_tra = $this->models->getCod_tra_especial() + 1;

        if ($rango == -1) {
            $data[0] = array(
                'cod_alumno' => $this->input->post('cod_alumno'),
                'cod_exoneracion' => $cod_tra,
                'fecha' => $fecha->format('Y-m-d'),
                'f_inicio' => $inicio->format('Y-m-d'),
                'f_fin' => $fin->format('Y-m-d'),
                'dias' => 1,
                'comentario' => $this->input->post('comentario')
            );
            $data[0] = array_merge($data[0], $this->auditoria);
        } else {
            for ($i = 0; $i <= $rango; $i++) {
                if ($i == 0) {
                    $fecha->sub(new DateInterval('P1D'));
                }
                $intervalo = new DateInterval('P1D');
                $fecha->add($intervalo);
                $data[$i] = array(
                    'cod_alumno' => $this->input->post('cod_alumno'),
                    'cod_exoneracion' => $cod_tra,
                    'fecha' => $fecha->format('Y-m-d'),
                    'f_inicio' => $inicio->format('Y-m-d'),
                    'f_fin' => $fin->format('Y-m-d'),
                    'dias' => $rango + 1,
                    'comentario' => $this->input->post('comentario')
                );
                $data[$i] = array_merge($data[$i], $this->auditoria);
            }
        }
        $this->models->actualizarEstado($cod);
        $this->models->createMultiple($data);
    }

    public function getAll()
    {
        $id = $this->input->post('id');
        $this->models->ListData($id);
    }

    public function archivarTodo()
    {
        $id = $this->input->post('id');
        $this->models->archivarTodo($id);
    }
}
/* End of file unidades.php */
/* Location: ./application/modules/configuracion/controllers/unidades.php */