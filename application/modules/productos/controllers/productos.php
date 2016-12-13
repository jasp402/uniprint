<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Productos extends MX_Controller {
    public function __construct(){
        parent::__construct();
        //Basic model Functions
        $this->gbl_mdls = $this->load->model('global_views/global_model');
        $this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));

        //Local Models
        $this->models = $this->load->model('productos_model');
        $this->modelsCat = $this->load->model('categorias_model');
        $this->modelsTip = $this->load->model('tipos_model');
        $this->modelsProy = $this->load->model('proyectos_model');
        $this->modelsUnid = $this->load->model('unidades_model');
    }

    public function index(){
        if (tiene_logeo()) {
            $xValQuery = $this->gbl_mdls->getCMenu_ByIdUser($this->idus);
            $xValCi = "SUB MODULO 1"; // VALIDA CON LA BASE DE DATOS
            $xValMeNu = array();
            if ($xValQuery) {
                foreach ($xValQuery as $key) {
                    $xValMeNu[] = $key->MenTitulo;
                }
                if (in_array($xValCi, $xValMeNu)) {
                    $items = array(
                        'getAllProductos'   => $this->models->getAll(),
                        'getAllTipos'       => $this->modelsTip->getAll(),
                        'getAllCategorias'  => $this->modelsCat->getAll(),
                        'getAllProyectos'  => $this->modelsProy->getAll(),
                        'getAllUnidades'  => $this->modelsUnid->getAll()
                    );
                    $this->load->view('productos',$items);
                }else{
                    $this->load->view('global_views/acceso_restringido');
                }
            }else{
                $this->load->view('global_views/404');
            }
        }else{
            redirect(base_url());
        }
    }

    public function getDataTable()
    {
        $this->models->getDataTable();
    }

    public function searchAllById(){
        $id    = $this->input->post('id');
        $query =  $this->models->getAllById($id);
        if ($query) {
            foreach ($query as $key => $value) {
                $result = array($key => $value);
            }
            $data = array('success' => true, 'result' => $result);
            echo json_encode($data);
        }else{
            $data = array('success' => false);
            echo json_encode($data);
        }
    }

    public function searchAllByWhere(){
        $id1         = $this->input->post('id1');
        $field1      = $this->input->post('field1');
        $id2         = $this->input->post('id2');
        $field2      = $this->input->post('field2');
        $query      =  $this->models->getAllByWhere($id1,$field1,$id2,$field2);
        if ($query) {
            foreach ($query as $key => $value) {
                $result[] = array($key => $value);
            }
            $data = array('success' => true, 'result' => $result);
            echo json_encode($data);
        }else{
            $data = array('success' => false);
            echo json_encode($data);
        }
    }


    public function save(){
        $data = $this->input->post();
        $data = array_splice($data, 1);
        $data = array_splice($data, 1);
        $this->models->create($data);
    }

    public function edit(){
        $id    = $this->input->post('id_producto');
        $data = ($this->input->post());
        $data = array_splice($data, 1);
        $data = array_splice($data, 1);
        $this->models->editById($data,$id);
    }

    public function delete(){
        $id = $this->input->post('id');
        $this->models->deleteById($id);
    }

    public function deleteSelect(){
        $ids = $this->input->post('id');
        $this->models->deleteSelect($ids);
    }
}