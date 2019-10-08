<?php 
require_once "../modelos/Acceso.php";

$acceso=new Acceso();

switch ($_GET["op"]){
	
	case 'listar':
		$rspta=$acceso->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array("0"=>$reg->desc_acceso,"1"=>$reg->modulo);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>