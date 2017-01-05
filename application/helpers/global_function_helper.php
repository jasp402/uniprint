<?php 
	function cambiaf_a_normal($fecha){ 
		preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha); 
		$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
		return $lafecha; 
	}

	function tiene_logeo() {
	    $CI =& get_instance();
	    $user = $CI->session->userdata('codigo_usuario');
	    // $user = $this->session->userdata('codigo_usuario');
	    if ($user == "") { return false; } else { return true; }
	}

	function estado_contrato(){
		$CI =& get_instance();
	    $user = $CI->session->userdata('estado_contrato');
	    if ($user == 0) {
	    	return true;  
	    }else { 
	    	return true; }
	}
	function EliminarAvatar($imagenName){
	    $path = $_SERVER['DOCUMENT_ROOT'].'/hmvci_TUTO/images/upload/avatar/';
	    $file = $path.$imagenName;
	    unlink($file);
	}

	function url_enco($encry){
		$encryPLUS = str_replace(array('+', '/', '='), array('-', '_', '~'), $encry);
		return $encryPLUS;
	}
	function url_deco($encry){
		$encryPLUS = str_replace(array('-', '_', '~'), array('+', '/', '='), $encry);
		return $encryPLUS;
	}
	function generarCodigo($longitud) {
		srand ((double) microtime( )*1000000);
		$fecha_hoy = date('dHmiys');
		$key = '';
		$pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$max = strlen($pattern)-1;
		for($i=0;$i < $longitud;$i++){
			$key .= $pattern{mt_rand(0,$max)};
		}
		 return $key.$fecha_hoy;
	}

    function detail_message($query,$operacion){
        switch ($query['num_err']) {
            case '0':
                switch ($operacion){
                    case 'CREATE':
                        $msg = '<span class=\'bigger-110 green\'>registro exitoso</span>';
                        break;
                    case 'UPDATE':
                        $msg = '<span class=\'bigger-110 green\'>actualización exitosa</span>';
                        break;
                    case 'DELETE':
                        $msg = '<span class=\'bigger-110 red\'>Registro eliminado</span>';
                        break;
                    case 'ARCHIVE':
                        $msg = '<span class=\'bigger-110 blue\'>Registro pasado a historico</span>';
                        break;
                }
                $data = array('success' => $msg, 'times'=>2500, 'closes'=>false);
                echo json_encode($data);
                break;

            case '1451':
                //$text1 = strstr($query['mens_err'], '(',true);
                $text2 =strpos($query['mens_err'], 'sys');
                $text3 =$rest = substr($query['mens_err'], $text2);
                $text4 = str_replace("_", " ",$text3);
                $text5 = str_replace("sys", " ",$text4);
                $text6 = strstr($text5, '`',true);
                $msg = '<span class=\'bigger-110 red\'>¡Error! <br> datos RELACIONADOS en <b> '. $text6 .' </b></span>';
                $data = array('success' => $msg, 'times'=>0, 'close'=>'true');
                echo json_encode($data);
                break;

            case '1062':
                //$text1 = strstr($query['mens_err'], '(',true);
                $text2 =strpos($query['mens_err'], 'sys');
                $text3 =$rest = substr($query['mens_err'], $text2);
                $text4 = str_replace("_", " ",$text3);
                $text5 = str_replace("sys", " ",$text4);
                $text6 = strstr($text5, '`',true);
                $msg = '<span class=\'bigger-110 red\'>¡Error! <br> Entrada duplicada en <b> '. $text6 .' </b></span><hr><span class=\'bigger-110 red\'><h6>'. $query['num_err'].' - '.$query['mens_err']  .'</h6></span>';
                $data = array('success' => $msg, 'times'=>0, 'close'=>'true');
                echo json_encode($data);
                break;

            case '1265':
                //$text1 = strstr($query['mens_err'], '(',true);
                $text2 =strpos($query['mens_err'], 'sys');
                $text3 =$rest = substr($query['mens_err'], $text2);
                $text4 = str_replace("_", " ",$text3);
                $text5 = str_replace("sys", " ",$text4);
                $text6 = strstr($text5, '`',true);
                $msg = '<span class=\'bigger-110 red\'>¡Error! <br> Datos truncados en <b> '. $text6 .' </b></span><hr><span class=\'bigger-110 red\'><h6>'. $query['num_err'].' - '.$query['mens_err']  .'</h6></span>';
                $data = array('success' => $msg, 'times'=>0, 'close'=>'true');
                echo json_encode($data);
                break;

            case 'null':
                switch ($operacion){
                    case 'ERROR':
                        $msg =  '<i class=\'red ace-icon fa fa-warning\'></i> '.
                                '<span class=\'bigger-110 red\'> Lo sentimo! pero algo ha salido mal'.
                                '<br><small><cite>'.$query['mens_err'].'</cite></small> </span>';
                        break;
                    case 'EMPTY':
                        $msg =  '<i class=\'ace-icon fa fa-random\'></i>'.
                                '<span class=\'bigger-110 orange\'>No se encontraron resultados</span>';
                        break;
                }
                echo '<script>message_box("'.$msg.'",0,true);</script>';


                break;
            default:
                $msg = '<span class=\'bigger-110 red\'><b>Error en MVC:</b> Consulte su administrador de sistema. <h6><b>'. $query['num_err'].'</b> - '.$query['mens_err']  .'</h6></span>';
                $data = array('success' => $msg, 'times'=>0, 'closes'=>true);
                echo json_encode($data);
                break;
        }
    }


    //ToDo - Revisar  esto con '/'
function invertDate($date,$elm='-') {  //Ej: invertDate('2011-07-11');
    if($date == '') return NULL;
    $date2 = explode($elm, $date);
    return $date2[2].$elm.$date2[1].$elm.$date2[0];
}

////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////
//ToDO - Probar este codigo para cambiar el codigo
function cambiaf_a_mysql($fecha){
    preg_match( "/([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})/", $fecha, $mifecha);
   	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
   	return $lafecha;
}
function pdf_create($html, $filename='', $stream=TRUE)
{

    require_once("dompdf/dompdf_config.inc.php");
    // $this->load->helper('file');
    // require_once(APPPATH.'third_party/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    if($html==''){
        $dompdf->load_html(ob_get_clean());
    }else{
        $dompdf->load_html($html);
    }

    $dompdf->set_paper("a4", "portrait" );
    $dompdf->render();
    // $dompdf->stream($filename . ".pdf");
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        // $dompdf->output();
        $dompdf->stream($filename.".pdf",array('Attachment'=>0));
    }
}
