<?php
require_once "../modelos/Articulo.php";

$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idunidad=isset($_POST["idunidad"])? limpiarCadena($_POST["idunidad"]):"";
$idimpuesto=isset($_POST["idimpuesto"])? limpiarCadena($_POST["idimpuesto"]):"";
$cod_articulo=isset($_POST["cod_articulo"])? limpiarCadena($_POST["cod_articulo"]):"";
$desc_articulo=isset($_POST["desc_articulo"])? limpiarCadena($_POST["desc_articulo"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
$artref=isset($_POST["artref"])? limpiarCadena($_POST["artref"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$costo1=isset($_POST["costo1"])? limpiarCadena($_POST["costo1"]):"";
$costo2=isset($_POST["costo2"])? limpiarCadena($_POST["costo2"]):"";
$costo3=isset($_POST["costo3"])? limpiarCadena($_POST["costo3"]):"";
$precio1=isset($_POST["precio1"])? limpiarCadena($_POST["precio1"]):"";
$precio2=isset($_POST["precio2"])? limpiarCadena($_POST["precio2"]):"";
$precio3=isset($_POST["precio3"])? limpiarCadena($_POST["precio3"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";

$iddeposito=isset($_POST["iddeposito"])? limpiarCadena($_POST["iddeposito"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])){
			$imagen=$_POST["imagenactual"];
		} else {
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png"){
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}

		if (empty($idarticulo)){
			$rspta=$articulo->insertar($idcategoria,$idunidad,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,
			$artref,$costo1,$costo2,$costo3,$precio1,$precio2,$precio3,$fechareg,$imagen,$_POST["idarticulo"], $_POST["iddeposito"]);
			echo $rspta ? "Registro Ingresado Correctamente!" : "Registro no se pudo Registrar!";
		}
		else {
			$rspta=$articulo->editar($idarticulo,$idcategoria,$idunidad,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,
			$artref,$costo1,$costo2,$costo3,$precio1,$precio2,$precio3,$fechareg,$imagen);
			echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se pudo Actualizar!";
			$rspta=$articulo->insertarDep($idarticulo,$iddeposito);
		}
		
	break;

	case 'desactivar':
		$valor='';
		$rspta=$articulo->desactivar($idarticulo);
		echo $rspta ? "Registro Desactivado correctamente!" : "Registro no se puede desactivar!";;
	break;

	case 'activar':
		$rspta=$articulo->activar($idarticulo);
 		echo $rspta ? "Registro Activado correctamente!" : "Registro no se puede Activar!";
	break;

	case 'eliminar':
		$rspta=$articulo->eliminar($idarticulo);
 		echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
	break;
	
	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'agregardeposito':
	$rspta=$articulo->insertarDep($idarticulo,$iddeposito);
	echo $rspta ? "Registro Actualizado correctamente!" : "Registro no se puede Actualizar!";
	break;

	case 'mostrarprecio':
	$rspta=$articulo->mostrar($idarticulo);
	 //Codificar el resultado utilizando json
	 echo json_encode($rspta);
	break;

	case 'mostrarcosto':
	$rspta=$articulo->mostrar($idarticulo);
	 //Codificar el resultado utilizando json
	 echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$articulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
            "0"=>($reg->estatus)?
			'<h5 style="text-align:center; width:150px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idarticulo.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idarticulo.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idarticulo.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
			'<button class="btn btn-success btn-xs" onclick="mostrarcosto('.$reg->idarticulo.');" data-toggle="modal" href="#modal-costo" rel="tooltip" data-original-title="Costos"><i class="fa fa-money"></i></button>'.
			'<button class="btn bg-purple btn-xs" onclick="mostrarprecio('.$reg->idarticulo.');" data-toggle="modal" href="#modal-precio" rel="tooltip" data-original-title="Precios"><i class="fa fa-cart-plus"></i></button>
			</h5>'	 	 	
            :
			'<h5 style="text-align:center; width:150px;">
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idarticulo.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
            '<button class="btn bg-red btn-xs" onclick="activar('.$reg->idarticulo.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-exclamation-circle"></i></button>'.
			'<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idarticulo.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>'.
			'<button class="btn btn-success btn-xs" onclick="mostrarcosto('.$reg->idarticulo.');" data-toggle="modal" href="#modal-costo" rel="tooltip" data-original-title="Costos"><i class="fa fa-money"></i></button>'.
			'<button class="btn bg-purple btn-xs" onclick="mostrarprecio('.$reg->idarticulo.');" data-toggle="modal" href="#modal-precio" rel="tooltip" data-original-title="Precios"><i class="fa fa-cart-plus"></i></button>
			</h5>'
			,
            "1"=>'<h5 style="text-align:center; width:120px" class="hmin">'.$reg->cod_articulo.'</h5>',
			"2"=>'<h5 style="padding-left:5px; width:400px;" class="hmin">'.$reg->desc_articulo.'</h5>',
			"3"=>'<h5 style="padding-left:5px; width:300px;" class="hmin">'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</h5>',
			"4"=>'<h5 style="text-align:center; width:150px" class="hmin">'.$reg->artref.'</h5>',
			"5"=>($reg->stock==null)?'<h5 style="text-align:right; width:80px" class="hmin">0</h5>':'<h5 style="text-align:right; width:80px" class="hmin">'.$reg->stock.'</h5>',
			"6"=>($reg->estatus)?
			'<h5 style="text-align:center; width:100px"><span class="label bg-green">Activado</h5>':
			'<h5 style="text-align:center; width:100px"><span class="label bg-red">Desactivado</h5>',
			"7"=>'<h5 style="text-align:right; width:120px" class="hmin">'.$reg->costo1.'</h5>',
			"8"=>'<h5 style="text-align:right; width:120px" class="hmin">'.$reg->precio1.'</h5>',
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
	$rspta=$articulo->listar();
	 //Vamos a declarar un array
	 $data= Array();

	 $cont=0;
	 while ($reg=$rspta->fetch_object()){
	 $data[]=array(
		"0"=>'<h5 style="text-align:center; whidth:50px"><input value="'.$reg->idarticulo.'" type="hidden">
		<span style="width:50px; text-align:center;" class="label bg-red">'.($cont+1).'</span></h5>',
		"1"=>'<h5 style="text-align:center; width:150px" class="hmin">'.$reg->cod_articulo.'</h5>',
		"2"=>'<h5 style="padding-left:5px; width:470px;" class="hmin">'.$reg->desc_articulo.'</h5>',
		"3"=>'<h5 style="padding-left:5px; width:300px;" class="hmin">'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</h5>',
		"4"=>'<h5 style="text-align:center; width:150px" class="hmin">'.$reg->artref.'</h5>',
		"5"=>'<h5 style="text-align:right; width:80px" class="hmin">'.$reg->stock.'</h5>',
		"6"=>($reg->estatus)?
		'<h5 style="text-align:center; width:100px"><span class="label bg-green">Activado</h5>':
		'<h5 style="text-align:center; width:100px"><span class="label bg-red">Desactivado</h5>',
		"7"=>'<h5 style="text-align:right; width:120px" class="hmin">'.$reg->costo1.'</h5>',
		"8"=>'<h5 style="text-align:right; width:120px" class="hmin">'.$reg->precio1.'</h5>',
	 );
	 }

	 $results = array(
		 "sEcho"=>1, //Información para el datatables
		 "iTotalRecords"=>count($data), //enviamos el total registros al datatable
		 "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		 "aaData"=>$data);
	 echo json_encode($results);

	break;

	case 'listardepositoStock':
		require_once "../modelos/Deposito.php";
		$deposito = new Deposito();

		$idart=$_GET['idart'];

		$rspta=$deposito->listarStock($idart);
		//Vamos a declarar un array
		$data= Array();

		$totalst=0;

		$cont=0;
		echo '
		<thead class="bg-gray-active">
			<th style="width:50px; text-align:center;" class="nd">Reng</th>
            <th style="width:200px; text-align:center;" class="nd">Deposito</th>
            <th style="width:100px; text-align:center;" class="nd">Stock</th>
        </thead>
		';
		while ($reg = $rspta->fetch_object())
		{
		echo
			$fila=
			'<tr class="filas">
				<td style="width:50px;"><input id="idajusted" value="'.$reg->iddeposito.'" type="hidden"><span style="width:20px; "text-align:center;" class="label bg-red">'.($cont+1).'</span></td>
				<td style="width:200px;">'.$reg->cod_deposito.'-'.$reg->desc_deposito.'</td>
				<td style="text-align:right; width:100px;">'.$reg->stock.'</td>
				</tr>',
			$cont++,
			$totalst+=$reg->stock
			;		
		}
		echo '<tfoot>      
				<th></th>
				<th><h5 style="text-align:right;"><B>Total Stock:</B></h5></th>
				<th><h4 style="text-align:right;"><B><span class="numberf" id="lbtotalstock">'.$totalst.'</span></B></h4></th>
			</tfoot>';
	break;

	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object()){
					echo '<option value='.$reg->idcategoria.'>'.$reg->cod_categoria.'-'.$reg->desc_categoria.'</option>';
				}
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


		
	case "selectUnidad":
		require_once "../modelos/Unidad.php";
		$unidad = new Unidad();

		$rspta = $unidad->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value='.$reg->idunidad.'>'.$reg->cod_unidad.'-'.$reg->desc_unidad.'</option>';
				}
	break;

	case "selectImpuesto":
		require_once "../modelos/Impuesto.php";
		$impuesto = new Impuesto();

		$rspta = $impuesto->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value='.$reg->idimpuesto.'>'.$reg->desc_impuesto.' '.$reg->tasa.'</option>';
				}
	break;

}

?>