<?php
require_once "../modelos/Caja.php";

$caja=new Caja();

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
$cod_caja=isset($_POST["cod_caja"])? limpiarCadena($_POST["cod_caja"]):"";
$desc_caja=isset($_POST["desc_caja"])? limpiarCadena($_POST["desc_caja"]):"";
$saldoefectivo=isset($_POST["saldoefectivo"])? limpiarCadena($_POST["saldoefectivo"]):"";
$saldodocumento=isset($_POST["saldodocumento"])? limpiarCadena($_POST["saldodocumento"]):"";
$saldototal=isset($_POST["saldototal"])? limpiarCadena($_POST["saldototal"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idcaja)){
			$rspta=$caja->insertar($idmoneda,$cod_caja,$desc_caja,$fechareg);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$caja->editar($idcaja,$idmoneda,$cod_caja,$desc_caja,$fechareg);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$caja->desactivar($idcaja);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$caja->activar($idcaja);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$caja->eliminar($idcaja);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$caja->mostrar($idcaja);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$caja->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcaja.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idcaja.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcaja.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcaja.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcaja.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcaja.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px" class="hmin">'.$reg->cod_caja.'</h5>',
			"2"=>'<h5 style="padding-left:5px" class="hmin">'.$reg->desc_caja.'</h5>', 
			"3"=>'<h5 style="width:70px; text-align:center;">'.$reg->cod_moneda.'</h5>',
			"4"=>($reg->saldototal==null)?
			'<h5 style="width:120px; text-align:right;"><span class="numberf" >0.00</span></h5>':
			'<h5 style="width:120px; text-align:right;"><span class="numberf" >'.$reg->saldototal.'</span></h5>',
			"5"=>($reg->estatus)?
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