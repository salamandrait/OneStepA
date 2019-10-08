<?php
require_once "../modelos/Operacion.php";

$operacion=new Operacion();

$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$cod_operacion=isset($_POST["cod_operacion"])? limpiarCadena($_POST["cod_operacion"]):"";
$desc_operacion=isset($_POST["desc_operacion"])? limpiarCadena($_POST["desc_operacion"]):"";
$escompra=isset($_POST["escompra"])? limpiarCadena($_POST["escompra"]):"";
$esventa=isset($_POST["esventa"])? limpiarCadena($_POST["esventa"]):"";
$esinventario=isset($_POST["esinventario"])? limpiarCadena($_POST["esinventario"]):"";
$esconfig=isset($_POST["esconfig"])? limpiarCadena($_POST["esconfig"]):"";
$esbanco=isset($_POST["esbanco"])? limpiarCadena($_POST["esbanco"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idoperacion)){
			$rspta=$operacion->insertar($cod_operacion,$desc_operacion,$escompra,
			$esventa,$esinventario,$esconfig,$esbanco);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$operacion->editar($idoperacion,$cod_operacion,$desc_operacion,$escompra,
			$esventa,$esinventario,$esconfig,$esbanco);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$operacion->desactivar($idoperacion);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$operacion->activar($idoperacion);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$operacion->eliminar($idoperacion);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$operacion->mostrar($idoperacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$operacion->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idoperacion.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idoperacion.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idoperacion.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idoperacion.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idoperacion.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idoperacion.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_operacion.'</h5>',
			"2"=>'<h5 style="padding-left:5px; width:300px;">'.$reg->desc_operacion.'</h5>',
			"3"=>($reg->esinventario)?
			'<h5 style="text-align:center; width:120px"><span class="label bg-green">SI</h5>':
			'<h5 style="text-align:center; width:120px"><span class="label bg-red">NO</h5>', 
			"4"=>($reg->escompra)?
			'<h5 style="text-align:center; width:120px"><span class="label bg-green">SI</h5>':
			'<h5 style="text-align:center; width:120px"><span class="label bg-red">NO</h5>',
			"5"=>($reg->esventa)?
			'<h5 style="text-align:center; width:120px"><span class="label bg-green">SI</h5>':
			'<h5 style="text-align:center; width:120px"><span class="label bg-red">NO</h5>',
			"6"=>($reg->esbanco)?
			'<h5 style="text-align:center; width:120px"><span class="label bg-green">SI</h5>':
			'<h5 style="text-align:center; width:120px"><span class="label bg-red">NO</h5>',          
			"7"=>($reg->esconfig)?
			'<h5 style="text-align:center; width:120px"><span class="label bg-green">SI</h5>':
			'<h5 style="text-align:center; width:120px"><span class="label bg-red">NO</h5>',
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