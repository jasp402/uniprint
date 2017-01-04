<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pdfs extends MX_Controller {
    public function __construct(){
        parent::__construct();
        //Basic model Functions
        $this->gbl_mdls = $this->load->model('global_views/global_model');
        $this->pdf_mdls = $this->load->model('global_views/global_model');
        $this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));

        //Local Models
        $this->models               = $this->load->model('pdfs_model'); //Entrada ()


        //Datos de Auditoria
        $this->fecha_actual = date('Y-m-d h:m:i');
        $this->nombre_usuario = $this->session->userdata('nombre_usuario');
        $this->auditoria = array(
            'log_user' => $this->nombre_usuario,
            'log_date' => $this->fecha_actual
        );
    }

    public function index(){
        if (tiene_logeo()) {
            $xValQuery = $this->gbl_mdls->getCMenu_ByIdUser($this->idus);
            $xValCi = "SUB MODULO 2";
            $xValMeNu = array();
            if ($xValQuery) {
                foreach ($xValQuery as $key) {
                    $xValMeNu[] = $key->MenTitulo;
                }
                if (in_array($xValCi, $xValMeNu)) {

                    $this->load->view('pdfs');

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

    //----------------------------
    public function LabelFull($cod)
    {
        $this->models->LabelFull($cod);
    }




}
