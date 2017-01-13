<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * -------------------------------------------------------------------------------
 * MODULO (stock) > inventario | Controllers
 * -------------------------------------------------------------------------------
 *
 * Inventario_Controllers version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 13/12/2016
 * Time: 09:58 AM
 *
 * @category   Controllers
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *  @property stock_model $models                   Carga todos los metodos de la entidad padre [MODULO (stock)]
 *  @var  array $items                                  Load all models and set in view
 **/
class Inventario extends MX_Controller {

    private $models;
    private $items =array();

    public function __construct(){
        parent::__construct();
        $this->schema['module']  =  'SUB MODULO 3';
        $this->schema['view']    =  'inventario';
        $this->schema['table']   =  'sys_inventario';
        $this->schema['detail']  =  'sys_inventario_detalle';
        $this->schema['pri_key'] =  'id_inventario';
        $this->schema['sec_key'] =  'cod_inventario';

        $this->models = $this->load->model('stock_model');
        $this->items['getAll']=$this->models;

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

    public function getDataTable()
    {
        $this->models->getDataTable_inventario();
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

    public function searchAllByWhereTwo(){
        $id1         = $this->input->post('id1');
        $field1      = $this->input->post('field1');
        $id2         = $this->input->post('id2');
        $field2      = $this->input->post('field2');
        $query      =  $this->models->getAllByWhereTwo($id1,$field1,$id2,$field2);
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
/*
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
*/
    public function edit(){
        $id    = $this->input->post('id');
        $data = ($this->input->post());
        $data = array_splice($data, 1);
        $this->models->editById($data,$id);
    }

    public function editWhere(){
        $id  = $this->input->post('id_inventario');
        $cod = $this->input->post('cod_inventario');
        $pro = $this->input->post('id_producto');
        $where = array(
            'id_inventario' => $id,
            'cod_inventario'=> $cod,
            'id_producto'   => $pro,
        );
        $data = ($this->input->post());
        $data = array_splice($data, 1);
        $data = array_splice($data, 1);
        $data = array_splice($data, 1);
        $this->models->editByIdWhere($data,$where);

    }

    public function delete(){
        //Eliminar datos de ´sys_inventario_detalle´
        $this->CRUD->delete($this->schema['table'],$this->input->post('cod_inventario'));
        //Eliminar datos de ´sys_inventario´
        $this->CRUD->delete($this->schema['table'],$this->input->post('id_inventario'));
    }

    public function deleteSelect(){
        $ids = $this->input->post('id');
        $this->models->deleteSelect($ids);
    }

    public function sumarPltas(){
        $id = $this->input->post('id');
        $query = $this->models->sumarPaletas($id);
        echo json_encode($query);
    }

    public function sumarTotal(){
        $id = $this->input->post('id');
        $query = $this->models->sumarTotal($id);
        echo json_encode($query);
    }


}
