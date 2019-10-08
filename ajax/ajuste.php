<?php
require_once "../modelos/Ajuste.php";

$ajuste=new Ajuste();

$idajuste=isset($_POST["idajuste"])? limpiarCadena($_POST["idajuste"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_ajuste=isset($_POST["cod_ajuste"])? limpiarCadena($_POST["cod_ajuste"]):"";
$desc_ajuste=isset($_POST["desc_ajuste"])? limpiarCadena($_POST["desc_ajuste"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$estatus=isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
$totalstock=isset($_POST["totalstock"])? limpiarCadena($_POST["totalstock"]):"";
$totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
		if (empty($idajuste)){
			$rspta=$ajuste->insertar($idusuario,$cod_ajuste,$desc_ajuste,$tipo,$totalstock,$totalh,
			$fechareg, $_POST["idarticulo"],$_POST["iddeposito"],$_POST["cantidad"], $_POST["costo"]);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
			$rspta=$ajuste->ActCod();
			$rspta=$ajuste->AddStockArt($_POST["idarticulo"],$_POST["iddeposito"] ,$_POST["cantidad"], $tipo);
		}
	break;

	case 'generarcodigo':
	$rspta=$ajuste->generarCod();

		while ($reg = $rspta->fetch_object())
		{
			echo $reg->codnum;		
		}                                                                                                                                                                                                                                                                                                                              
	break;

	case 'anular':
		$rspta=$ajuste->anular($idajuste);
		echo $rspta ? "Registro Anulado correctamente!" : "Registro no se puede Anular!";
		$rspta=$ajuste->AnularStock($idajuste,$tipo);		 
	break;

	case 'eliminar':
		$rspta=$ajuste->eliminar($idajuste);
		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
		$rspta=$ajuste->AnularStock($idajuste,$tipo);		 
	break;
	
	case 'mostrar':
		$rspta=$ajuste->mostrar($idajuste);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$ajuste->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			$url='../reportes/rptAjuste.php?id=';
 			$data[]=array(
            "0"=>($reg->estatus=='Registrado')?
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idajuste.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="anular('.$reg->idajuste.',\''.$reg->tipo.'\')" rel="tooltip" data-original-title="Anular"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idajuste.',\''.$reg->tipo.'\')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
			'<a target="_blank" href="'.$url.$reg->idajuste.'"><button class="btn btn-info btn-xs" rel="tooltip" data-original-title="Imprimir"><i class="fa fa-file"></i></button></a>	 	
			</h5>'	 	 	
            :
			'<h5 small style="text-align:center; width:120px" class="small">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idajuste.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" disabled rel="tooltip" data-original-title="Anular"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" disabled rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
			'<a target="_blank" href="'.$url.$reg->idajuste.'"><button class="btn btn-info btn-xs" rel="tooltip" data-original-title="Imprimir"><i class="fa fa-file"></i></button></a>	 	
			</h5>'
			,
			"1"=>'<h5 style="text-align:center; width:100px;">'.$reg->fechareg.'</h5>',
            "2"=>'<h5 style="text-align:center; width:100px;">'.$reg->cod_ajuste.'</h5>',
			"3"=>'<h5 style="padding-left:5px">'.$reg->desc_ajuste.'</h5>',
			"4"=>'<h5 style="padding-left:5px; width:100px;">'.$reg->tipo.'</h5>',
			"5"=>'<h5 style="text-align:right; width:150px;" class="numberf"><span class="numberf">'.$reg->totalh.'</span></h5>',       
			"6"=>($reg->estatus=='Registrado')?
			'<h5 style="text-align:center; width:100px"><span class="label bg-green">Registrado</h5>':
			'<h5 style="text-align:center; width:100px"><span class="label bg-red">Anulado</h5>'
 		);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "listarArticulos":
	require_once "../modelos/Articulo.php";
	$articulo = new Articulo();

	$iddep=$_GET['iddep'];
		
	$rspta=$articulo->select($iddep);

	//Vamos a declarar un array
	$data= Array();

	while ($reg=$rspta->fetch_object()){
		$data[]=array(

			"0"=>'<button class="btn btn-warning btn-xs" onclick="agregarDetalle
			('.$reg->idarticulo.',\''.$reg->cod_articulo.'\',
			\''.$reg->desc_articulo.'\',\''.$reg->iddeposito.'\',\''.$reg->desc_deposito.'\',\''.$reg->costo1.'\',\''.$reg->stock.'\')" 
			keyup="modificarSubototales();" style="text-align:center; width:20px;"><span class="fa fa-plus"></span></button>',
			"1"=>'<h5 style="text-align:center; width:100px;">'.$reg->cod_articulo.'</h5>',
			"2"=>'<h5 style="width:350px; padding-left:5px;">'.$reg->desc_articulo.'</h5>',
			"3"=>'<h5 style="text-align:center; width:80px;">'.$reg->desc_unidad.'</h5>',
			"4"=>'<h5 style="text-align:center; width:200px;">'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</h5>',
			"5"=>'<h5 style="text-align:right; width:50px;">'.$reg->stock.'</h5>',
			"6"=>'<h5 style="text-align:right; width:120px;">'.$reg->costo1.'</h5>'
					);
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

			$rspta=$ajuste->listarDetalle($id);
			echo '<thead class="btn-primary">
					<th style="text-align:center; width:30px;" class="nd">E</th>
					<th style="text-align:center; width:120px;" class="nd">Codigo</th>
					<th style="text-align:center;" class="nd">Artículo</th>
					<th style="text-align:center; width:150px;" class="nd">Deposito</th>
					<th style="text-align:center; width:50px;" class="nd">Unidad</th>
					<th style="text-align:center; width:120px;" class="nd">Cantidad</th>
					<th style="text-align:center; width:120px;" class="nd">Costo</th>
					<th style="text-align:center; width:150px;" class="nd">Total Reng.</th>
				</thead>';
				while ($reg = $rspta->fetch_object())
					{
					echo
						$fila=
						'<tr class="filas">
							<td style="width:20px;"><input id="idajusted" value="'.$reg->idajusted.'" type="hidden"><span style="width:20px; "text-align:center;" class="label bg-red">'.($cont+1).'</span></td>
							<td style="text-align:center; width:120px;"><input id="idarticulo" value="'.$reg->idarticulo.'" type="hidden">'.$reg->cod_articulo.'</td>
							<td style="width:350px;"><span style="font-size:12px">'.$reg->desc_articulo.'</span></td>
							<td style="width:150px;">'.$reg->desc_deposito.'</td>
							<td style="text-align:right;  width:50px;">'.$reg->desc_unidad.'</td>
							<td style="text-align:right;  width:50px;"><input id="cantidad" value="'.$reg->cantidad.'" type="hidden">'.$reg->cantidad.'</td>
							<td style="text-align:right; width:120px;"><span class="numberf">'.$reg->costo.'</span></td>
							<td style="text-align:right; width:150px;"><input id="totald" value="'.$reg->totald.'" type="hidden"><span class="numberf">'.$reg->totald.'</span></td>  
						</tr>',
						$cont++,
						$totalf+=$reg->totald
						;		
					}
					echo '<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>         
							<th></th>
							<th><h4 style="text-align:right;"><B>Total:</B></h4></th>
							<th><h4 style="text-align:right;"><B><span class="numberf" id="totalv">'.$totalf.'</span></B></h4></th>
						</tfoot>';
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