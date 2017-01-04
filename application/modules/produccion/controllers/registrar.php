<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registrar extends MX_Controller {
    public function __construct(){
        parent::__construct();
        //Basic model Functions
        $this->gbl_mdls = $this->load->model('global_views/global_model');
        $this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));

        //Local Models
        /* ToDo - Crear model (lineas_model) */
        $this->models = $this->load->model('produccion_model');
        $this->modelsProyectos      = $this->load->model('productos/proyectos_model');      //Productos->proyectos
        $this->modelsCategorias     = $this->load->model('productos/Categorias_model');     //Productos->categorias
        $this->modelsTipos          = $this->load->model('productos/Tipos_model');          //Productos->tipos
        $this->modelsProductos      = $this->load->model('productos/productos_model');      //Productos->produccions
        $this->modelsAlmacen        = $this->load->model('almacenes/almacen_model');        //Ubicacion->Almacenes

        //complement
        $this->tipo_proveedor = array('tipo' => 'externo');
    }

    public function index(){
        if (tiene_logeo()) {
            $xValQuery = $this->gbl_mdls->getCMenu_ByIdUser($this->idus);
            $xValCi = "SUB MODULO 4";
            $xValMeNu = array();
            if ($xValQuery) {
                foreach ($xValQuery as $key) {
                    $xValMeNu[] = $key->MenTitulo;
                }
                if (in_array($xValCi, $xValMeNu)) {
                    $items = array(
                        'getAll'  => $this->models->getAll()
                    );
                    $this->load->view('registrar',$items);
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

    public function  searchAllByWhere(){
        $id         = $this->input->post('id');
        $field      = $this->input->post('field');
        $query      =  $this->models->getAllByWhere($id,$field);
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
        $data = array_merge($data, $this->tipo_proveedor);
        $data = array_splice($data, 1);
        $this->models->create($data);
    }

    public function edit(){
        $id    = $this->input->post($this->models->primary_key);
        $data = ($this->input->post());
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
