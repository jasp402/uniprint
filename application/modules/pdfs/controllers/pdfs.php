<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pdfs extends MX_Controller {
    public function __construct(){
        parent::__construct();
        //Basic model Functions
        $this->gbl_mdls = $this->load->model('global_views/global_model');
        $this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));

        //Local Models
        $this->models               = $this->load->model('pdfs_model'); //Entrada ()
        $this->modelsChoferes       = $this->load->model('parametros/choferes_model');  //Choferes
        $this->modelsVehiculos      = $this->load->model('parametros/vehiculos_model'); //vehiculos
        $this->modelsProyectos      = $this->load->model('productos/proyectos_model');  //Productos
        $this->modelsCategorias     = $this->load->model('productos/Categorias_model');  //Productos
        $this->modelsTipos          = $this->load->model('productos/Tipos_model');  //Productos
        $this->modelsProductos      = $this->load->model('productos/productos_model');  //Productos
        $this->modelsAlmacen        = $this->load->model('almacenes/almacen_model'); //vehiculos
        $this->modelsImpresores     = $this->load->model('parametros/impresor_model');  //Impresores
        $this->modelsProveedores    = $this->load->model('parametros/proveedor_model'); //Proveedores

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
                    $items = array(
                        'getAll'  => $this->models->getAll(),
                        'getAllUbicacion'   => $this->models->getAllUbicacion(),
                        'getAllVehiculos'   => $this->modelsVehiculos->getAll(),
                        'getAllChoferes'    => $this->modelsChoferes->getAll(),
                        'getAllProductos'   => $this->modelsProductos->getAll(),
                        'getAllImpresores'  => $this->modelsImpresores->getAll(),
                        'getAllProveedores' => $this->modelsProveedores->getAll(),
                        'getAllCategorias'  => $this->modelsCategorias->getAll(),
                        'getAllTipos'       => $this->modelsTipos->getAll(),
                        'getAllProyectos'   => $this->modelsProyectos->getAll(),
                        'getAllAlmacenes'   => $this->modelsAlmacen->getAll(),
                        'getAllInventario'   => $this->modelsAlmacen->getAll(),
                        'auditoria'         => $this->auditoria
                    );
                    $this->load->view('pdfs',$items);
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
        //Static Date
        $cod_inventario = ($this->models->getLastCode('cod_inventario','sys_inventario') + 1);
        $origen         =$this->input->post('origen');
        $id_chofer      =$this->input->post('id_chofer');
        $id_vehiculo    =$this->input->post('id_vehiculo');
        $destino        =$this->input->post('destino');
        $operacion        ='+';
        //$id_proyecto    =$this->input->post('id_proyecto');
        $documento      =$this->input->post('documento');
        $fecha          =new DateTime($this->input->post('fecha'));
        $StaticDate[0] = array(
            'cod_inventario'=>$cod_inventario,
            'origen' =>$origen,
            'id_chofer' =>$id_chofer,
            'id_vehiculo' =>$id_vehiculo,
            'destino' =>$destino,
            //'id_proyecto' =>$id_proyecto,
            'documento' =>$documento,
            'fecha' =>$fecha->format('Y-m-d'),
            'operacion ' =>$operacion
        );

        //Dinamic Date

            $items = count($this->input->post('id_producto'));

            $id_producto    =$this->input->post('id_producto');
            $cant_lote      =$this->input->post('cant_lote');
            $cant_unidades  =$this->input->post('cant_unidades');

        for($i=0;$i<$items; $i++){
            $DinamicDate[$i]= array(
                'id_producto'=>$id_producto[$i],
                'cant_lote'=>$cant_lote[$i],
                'cant_unidades'=>$cant_unidades[$i],
                'total'=>($cant_lote[$i]*$cant_unidades[$i])
            );
            $data[$i] = array_merge($StaticDate[0], $DinamicDate[$i], $this->auditoria);
        }
        //$data = $this->input->post();
        //$data = array_splice($data, 1);

        $this->models->createMultiple($data);
        $this->models->create_details($data);
    }

    public function edit(){
        $id    = $this->input->post('id');
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

    //----------------------------
    public function LabelFull($cod)
    {
        $this->models->LabelFull($cod);
    }




}
