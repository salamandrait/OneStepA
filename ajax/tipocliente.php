<?php
require_once "../modelos/TipoCliente.php";

$tipocliente=new TipoCliente();

$idtipocliente=isset($_POST["idtipocliente"])? limpiarCadena($_POST["idtipocliente"]):"";
$cod_tipocliente=isset($_POST["cod_tipocliente"])? limpiarCadena($_POST["cod_tipocliente"]):"";
$desc_tipocliente=isset($_POST["desc_tipocliente"])? limpiarCadena($_POST["desc_tipocliente"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idtipocliente)){
			$rspta=$tipocliente->insertar($cod_tipocliente,$desc_tipocliente);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$tipocliente->editar($idtipocliente,$cod_tipocliente,$desc_tipocliente);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$tipocliente->desactivar($idtipocliente);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$tipocliente->activar($idtipocliente);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$tipocliente->eliminar($idtipocliente);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$tipocliente->mostrar($idtipocliente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$tipocliente->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 style="text-align:center; width:120px">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtipocliente.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idtipocliente.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idtipocliente.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'	 	 	
            :
			'<h5 style="text-align:center; width:120px">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtipocliente.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idtipocliente.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idtipocliente.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_tipocliente.'</h5>',
            "2"=>'<h5 style="padding-left:5px">'.$reg->desc_tipocliente.'</h5>',          
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