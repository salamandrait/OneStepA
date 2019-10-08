<?php
require_once "../modelos/Cuenta.php";

$cuenta=new Cuenta();

$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
$idbanco=isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
$cod_cuenta=isset($_POST["cod_cuenta"])? limpiarCadena($_POST["cod_cuenta"]):"";
$desc_cuenta=isset($_POST["desc_cuenta"])? limpiarCadena($_POST["desc_cuenta"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$numcuenta=isset($_POST["numcuenta"])? limpiarCadena($_POST["numcuenta"]):"";
$agencia=isset($_POST["agencia"])? limpiarCadena($_POST["agencia"]):"";
$ejecutivo=isset($_POST["ejecutivo"])? limpiarCadena($_POST["ejecutivo"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$saldod=isset($_POST["saldod"])? limpiarCadena($_POST["saldod"]):"";
$saldoh=isset($_POST["saldoh"])? limpiarCadena($_POST["saldoh"]):"";
$saldot=isset($_POST["saldot"])? limpiarCadena($_POST["saldot"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";;

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idcuenta)){
			$rspta=$cuenta->insertar($idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,
			$direccion,$telefono,$email,$saldod,$saldoh,$saldot,$fechareg);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$cuenta->editar($idcuenta,$idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,
			$direccion,$telefono,$email,$saldod,$saldoh,$saldot,$fechareg);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$cuenta->desactivar($idcuenta);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$cuenta->activar($idcuenta);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$cuenta->eliminar($idcuenta);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$cuenta->mostrar($idcuenta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cuenta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcuenta.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idcuenta.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcuenta.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcuenta.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcuenta.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcuenta.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_cuenta.'</h5>',
			"2"=>'<h5 style="width:350px; padding-left:5px">'.$reg->desc_cuenta.'</h5>',
			"3"=>'<h5 style="width:200px; text-align:center;">'.$reg->numcuenta.'</h5>',
			"4"=>'<h5 style="width:100px; text-align:center;">'.$reg->cod_banco.'</h5>',
			"5"=>'<h5 style="text-align:right; width:130px;"><span class="numberf">'.$reg->saldot.'</span></h5>',      
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

	case "listarBanco":
		require_once "../modelos/Banco.php";
		$banco = new Banco();
		$rspta=$banco->select();

		//Vamos a declarar un array
		$data= Array();

			while ($reg=$rspta->fetch_object()){
				$data[]=array(
					"0"=>'<button class="btn btn-warning btn-xs" onclick="agregarBanco('.$reg->idbanco.',\''.$reg->cod_banco.'\',
					\''.$reg->desc_banco.'\',\''.$reg->cod_moneda.'\')" style="text-align:center; width:20px;">
					<span class="fa fa-plus" style="text-align:center;"></span></button>',
					"1"=>'<h5>'.$reg->cod_banco.'</h5>',
					"2"=>'<h5 style="width:400px; padding-left:5px;">'.$reg->desc_banco.'</span></h5>',
					"3"=>'<h5 style="text-align:center; width:80px;">'.$reg->cod_moneda.'</h5>'
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