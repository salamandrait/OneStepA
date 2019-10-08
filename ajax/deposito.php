<?php
require_once "../modelos/Deposito.php";

$deposito=new Deposito();

$iddeposito=isset($_POST["iddeposito"])? limpiarCadena($_POST["iddeposito"]):"";
$cod_deposito=isset($_POST["cod_deposito"])? limpiarCadena($_POST["cod_deposito"]):"";
$desc_deposito=isset($_POST["desc_deposito"])? limpiarCadena($_POST["desc_deposito"]):"";
$responsable=isset($_POST["responsable"])? limpiarCadena($_POST["responsable"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$solocompra=isset($_POST["solocompra"])? limpiarCadena($_POST["solocompra"]):"";
$soloventa=isset($_POST["soloventa"])? limpiarCadena($_POST["soloventa"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($iddeposito)){
			$rspta=$deposito->insertar($cod_deposito,$desc_deposito,$responsable,$direccion,
			$fechareg,$solocompra,$soloventa);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$deposito->editar($iddeposito,$cod_deposito,$desc_deposito,$responsable,$direccion,
			$fechareg,$solocompra,$soloventa);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$deposito->desactivar($iddeposito);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$deposito->activar($iddeposito);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$deposito->eliminar($iddeposito);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$deposito->mostrar($iddeposito);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$deposito->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->iddeposito.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->iddeposito.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->iddeposito.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->iddeposito.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->iddeposito.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->iddeposito.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_deposito.'</h5>',
			"2"=>'<h5 style="padding-left:5px width:250px;">'.$reg->desc_deposito.'</h5>', 
			"3"=>'<h5 style="width:200px; padding-left:5px">'.$reg->responsable.'</h5>',
			"4"=>($reg->solocompra)?'<h5 style="text-align:center;"><span class="label bg-green">Si</span></h5>':'<h5 style="text-align:center;"><span class="label bg-red">No</span></h5>',
			"5"=>($reg->soloventa)?'<h5 style="text-align:center;"><span class="label bg-green">Si</span></h5>':'<h5 style="text-align:center;"><span class="label bg-red">No</span></h5>',        
			"6"=>($reg->estatus)?
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