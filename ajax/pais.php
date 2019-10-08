<?php
require_once "../modelos/Pais.php";

$pais=new Pais();

$idpais=isset($_POST["idpais"])? limpiarCadena($_POST["idpais"]):"";
$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_pais=isset($_POST["cod_pais"])? limpiarCadena($_POST["cod_pais"]):"";
$desc_pais=isset($_POST["desc_pais"])? limpiarCadena($_POST["desc_pais"]):"";


switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idpais)){
			$rspta=$pais->insertar($idmoneda,$cod_pais,$desc_pais,$idmoneda);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$pais->editar($idpais,$idmoneda,$cod_pais,$desc_pais,$idmoneda);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$pais->desactivar($idpais);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$pais->activar($idpais);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$pais->eliminar($idpais);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$pais->mostrar($idpais);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$pais->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>
			'<h5 small style="text-align:center; whidth:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpais.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idpais.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idpais.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; whidth:100px">'.$reg->cod_pais.'</h5>',
			"2"=>'<h5 style="padding-left:5px">'.$reg->desc_pais.'</h5>',
			"3"=>'<h5 style="padding-left:5px; width:180px">'.$reg->desc_moneda.'</h5>'
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