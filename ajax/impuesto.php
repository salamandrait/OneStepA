<?php
require_once "../modelos/Impuesto.php";

$impuesto=new Impuesto();

$idimpuesto=isset($_POST["idimpuesto"])? limpiarCadena($_POST["idimpuesto"]):"";
$cod_impuesto=isset($_POST["cod_impuesto"])? limpiarCadena($_POST["cod_impuesto"]):"";
$desc_impuesto=isset($_POST["desc_impuesto"])? limpiarCadena($_POST["desc_impuesto"]):"";
$tasa=isset($_POST["tasa"])? limpiarCadena($_POST["tasa"]):"";


switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idimpuesto)){
			$rspta=$impuesto->insertar($cod_impuesto,$desc_impuesto,$tasa);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$impuesto->editar($idimpuesto,$cod_impuesto,$desc_impuesto,$tasa);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$impuesto->desactivar($idimpuesto);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$impuesto->activar($idimpuesto);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$impuesto->eliminar($idimpuesto);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$impuesto->mostrar($idimpuesto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$impuesto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idimpuesto.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idimpuesto.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idimpuesto.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idimpuesto.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idimpuesto.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idimpuesto.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_impuesto.'</h5>',
			"2"=>'<h5 style="padding-left:5px">'.$reg->desc_impuesto.'</h5>',
			"3"=>'<h5 style="padding-left:5px; text-align:center;">'.$reg->tasa.'</h5>',    
			"4"=>($reg->estatus)?
			'<h5 style="text-align:center; width:100px">
			<span class="label bg-green">Activado':
			'<span class="label bg-red">Desactivado
			</h5>'
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