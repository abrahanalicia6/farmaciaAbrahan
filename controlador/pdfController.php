<?php
require_once ('../vendor/autoload.php');
require_once('../modelo/pdf.php');
$id_venta = $_POST['id'];
$html = getHtml($id_venta);
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output("../PDF/pdf-".$id_venta.".pdf","F");
