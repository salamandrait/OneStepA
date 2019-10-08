<?php
require_once "../modelos/Cliente.php";

$cliente=new Cliente();

$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idvendedor=isset($_POST["idvendedor"])? limpiarCadena($_POST["idvendedor"]):"";
$idtipocliente=isset($_POST["idtipocliente"])? limpiarCadena($_POST["idtipocliente"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
$cod_cliente=isset($_POST["cod_cliente"])? limpiarCadena($_POST["cod_cliente"]):"";
$desc_cliente=isset($_POST["desc_cliente"])? limpiarCadena($_POST["desc_cliente"]):"";
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
		if (empty($idcliente)){
			$rspta=$cliente->insertar($idvendedor,$idtipocliente,$idzona,$idoperacion,$cod_cliente,
			$desc_cliente,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,
			$diascredito,$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$cliente->editar($idcliente,$idvendedor,$idtipocliente,$idzona,$idoperacion,$cod_cliente,
			$desc_cliente,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,
			$diascredito,$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
		}
	break;

	case 'desactivar':
		$rspta=$cliente->desactivar($idcliente);
 		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";
	break;

	case 'activar':
		$rspta=$cliente->activar($idcliente);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$cliente->eliminar($idcliente);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$cliente->mostrar($idcliente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostrarcontacto':
	$rspta=$cliente->mostrarcontacto($idcliente);
	 //Codificar el resultado utilizando json
	 echo json_encode($rspta);
	break;

	case 'mostrarsaldo':
	$rspta=$cliente->mostrarsaldo($idcliente);
	 //Codificar el resultado utilizando json
	 echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cliente->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				 "0"=>($reg->estatus)?
				'<h5 style="text-align:center; width:130px;">
				<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcliente.')"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idcliente.')"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcliente.')"><i class="fa fa-remove"></i></button>'.	
				'<button class="btn btn-success btn-xs" onclick="mostrarcontacto('.$reg->idcliente.')" data-toggle="modal" href="#Contacto"><i class="fa fa-fax"></i></button>'.
				'<button class="btn bg-navy btn-xs" onclick="mostrarsaldo('.$reg->idcliente.')" data-toggle="modal" href="#Saldo"><i class="fa fa-eye"></i></button>
				</h5>'	 	 	
 				:
				'<h5 style="text-align:center; width:130px;">
				 <button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcliente.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
 				'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcliente.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcliente.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
				'<button class="btn btn-success btn-xs" onclick="mostrarcontacto('.$reg->idcliente.')" data-toggle="modal" href="#Contacto"><i class="fa fa-fax"></i></button>'.
				'<button class="btn bg-navy btn-xs" onclick="mostrarsaldo('.$reg->idcliente.')" data-toggle="modal" href="#Saldo" ><i class="fa fa-eye"></i></button>
				</h5>'
                 ,
                 "1"=>'<h5 style="text-align:center; width:100px;">'.$reg->cod_cliente.'</h5>',
				 "2"=>'<h5 style="width:350px;">'.$reg->desc_cliente.'</h5>',
				 "3"=>'<h5 style="text-align:center; width:100px;">'.$reg->rif.'</h5>',
				 "4"=>'<h5 style="width:250px;">'.$reg->cod_tipocliente.'-'.$reg->desc_tipocliente.'</h5>',
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

	case "selectTipoCliente":
		require_once "../modelos/TipoCliente.php";
		$tipocliente = new TipoCliente();

		$rspta = $tipocliente->select();

		while ($reg = $rspta->fetch_object()){
					echo '<option value='.$reg->idtipocliente.'>'.$reg->cod_tipocliente.'-'.$reg->desc_tipocliente.'</option>';
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

		$rspta = $operacion->select('venta');

		while ($reg = $rspta->fetch_object())
		{
					echo '<option value='.$reg->idoperacion.'>'.$reg->cod_operacion.'-'.$reg->desc_operacion.'</option>';
		}
	break;

	case "selectVendedor":
		require_once "../modelos/Vendedor.php";
		$vendedor = new Vendedor();

		$rspta = $vendedor->select();

		while ($reg = $rspta->fetch_object()){
					echo '<option value='.$reg->idvendedor.'>'.$reg->cod_vendedor.'-'.$reg->desc_vendedor.'</option>';
		}
	break;
}

?>