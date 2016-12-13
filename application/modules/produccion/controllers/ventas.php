<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->gbl_mdls = $this->load->model('global_views/global_model');
        $this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
        $this->models = $this->load->model('ventas_model');

    }

    public function index()
    {
        $this->load->view('ventas');
    }

    public function getAll()
    {
        $this->models->ListData();
    }
    public function eliminar_unidad(){
        $id = $this->input->post('id');
        $this->models->deleteById($id);
    }
}

/* End of file venta.php */
/* Location: ./application/modules/comedor/controllers/venta.php */