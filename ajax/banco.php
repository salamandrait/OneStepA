<?php
require_once "../modelos/Banco.php";

$banco=new Banco();

$idbanco=isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_banco=isset($_POST["cod_banco"])? limpiarCadena($_POST["cod_banco"]):"";
$desc_banco=isset($_POST["desc_banco"])? limpiarCadena($_POST["desc_banco"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$plazo1=isset($_POST["plazo1"])? limpiarCadena($_POST["plazo1"]):"";
$plazo2=isset($_POST["plazo2"])? limpiarCadena($_POST["plazo2"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idbanco)){
			$rspta=$banco->insertar($idmoneda, $cod_banco,$desc_banco,$telefono,$plazo1,$plazo2);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$banco->editar($idbanco,$idmoneda, $cod_banco,$desc_banco,$telefono,$plazo1,$plazo2);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$banco->desactivar($idbanco);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$banco->activar($idbanco);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$banco->eliminar($idbanco);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$banco->mostrar($idbanco);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$banco->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idbanco.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idbanco.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idbanco.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idbanco.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idbanco.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idbanco.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_banco.'</h5>',
			"2"=>'<h5 style="padding-left:5px">'.$reg->desc_banco.'</h5>',
			"3"=>'<h5 style="width:100px; text-align:center;">'.$reg->desc_moneda.'</h5>',         
			"4"=>($reg->estatus)?
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

	case "selectMoneda":
	require_once "../modelos/Moneda.php";
	$moneda = new Moneda();

	$rspta = $moneda->select();

	while ($reg = $rspta->fetch_object()){
		echo '<option value='.$reg->idmoneda.'>'.$reg->cod_moneda.'-'.$reg->desc_moneda.'</option>';
	}
	break;
}

?>