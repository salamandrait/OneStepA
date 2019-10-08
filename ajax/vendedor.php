<?php
require_once "../modelos/Vendedor.php";

$vendedor=new Vendedor();

$idvendedor=isset($_POST["idvendedor"])? limpiarCadena($_POST["idvendedor"]):"";
$cod_vendedor=isset($_POST["cod_vendedor"])? limpiarCadena($_POST["cod_vendedor"]):"";
$desc_vendedor=isset($_POST["desc_vendedor"])? limpiarCadena($_POST["desc_vendedor"]):"";
$rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$comisionv=isset($_POST["comisionv"])? limpiarCadena($_POST["comisionv"]):"";
$comisionc=isset($_POST["comisionc"])? limpiarCadena($_POST["comisionc"]):"";
$esvendedor=isset($_POST["esvendedor"])? limpiarCadena($_POST["esvendedor"]):"";
$escobrador=isset($_POST["escobrador"])? limpiarCadena($_POST["escobrador"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idvendedor)){
			$rspta=$vendedor->insertar($cod_vendedor,$desc_vendedor,$rif,$direccion,$fechareg, 
			$comisionv, $comisionc, $esvendedor, $escobrador);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$vendedor->editar($idvendedor,$cod_vendedor,$desc_vendedor,$rif,$direccion,$fechareg, 
			$comisionv, $comisionc, $esvendedor, $escobrador);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$vendedor->desactivar($idvendedor);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$vendedor->activar($idvendedor);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$vendedor->eliminar($idvendedor);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$vendedor->mostrar($idvendedor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$vendedor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				 "0"=>($reg->estatus)?
				'<h5 style="text-align:center;">
				<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idvendedor.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
 				'<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idvendedor.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idvendedor.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
				</h5>'	 	 	
 				:
				'<h5 style="text-align:center;">
				 <button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idvendedor.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
 				'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idvendedor.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				 '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idvendedor.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
				 </h5>'
                 ,
                 "1"=>'<h5 style="text-align:center; width:100px;">'.$reg->cod_vendedor.'</h5>',
				 "2"=>'<h5>'.$reg->desc_vendedor.'</h5>',
				 "3"=>($reg->esvendedor)?'<h5 style="text-align:center;"><span class="label bg-green">Si</span></h5>':'<h5 style="text-align:center;"><span class="label bg-red">No</span></h5>',
				 "4"=>($reg->escobrador)?'<h5 style="text-align:center;"><span class="label bg-green">Si</span></h5>':'<h5 style="text-align:center;"><span class="label bg-red">No</span></h5>',
                 "5"=>($reg->estatus)?
                 '<h5 style="text-align:center;"><span class="label bg-green">Activado</span></h5>':
                 '<h5 style="text-align:center;"><span class="label bg-red">Desactivado</span></h5>'
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