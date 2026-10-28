<?php 

include('dompdf/autoload.inc.php');
use Dompdf\Dompdf;

$obj=new Dompdf();

//$data="<h1>Hello DOMPDF Tutorial</h1>";

$data=file_get_contents('test.php');

$obj->loadHTML($data);

$obj->render();

$obj->stream('sample.pdf',array('Attachment'=>0));

file_put_contents('sample.pdf',$obj->output());

?>