<?php
require_once "../modelos/Proveedor.php";

$proveedor=new Proveedor();

$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idtipoproveedor=isset($_POST["idtipoproveedor"])? limpiarCadena($_POST["idtipoproveedor"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$cod_proveedor=isset($_POST["cod_proveedor"])? limpiarCadena($_POST["cod_proveedor"]):"";
$desc_proveedor=isset($_POST["desc_proveedor"])? limpiarCadena($_POST["desc_proveedor"]):"";
$rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";
$codpostal=isset($_POST["codpostal"])? limpiarCadena($_POST["codpostal"]):"";
$contacto=isset($_POST["contacto"])? limpiarCadena($_POST["contacto"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$movil=isset($_POST["movil"])? limpiarCadena($_POST["movil"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$web=isset($_POST["web"])? limpiarCadena($_POST["web"]):"";
$diascredito=isset($_POST["diascredito"])? limpiarCadena($_POST["diascredito"]):"";
$limite=isset($_POST["limite"])? limpiarCadena($_POST["limite"]):"";
$saldo=isset($_POST["saldo"])? limpiarCadena($_POST["saldo"]):"";
$montofiscal=isset($_POST["montofiscal"])? limpiarCadena($_POST["montofiscal"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$aplicacredito=isset($_POST["aplicacredito"])? limpiarCadena($_POST["aplicacredito"]):"";
$aplicareten=isset($_POST["aplicareten"])? limpiarCadena($_POST["aplicareten"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idproveedor)){
			$rspta=$proveedor->insertar($idtipoproveedor,$idzona,$idoperacion,$cod_proveedor,
			$desc_proveedor,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,
			$diascredito,$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$proveedor->editar($idproveedor,$idtipoproveedor,$idzona,$idoperacion,$cod_proveedor,
			$desc_proveedor,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,
			$diascredito,$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$proveedor->desactivar($idproveedor);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$proveedor->activar($idproveedor);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$proveedor->eliminar($idproveedor);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$proveedor->mostrar($idproveedor);
 		
 		echo json_encode($rspta);
	break;

	case 'mostrarcontacto':
	$rspta=$proveedor->mostrarcontacto($idproveedor);
	 //Codificar el resultado utilizando json
	 echo json_encode($rspta);
	break;

	case 'mostrarsaldo':
	$rspta=$proveedor->mostrarsaldo($idproveedor);
	 //Codificar el resultado utilizando json
	 echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$proveedor->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				 "0"=>($reg->estatus)?
				'<h5 style="text-align:center; width:130px;">
				<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproveedor.')"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idproveedor.')"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idproveedor.')"><i class="fa fa-remove"></i></button>'.	
				'<button class="btn btn-success btn-xs" onclick="mostrarcontacto('.$reg->idproveedor.')" data-toggle="modal" href="#Contacto"><i class="fa fa-fax"></i></button>'.
				'<button class="btn bg-navy btn-xs" onclick="mostrarsaldo('.$reg->idproveedor.')" data-toggle="modal" href="#Saldo"><i class="fa fa-eye"></i></button>
				</h5>'	 	 	
 				:
				'<h5 style="text-align:center; width:130px;">
				 <button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproveedor.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
 				'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idproveedor.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idproveedor.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="mostrarcontacto('.$reg->idproveedor.')" data-toggle="modal" href="#Contacto"><i class="fa fa-fax"></i></button>'.
				'<button class="btn bg-navy btn-xs" onclick="mostrarsaldo('.$reg->idproveedor.')" data-toggle="modal" href="#Saldo" ><i class="fa fa-eye"></i></button>
				</h5>'
                 ,
                 "1"=>'<h5 style="text-align:center; width:100px;">'.$reg->cod_proveedor.'</h5>',
				 "2"=>'<h5 style="width:350px;">'.$reg->desc_proveedor.'</h5>',
				 "3"=>'<h5 style="text-align:center; width:100px;">'.$reg->rif.'</h5>',
				 "4"=>'<h5 style="width:250px;">'.$reg->cod_tipoproveedor.'-'.$reg->desc_tipoproveedor.'</h5>',
				 "5"=>'<h5 style="text-align:right; width:150px;"><span class="numberf">'.$reg->saldo.'</span></h5>',
                 "6"=>($reg->estatus)?
                 '<h5 style="text-align:center; width:80px;"><span class="label bg-green" style="text-align:center; width:80px;">Activado</span></h5>':
                 '<h5 style="text-align:center; width:80px;"><span class="label bg-red" style="text-align:center; width:80px;">Desactivado</span></h5>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectTipoProveedor":
		require_once "../modelos/TipoProveedor.php";
		$tipoproveedor = new TipoProveedor();

		$rspta = $tipoproveedor->select();

		while ($reg = $rspta->fetch_object()){
					echo '<option value='.$reg->idtipoproveedor.'>'.$reg->cod_tipoproveedor.'-'.$reg->desc_tipoproveedor.'</option>';
		}
	break;

	case "selectZona":
		require_once "../modelos/Zona.php";
		$zona = new Zona();

		$rspta = $zona->select();

		while ($reg = $rspta->fetch_object()){
					echo '<option value='.$reg->idzona.'>'.$reg->cod_zona.'-'.$reg->desc_zona.'</option>';
		}
	break;

	case "selectOperacion":
		require_once "../modelos/Operacion.php";
		$operacion = new Operacion();

		$escompra="";

		$rspta = $operacion->select('compra');

		while ($reg = $rspta->fetch_object())
		{
					echo '<option value='.$reg->idoperacion.'>'.$reg->cod_operacion.'-'.$reg->desc_operacion.'</option>';
		}
	break;
}

?>