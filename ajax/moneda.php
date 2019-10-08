<?php
require_once "../modelos/Moneda.php";

$moneda=new Moneda();

$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_moneda=isset($_POST["cod_moneda"])? limpiarCadena($_POST["cod_moneda"]):"";
$desc_moneda=isset($_POST["desc_moneda"])? limpiarCadena($_POST["desc_moneda"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idmoneda)){
			$rspta=$moneda->insertar($cod_moneda,$desc_moneda);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$moneda->editar($idmoneda,$cod_moneda,$desc_moneda);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$moneda->desactivar($idmoneda);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$moneda->activar($idmoneda);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$moneda->eliminar($idmoneda);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$moneda->mostrar($idmoneda);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$moneda->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idmoneda.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idmoneda.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmoneda.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'	 	 	
            :
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idmoneda.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idmoneda.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idmoneda.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_moneda.'</h5>',
            "2"=>'<h5 style="padding-left:5px">'.$reg->desc_moneda.'</h5>',          
			"3"=>($reg->estatus)?
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