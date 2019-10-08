<?php
require_once "../modelos/Categoria.php";

$categoria=new Categoria();

$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$cod_categoria=isset($_POST["cod_categoria"])? limpiarCadena($_POST["cod_categoria"]):"";
$desc_categoria=isset($_POST["desc_categoria"])? limpiarCadena($_POST["desc_categoria"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idcategoria)){
			$rspta=$categoria->insertar($cod_categoria,$desc_categoria);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$categoria->editar($idcategoria,$cod_categoria,$desc_categoria);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$categoria->desactivar($idcategoria);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$categoria->activar($idcategoria);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$categoria->eliminar($idcategoria);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$categoria->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcategoria.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idcategoria.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
            '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcategoria.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button></h5>'	 	 	
            :
			'<h5 style="text-align:center; width:120px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcategoria.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcategoria.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcategoria.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
			</h5>'
            ,
            "1"=>'<h5 style="text-align:center; width:100px">'.$reg->cod_categoria.'</h5>',
            "2"=>'<h5 style="padding-left:5px">'.$reg->desc_categoria.'</h5>',          
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

	case 'listarrpt':
		$rspta=$categoria->listar();
 		//Vamos a declarar un array
		 $data= Array();

		 $cont=0;
 		while ($reg=$rspta->fetch_object()){
 		$data[]=array(
			"0"=>'<h5 style="text-align:center; whidth:50px"><input value="'.$reg->idcategoria.'" type="hidden">
			<span style="width:50px; text-align:center;" class="label bg-red">'.($cont+1).'</span></h5>',
            "1"=>'<h5 style="text-align:center; whidth:100px">'.$reg->cod_categoria.'</h5>',
            "2"=>'<h5 style="padding-left:5px">'.$reg->desc_categoria.'</h5>',          
			"3"=>($reg->estatus)?
			'<h5 style="text-align:center; whidth:100px"><span class="label bg-green">Activado</h5>':
			'<h5 style="text-align:center; whidth:100px"><span class="label bg-red">Desactivado</h5>'
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