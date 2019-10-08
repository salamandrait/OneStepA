<?php
require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idvendedor=isset($_POST["idvendedor"])? limpiarCadena($_POST["idvendedor"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_venta=isset($_POST["cod_venta"])? limpiarCadena($_POST["cod_venta"]):"";
$desc_venta=isset($_POST["desc_venta"])? limpiarCadena($_POST["desc_venta"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$numerod=isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
$numeroc=isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
$origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$subtotalh=isset($_POST["subtotalh"])? limpiarCadena($_POST["subtotalh"]):"";
$impuestoh=isset($_POST["impuestoh"])? limpiarCadena($_POST["impuestoh"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$saldoh=isset($_POST["saldoh"])? limpiarCadena($_POST["saldoh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$fechaven=isset($_POST["fechaven"])? limpiarCadena($_POST["fechaven"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idventa)){
			
			$rspta=$venta->insertar($idusuario,$idcliente,$idvendedor,$cod_venta,$desc_venta,$numerod,$numeroc,$tipo,$origen,
			$estatus,$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,
			$_POST['idarticulo'],$_POST['iddeposito'],$_POST['cantidad'],$_POST['precio'],$_POST['tasa']);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
			($tipo!='Cotizacion')?$rspta=$venta->AddStockArt($_POST['idarticulo'],$_POST['iddeposito'],$_POST['cantidad']):'';
			($tipo!='Cotizacion')?$rspta=$venta->addsaldocliente($idcliente,$totalh):'';
			$rspta=$venta->ActCod($tipo);
		}
	break;

	case 'generarcodigo':

		$ftipo=$_GET['ftipo'];

		$rspta=$venta->generarCod($ftipo);

			while ($reg = $rspta->fetch_object())
			{
				echo $reg->codnum;		
			}
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
		 echo $rspta ? "Registro Anulado correctamente!" : "Registro no se pudo Anular!";
		 ($tipo!='Cotizacion')?$rspta=$venta->delSaldo($idcliente,$totalh):'';
		 ($tipo!='Cotizacion')?$rspta=$venta->actDetalle($idventa):'';
	break;

	case 'eliminar':
		$rspta=$venta->eliminar($idventa);
		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se pudo Eliminar!";
		($tipo!='Cotizacion')?$rspta=$venta->delSaldo($idcliente,$totalh):'';
		($tipo!='Cotizacion')?$rspta=$venta->actDetalle($idventa):'';
	break;
	
	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$tipo=$_GET['ftipo'];

		$rspta=$venta->listar($tipo);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
				$url='../reportes/rptVenta.php?id=';
				$data[]=array(
				"0"=>($reg->estatus=='Registrado')?
				'<h5 style="text-align:center; width:100px;">
				<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-primary btn-xs" onclick="anular('.$reg->idventa.',\''.$reg->tipo.'\',\''.$reg->idcliente.'\',\''.$reg->totalh.'\');" rel="tooltip" data-original-title="Anular"><i class="fa fa-check-square"></i></button>'.
				'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idventa.',\''.$reg->tipo.'\',\''.$reg->idcliente.'\',\''.$reg->totalh.'\');" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
				'<a target="_blank" href="'.$url.$reg->idventa.'"><button class="btn btn-info btn-xs" rel="tooltip" data-original-title="Imprimir"><i class="fa fa-file"></i></button></a>
				</h5>' 	 	
				:
				'<h5 style="text-align:center; width:100px;">
				<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
				'<button class="btn btn-primary btn-xs" disabled ('.$reg->idventa.') rel="tooltip" data-original-title="Anular"><i class="fa fa-exclamation-circle"></i></button>'.
				'<button class="btn bg-red-gradient btn-xs" disabled ('.$reg->idventa.') rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.		
				'<a target="_blank" href="'.$url.$reg->idventa.'"><button class="btn btn-info btn-xs" rel="tooltip" data-original-title="Imprimir"><i class="fa fa-file"></i></button></a>
				</h5>'
				,
				"1"=>($reg->tipo=='Pedido' && $reg->estatus=='Registrado' ||$reg->tipo=='Factura' && $reg->estatus=='Registrado'||$reg->tipo=='Cotizacion' && $reg->estatus=='Registrado')?'
				<h5 style="text-align:center; width:50px;"><button class="btn bg-aqua-active btn-xs" rel="tooltip" data-original-title="Procesar"><i class="fa fa-file-archive-o"></i></button></h5>':
				'<h5 style="text-align:center; width:50px;"><button class="btn bg-aqua-active btn-xs" disabled><i class="fa fa-file-archive-o"></i></button>
				</h5>',
				"2"=>'<h5 style="text-align:center; width:90px;">'.$reg->fechareg.'</h5>',
				"3"=>'<h5 style="text-align:center; width:90px;">'.$reg->cod_venta.'</h5>',
				"4"=>'<h5 style="width:350px; padding-left:5px">'.$reg->desc_cliente.'</h5>',
				"5"=>'<h5 style="text-align:center; width:100px;">'.$reg->rif.'</h5>',
				"6"=>'<h5 style="text-align:center; width:100px;">'.$reg->numerod.'</h5>',
				"7"=>'<h5 style="text-align:right; width:120px;"><span class="numberf">'.$reg->totalh.'</span></h5>',         
				"8"=>($reg->estatus=='Registrado')?
				'<h5 style="text-align:center; width:100px"><span class="label bg-green">Activado</h5>':
				'<h5 style="text-align:center; width:100px"><span class="label bg-red">Desactivado</h5>');
			}	
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			 "aaData"=>$data);
			 
		echo json_encode($results);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$cont=0;
		$subtotalf=0;
		$impsubf=0;
		$totalf=0;

		$rspta=$venta->listarDetalle($id);
		echo '<thead class="bg-blue">
				<th>R.</th>
				<th>Codigo</th>
				<th>Artículo</th>
				<th>Cantidad</th>
				<th>Precio Und</th>
				<th>SubTotal</th>
				<th>Impuesto</th>
				<th>Total Reng.</th>
			</thead>';
		while ($reg = $rspta->fetch_object())
			{
			echo
				$fila='<tr class="filas">
					<td><span style="width:20px;text-align:center;" class="label bg-red">'.($cont+1).'</span></td>
					<td><h5 style="width:100px; font-size:12px;">'.$reg->cod_articulo.'</h5></td>
					<td><h5 style="width:300px; font-size:11px;">'.$reg->desc_articulo.'</h5></td>
					<td><h5 style="width:60px; text-align:right;">'.$reg->cantidad.'</h5></td>
					<td><h5 style="width:110px; text-align:right;"><span class="numberf">'.$reg->precio.'</span></h5></td>
					<td><h5 style="width:120px; text-align:right;"><span class="numberf">'.$reg->subtotald.'</span></h5></td>
					<td><h5 style="width:110px; text-align:right;"><span class="numberf">'.$reg->impsubd.'</span></h5></td>
					<td><h5 style="width:120px; text-align:right;"><span class="numberf">'.$reg->totald.'</span></h5></td>  
				</tr>',
				$cont++,
				$subtotalt+=$reg->subtotald,
				$impsubt+=$reg->impsubd,
				$totalt+=$reg->totald
				;		
			}
			echo '<tfoot>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>         
					<th></th>
					<th>
					<h4 style="text-align:right;">Sub Total:</h4>
					<h4 style="text-align:right;">I.V.A.:</h4>
					<h4 style="text-align:right;"><B>Total:</B></h4>
					</th>
					<th>
					<h4 style="text-align:right;"><span class="numberf" id="subtotalt">'.$subtotalt.'</span></h4>
					<h4 style="text-align:right;"><span class="numberf" id="impuestot">'.$impsubt.'</span></h4>
					<h4 style="text-align:right;"><B><span class="numberf" id="totalt">'.$totalt.'</span></B></h4>   
					</th>
				</tfoot>';
	break;

	case "listarArticulos":
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$iddep=$_GET['iddep'];
		$tipoprecio=$_GET['tipoprecio'];
			
		$rspta=$articulo->selectProceso($iddep);
		$preciom;

		//Vamos a declarar un array
		$data= Array();
		//Se Mostratara el Precio Segun el Tipo
			while ($reg=$rspta->fetch_object()){
				if ($tipoprecio=='p1') {
					$preciom=$reg->precio1;
				} else if ($tipoprecio=='p2'){
					$preciom=$reg->precio2;
				} else if ($tipoprecio=='p3'){
					$preciom=$reg->precio3;
				}
			$data[]=array(
				
				"0"=>'<h5 style="text-align:center;"><button class="btn btn-warning btn-xs" onclick="agregarDetalle
				('.$reg->idarticulo.',\''.$reg->cod_articulo.'\',\''.$reg->desc_articulo.'\',
				\''.$reg->iddeposito.'\',\''.$reg->tasa.'\',\''.$preciom.'\')" 
				keyup="modificarSubototales();"><span class="fa fa-plus"></span></button></h5>',
				"1"=>'<h5 style="text-align:center; width:100px;">'.$reg->cod_articulo.'</h5>',
				"2"=>'<h5 style="width:350px; padding-left:5px;">'.$reg->desc_articulo.'</h5>',
				"3"=>'<h5 style="width:100px; padding-left:5px;">'.$reg->artref.'</h5>',
				"4"=>'<h5 style="width:180px; padding-left:5px;">'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</h5>',
				"5"=>'<h5 style="text-align:center; width:80px;">'.$reg->desc_unidad.'</h5>',
				"6"=>'<h5 style="text-align:right; width:50px;">'.$reg->stock.'</h5>',
				"7"=>'<h5 style="text-align:right; width:120px;"><span class="numberf">'.$preciom.'</span></h5>',
				"8"=>'<h5 style="text-align:center; width:40px;">'.$reg->tasa.'</h5>'
				);
				}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
	break;

	case "listarCliente":
		require_once "../modelos/Cliente.php";
		$cliente = new Cliente();

		$rspta=$cliente->select();
		//Vamos a declarar un array
		$data= Array();

		while ($reg=$rspta->fetch_object()){
			$data[]=array(
				"0"=>'<h5 style="text-align:center;"><button class="btn btn-warning btn-xs" onclick="agregarCliente
				('.$reg->idcliente.',\''.$reg->cod_cliente.'\',\''.$reg->desc_cliente.'\',
				\''.$reg->rif.'\',\''.$reg->diascredito.'\',\''.$reg->limite.'\',
				\''.$reg->idvendedor.'\',\''.$reg->cod_vendedor.'\',\''.$reg->desc_vendedor.'\')">
				<span class="fa fa-plus"></span></button></h5>',
				"1"=>'<h5 style="width:80px; text-align:center;">'.$reg->cod_cliente.'</h5>',
				"2"=>'<h5 style="width:260px;">'.$reg->desc_cliente.'</h5>',
				"3"=>'<h5 style="width:100px; text-align:center;">'.$reg->rif.'</h>',
				"4"=>'<h5 style="width:220px;">'.$reg->cod_vendedor.'-'.$reg->desc_vendedor.'</h5>'
				);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

	case "listarVendedor":
		require_once "../modelos/Vendedor.php";
		$vendedor = new Vendedor();

		$rspta=$vendedor->select();
		//Vamos a declarar un array
		$data= Array();

		while ($reg=$rspta->fetch_object()){
			$data[]=array(
				"0"=>'<h5 style="text-align:center;"><button class="btn btn-warning btn-xs" onclick="agregarVendedor
				('.$reg->idvendedor.',\''.$reg->cod_vendedor.'\',\''.$reg->desc_vendedor.'\')"><span class="fa fa-plus"></span></button></h5>',
				"1"=>'<h5 style="width:10px; text-align:center;">'.$reg->cod_vendedor.'</h5>',
				"2"=>'<h5 style="width:300px;">'.$reg->desc_vendedor.'</h5>'
				);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

	case "selectDeposito":
		require_once "../modelos/Deposito.php";
		$deposito = new Deposito();

		$rspta = $deposito->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value='.$reg->iddeposito.'>'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</option>';
				}
	break;


}

?>