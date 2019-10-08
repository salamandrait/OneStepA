<?php
require_once "../modelos/TipoProveedor.php";

$tipoproveedor=new TipoProveedor();

$idtipoproveedor=isset($_POST["idtipoproveedor"])? limpiarCadena($_POST["idtipoproveedor"]):"";
$cod_tipoproveedor=isset($_POST["cod_tipoproveedor"])? limpiarCadena($_POST["cod_tipoproveedor"]):"";
$desc_tipoproveedor=isset($_POST["desc_tipoproveedor"])? limpiarCadena($_POST["desc_tipoproveedor"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idtipoproveedor)){
			$rspta=$tipoproveedor->insertar($cod_tipoproveedor,$desc_tipoproveedor);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$tipoproveedor->editar($idtipoproveedor,$cod_tipoproveedor,$desc_tipoproveedor);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$tipoproveedor->desactivar($idtipoproveedor);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$tipoproveedor->activar($idtipoproveedor);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$tipoproveedor->eliminar($idtipoproveedor);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$tipoproveedor->mostrar($idtipoproveedor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$tipoproveedor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 small style="text-align:center; width:120px">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtipoproveedor.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idtipoproveedor.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idtipoproveedor.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idtipoproveedor.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idtipoproveedor.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idtipoproveedor.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_tipoproveedor.'</h5>',
            "2"=>'<h5 style="padding-left:5px">'.$reg->desc_tipoproveedor.'</h5>',          
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