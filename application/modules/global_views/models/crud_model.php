<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * -------------------------------------------------------------------------------
 * Functions CRUD  - Create, Read, Edit, Disable, Enable and Delete
 * -------------------------------------------------------------------------------
 *
 * CRUD_MODEL version 0.0.1
 *
 * Created by PhpStorm.
 * User: Jasp402
 * Date: 27/12/2016
 * Time: 9:43 AM
 *
 * @category   global_models
 * @author     Jesús Pérez
 * @copyright  2016-12 jasp402@gmail.com
 * @version    0.0.1
 *
 *
 * __getAll             ----> Es un constructor de 'read' pasado el nombre de la entidad a consultar
 * ---------------------------------------------------------------------------------------------------------------
 * create               ----> Registra un nuevo elemento en base de datos
 * create_much          ----> Correr una array e insertar varios elementos
 * ---------------------------------------------------------------------------------------------------------------
 * read                 ----> <<getAll>> lee todos los elementos de una <<tabla>>
 * read_data_table      ----> Realiza un <<select>> <<donde|where>> retorna el valor en formato  (DataTable)
 * read_id              ----> <<getAllByID>> retorna todos los valores del ID pasado
 * read_field_table     ----> Retorna el campo solicitado ejemplo: << db->select('cod_key') >>
 * read_where           ----><<getAllByWhere>> retorna todos los valores de tabla <donde|where> sirve como un filtro
 * ---------------------------------------------------------------------------------------------------------------
 * edit                 ----> Editar un elemento pasado el ID
 * edit_much            ----> Corre (2) array con todos los Id's a editar y otro con los dato a modificar por Id
 * edit_all_where       ----> realiza un <<Upload>> de todos los elementos de la tabla <<donde|where>>
 * edit_where           ----> editar un elemento pasado un ID <<donde|where>>
 * ---------------------------------------------------------------------------------------------------------------
 * delete               ----> Elimina el elemento pasado el ID
 * delete_much          ----> Corre un array con todos los Id's a eliminar de la tabla
 * delete_where         ----> Eliminar un elemento pasado el ID <<donde|where>>
 * ----------------------------------------------------------------------------------------------------------
 * disable              ----> Cambia de 'estado' (i|inactivo)  a un elemento pasado el ID
 * disable_much         ----> Corre un array con todos los Id's que se van ha desabilitar (disable)
 * disable_all_where    ----> desabilita todos los elementos de la tabla <<donde|were>>
 * ---------------------------------------------------------------------------------------------------------------
 * enable               ----> Habilita un elemento que fue desabilitado <<disable>>
 * enable_much          ----> El proceso inverso de <<disable_much>>
 * enable_all_where     ----> El proceso inverso de <<disable_all_much>>
 *
 **/
class Crud_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ---------------------------------------------------------------------------------------------------------------
     * __getAll
     * ---------------------------------------------------------------------------------------------------------------
     * Es un constructor de 'read' pasado el nombre de la entidad sin el prefix 'sys_' o la tabla a consultar
     * admite multipes condicionales 'WHERE';
     * en caso de ERROR retorna alerta en el view mediante <<detail_message()>>
     *
     * @param   string $entity
     * @param   string $where Array();
     *
     * @return    string
     **/
    public function __getAll($entity, $where='')
    {
        if(substr_count($entity, 'sys_')>0){
            $table = $entity;
        }else {
            $table = 'sys_' . $entity;
        }

        $this->db->select('*');
        $this->db->from($table);
        switch ($where){
            case '':
                break;
            case count($where)==1:
                $this->db->where(key($where), $where[key($where)]);
                break;
            case count($where)>1:
                for($i=0; $i<count($where); $i++)
                {
                    $this->db->where(key($where[$i]), $where[$i][key($where[$i])]);
                }
        }
        $query = $this->db->get();
        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();
        if ($items['num_err'] == 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        }else{
            $items['num_err'] = 'null';
            detail_message($items, 'ERROR');
            return FALSE;
        }
    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * create
     * ---------------------------------------------------------------------------------------------------------------
     * Inserta un elementos en la base de datos << $this->db->insert() >>
     * retorna mensaje :: [TRUE]->registro exitoso | [FALSE]->_error_number & _error_message
     *
     * @param   string $table
     * @param   array $data
     *
     * @return    void
     **/
    public function create($table, $data)
    {

        $items = array();
        $this->db->insert($table, $data);
        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();
        detail_message($items, 'CREATE');

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * create_much
     * ---------------------------------------------------------------------------------------------------------------
     * Correr una array e insertar varios elementos
     *
     * @param   string $table
     * @param   array $array
     *
     *
     * @return    void
     **/
    public function create_much($table, $array)
    {

        $items = array();
        for ($i = 0, $c = count($array); $i < $c; $i++) {
            $this->db->insert($table, $array[$i]);
            $items['num_err'] = $this->db->_error_number();
            $items['mens_err'] = $this->db->_error_message();
        }
        detail_message($items, 'CREATE');

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * read
     * ---------------------------------------------------------------------------------------------------------------
     * <<getAll>> lee y retorna todos [*] los elementos de una <<tabla>>
     *
     * @param   string $table
     *
     * @return  string
     **/
    public function read($table)
    {

        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $items = array();
            foreach ($query->result() as $key) {
                $items[] = $key;
            }
            return $items;
        } else {
            $items['num_err'] = 'null';
            detail_message($items, 'EMPTY');
            return FALSE;
        }

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * read_data_table
     * ---------------------------------------------------------------------------------------------------------------
     * Realiza un << $this->db->select() >> con un condicional << $this->db->where() >>
     * retorna el valor en formato << DataTable >> JSON para consultas ajax
     *
     * @param   string $table
     * @param   string $where
     *
     * @return  string
     **/
    public function read_data_table($table, $where='')
    {

        $this->db->select('*');
        $this->db->from($table);
        if(!empty($where)){
            $this->db->where(key($where), $where[key($where)]);
        }
        $query = $this->db->get();
        $result = array(
            "draw" => 1,
            "recordsTotal" => $query->num_rows(),
            "recordsFiltered" => $query->num_rows(),
            'data' => $query->result());
        echo json_encode($result);
        return json_encode($result);

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * read_id
     * ---------------------------------------------------------------------------------------------------------------
     * <<getAllByID>> retorna todos los valores del ID pasado
     *
     * @param   string $table
     * @param   array $whereId
     * @param   string $method
     *
     * @return  string
     **/
    public function read_id($table, $whereId, $method = '')
    {

        $items = array();
        $result = array();
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where(key($whereId), $whereId[key($whereId)]);
        $query = $this->db->get();

        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();

        foreach ($query->result() as $key => $value) {
            $result[$key] = $value;
        }

        switch ($method) {
            case 'ajax':
                if ($items['num_err'] == 0) {
                    $data = array('success' => true, 'result' => $result);
                    echo json_encode($data);
                } else {
                    $data = array('success' => false);
                    echo json_encode($data);
                }
                break;
        }

        if ($items['num_err'] == 0) {
            return $result;
        } else {
            return FALSE;
        }

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * read_where
     * ---------------------------------------------------------------------------------------------------------------
     * <<getAllByWhere>> retorna todos los valores de tabla <donde|where> sirve como un filtro
     *
     * @param   string $table
     * @param   array $where
     * @param   string $method
     *
     * @return  string
     **/
    public function read_where($table, $where, $method = '')
    {
        $items = array();
        $result = array();

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();
        foreach ($query->result() as $key => $value) {
            $result[][$key] = $value;
        }
        switch ($method) {
            case 'ajax':
                if ($result) {
                    $data = array('success' => true, 'result' => $result);
                    echo json_encode($data);
                } else {
                    $data = array('success' => false);
                    echo json_encode($data);
                }
                break;
        }
        if ($items['num_err'] == 0) {
            return $result;
        } else {
            return FALSE;
        }
    }

    /**
     * ---------------------------------------------------------------------------------------------------------------
     * read_field_table
     * ---------------------------------------------------------------------------------------------------------------
     * Retorna el campo solicitado ejemplo: << db->select('cod_key') >>
     *
     * @param   string $table
     * @param   string $field
     *
     * @return  string
     **/
    public function read_field_table($field, $table, $where='',$method='')
    {

        $items = array();
        $result = array();

        $this->db->select($field);
        $this->db->from($table);
        if(is_array($where)){
            $this->db->where($where);
        }
        $query = $this->db->get();
        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();
        foreach ($query->result() as $key => $value) {
            $result[][$key] = $value;
        }
        switch ($method) {
            case 'ajax':
                if ($result) {
                    $data = array('success' => true, 'result' => $result);
                    echo json_encode($data);
                } else {
                    $data = array('success' => false);
                    echo json_encode($data);
                }
                break;
        }
        if ($items['num_err'] == 0) {
            return $result;
        } else {
            return FALSE;
        }

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * edit
     * ---------------------------------------------------------------------------------------------------------------
     * Editar un elemento pasado el ID
     *
     * @param   string $table
     * @param   array $data
     * @param   array $whereId
     *
     * @return  void
     **/
    public function edit($table, $data, $whereId)
    {

        $this->db->where(key($whereId), $whereId[key($whereId)]);
        $this->db->update($table, $data);
        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();
        detail_message($items, 'UPDATE');

    }

    public function edit_much()
    {

    }

    public function edit_all_where()
    {

    }

    public function edit_where()
    {

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * delete
     * ---------------------------------------------------------------------------------------------------------------
     * Elimina el elemento pasado el ID
     *
     * @param   string $table
     * @param   array $whereId
     *
     * @return  void
     **/
    public function delete($table, $whereId)
    {

        $this->db->where(key($whereId), $whereId[key($whereId)]);
        $this->db->delete($table);
        $items['num_err'] = $this->db->_error_number();
        $items['mens_err'] = $this->db->_error_message();
        detail_message($items, 'DELETE');

    }
    /**
     * ---------------------------------------------------------------------------------------------------------------
     * delete_much
     * ---------------------------------------------------------------------------------------------------------------
     * Elimina el elemento pasado el ID
     *
     * @param   string $table
     * @param   array $arrayId
     * @param   string $fieldKey
     *
     * @return  void
     **/
    public function delete_much($table, $arrayId, $fieldKey)
    {
        $items = array();
        for ($i=0; $i<count($arrayId); $i++){
            $this->db->where($fieldKey, $arrayId[$i]);
            $this->db->delete($table);
            $items['num_err'] = $this->db->_error_number();
            $items['mens_err'] = $this->db->_error_message();
        }
        detail_message($items, 'DELETE');

    }

    public function delete_where()
    {

    }

    public function disable()
    {

    }

    public function disable_much()
    {

    }

    public function disable_all_where()
    {

    }

    public function enable()
    {

    }

    public function enable_much()
    {

    }

    public function enable_all_where()
    {

    }


}
//