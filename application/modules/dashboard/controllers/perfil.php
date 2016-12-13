<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Perfil extends MX_Controller {

	private $idus;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('perfil_model');
		$this->idus = $this->encrypt->decode($this->session->userdata('codigo_usuario'));
	}

	public function index(){
		if (tiene_logeo()) {
      if (!estado_contrato()) {
          $this->load->view('global_views/contrato_finalizado');
      }else{
  			$id = $this->session->userdata('codigo_usuario');
  			$query = $this->perfil_model->getAll_byID($this->encrypt->decode($id));
  			foreach ($query as $row) {
  				$data = array('perfil' => $row);
  			}
  			$this->load->view('perfil',$data);
      }
		}else{
			redirect(base_url());
		}
	}

	public function guardar(){
		if (!empty($_FILES['file']['name'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$image_name = $this->idus.md5($_FILES['file']['name']);
			$image_db = $this->idus.md5($_FILES['file']['name']).".".$ext;
        	$result = $this->cargar_avatar($image_name);
        	if($result['result'] == 'success'){
            $foto_actual = $this->input->post('foto_actual');
            if ($foto_actual == "") {
            }else{
              EliminarAvatar($foto_actual);
            }

        		$data = array('nombre' => $this->input->post('nombre'), 
   							'telefono' => $this->input->post('telefono'), 
   							'direccion' => $this->input->post('direccion'),
   							'ruta_foto' => $image_db);
        		$query = $this->perfil_model->update_byID($data,$this->idus);
        		if ($query) {
        			$tipo_msj = "success";
        			$icono = "check";
        			$msj = "Perfil Guardado";
        			$jsonData = array('success' => true, 
        								'mensaje' => $msj, 
        								'icono' => $icono, 
        								'tipo_msj' => $tipo_msj);
        			echo json_encode($jsonData);
        		}else{
        			$tipo_msj = "warning";
        			$icono = "exclamation-triangle";
        			$msj = "Error de Base de Datos, vuelve a intentarlo...";
        			$jsonData = array('success' => false, 
        								'mensaje' => $msj, 
        								'icono' => $icono, 
        								'tipo_msj' => $tipo_msj);
        			echo json_encode($jsonData);
        		}
        	}else{
        		$tipo_msj = "danger";
        			$icono = "times";
        			$jsonData = array('success' => false, 
        								'mensaje' => $result['result'], 
        								'icono' => $icono, 
        								'tipo_msj' => $tipo_msj);
        			echo json_encode($jsonData);
        	}
   		}else{
   			$data = array('nombre' => $this->input->post('nombre'), 
   							'telefono' => $this->input->post('telefono'), 
   							'direccion' => $this->input->post('direccion'));
        	$query = $this->perfil_model->update_byID($data,$this->idus);
   			if ($query) {
   				$tipo_msj = "success";
   				$icono = "check";
   				$msj = "Perfil Guardado";
   				$jsonData = array('success' => true, 
   					'mensaje' => $msj, 
   					'icono' => $icono, 
   					'tipo_msj' => $tipo_msj);
   				echo json_encode($jsonData);
        	}
   		}
	}

	public function cargar_avatar($image_name){
			$config['upload_path'] = './images/upload/avatar/';
			$config["allowed_types"] ="*";
			$config['file_name'] = $image_name;
			$config['max_size'] = '500';
			$config['overwrite'] = TRUE;
			$config['remove_spaces']  = TRUE;
			$config['max_width'] = '800';
			$config['max_height'] = '600';
			$config['file_size'] = '22.2';
			$this->load->library('upload', $config); 
			$this->upload->initialize($config); 
			if(!$this->upload->do_upload('file')){
	           	$result['result'] = 'Error al subir la imagen, por favor verifique...';
	            return $result;
	        }else{
	            $this->upload->data('file'); 
	            $result['result'] = 'success';
	            return $result;
	        }
	}

  public function guardar_password(){
    $pass_actual = $this->input->post('pass_ac');
    $nuevo_passw = $this->input->post('n_pass');

    // $data = array('clave' => $nuevo_passw);

    $query = $this->perfil_model->update_byID_pass($this->idus,$pass_actual,$nuevo_passw);

    if ($query) {
      $jsonData = array('success' => true, 
                        'mensaje' => 'Clave cambiada...!', 
                        'icono' => 'check', 
                        'tipo_msj' => 'success');
      echo json_encode($jsonData);
    }else{
      $jsonData = array('success' => false, 
                        'mensaje' => 'El password actual es incorrecto, verifique...', 
                        'icono' => 'times', 
                        'tipo_msj' => 'danger');
      echo json_encode($jsonData);
    }

  }

}

/* End of file perfil.php */
/* Location: ./application/modules/dashboard/views/perfil.php */