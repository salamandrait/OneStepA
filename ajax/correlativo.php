<?php
require_once "../modelos/Correlativo.php";

$correlativo=new Correlativo();

$idcorrelativo=isset($_POST["idcorrelativo"])? limpiarCadena($_POST["idcorrelativo"]):"";
$desc_correlativo=isset($_POST["desc_correlativo"])? limpiarCadena($_POST["desc_correlativo"]):"";
$grupo=isset($_POST["grupo"])? limpiarCadena($_POST["grupo"]):"";
$tabla=isset($_POST["tabla"])? limpiarCadena($_POST["tabla"]):"";
$cadena=isset($_POST["cadena"])? limpiarCadena($_POST["cadena"]):"";
$precadena=isset($_POST["precadena"])? limpiarCadena($_POST["precadena"]):"";
$cod_num=isset($_POST["cod_num"])? limpiarCadena($_POST["cod_num"]):"";
$largo=isset($_POST["largo"])? limpiarCadena($_POST["largo"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idcorrelativo)){
			$rspta=$correlativo->insertar($desc_correlativo,$grupo,$tabla,$precadena,$cadena,$cod_num,$largo);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$correlativo->editar($idcorrelativo,$precadena,$cadena,$cod_num,$largo);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$correlativo->desactivar($idcorrelativo);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$correlativo->activar($idcorrelativo);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$correlativo->eliminar($idcorrelativo);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$correlativo->mostrar($idcorrelativo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$correlativo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcorrelativo.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idcorrelativo.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcorrelativo.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcorrelativo.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcorrelativo.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcorrelativo.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
			,
			"1"=>'<h5 style="width:100px; padding-left:5px">'.$reg->grupo.'</h5>',
			"2"=>'<h5 style="padding-left:5px">'.$reg->desc_correlativo.'</h5>',
			"3"=>'<h5 style="text-align:center; width:100px">'.$reg->tabla.'</h5>',          
			"4"=>'<h5 style="text-align:center; width:80px">'.$reg->precadena.'</h5>',
			"5"=>'<h5 style="text-align:center; width:80px">'.$reg->cadena.'</h5>',
			"6"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_num.'</h5>',
			"7"=>'<h5 style="text-align:center; width:50px">'.$reg->largo.'</h5>',
			"8"=>($reg->estatus)?
			'<h5 style="text-align:center; width:100px"><span class="label bg-green">Activado</h5>':
			'<h5 style="text-align:center; width:100px"><span class="label bg-red">Desactivado</h5>'
 		);
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