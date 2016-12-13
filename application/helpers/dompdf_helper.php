<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    // $this->load->helper('file');
	// require_once(APPPATH.'third_party/dompdf/dompdf_config.inc.php');
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
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