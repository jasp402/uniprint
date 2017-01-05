<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    // $this->load->helper('file');
	// require_once(APPPATH.'third_party/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();

    $dompdf->set_base_path(APPPATH.'assets/css/bootstrap.css');
    $dompdf->set_base_path(APPPATH.'assets/css/font-awesome.css');
    $dompdf->set_base_path(APPPATH.'assets/css/ace-fonts.css');
    $dompdf->load_html(ob_get_clean());
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
?>