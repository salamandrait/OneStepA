<?php
session_start(); 
require_once "../modelos/Usuario.php";

$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$cod_usuario=isset($_POST["cod_usuario"])? limpiarCadena($_POST["cod_usuario"]):"";
$desc_usuario=isset($_POST["desc_usuario"])? limpiarCadena($_POST["desc_usuario"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
		}
		//Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clave);

		if (empty($idusuario)){
            $rspta=$usuario->insertar($cod_usuario,$desc_usuario,$direccion,$telefono,$email,$departamento,
            $clavehash,$imagen,$fechareg,$_POST['accesos']);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
            
		}
		else {
            $rspta=$usuario->editar($idusuario,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,$departamento,
            $clavehash,$imagen,$fechareg,$_POST['accesos']);
			echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
    break;
    
	case 'eliminar':
        $rspta=$usuario->eliminaracceso($idusuario);
        $rspta=$usuario->eliminar($idusuario);
        echo $rspta ? "Registro Eliminado correctamente!" : "Registro no se puede Eliminar!";
    break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                 "0"=>($reg->condicion)?
                 '<h5 style="text-align:center;">
                 <button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idusuario.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
                '<button class="btn btn-primary btn-xs" onclick="desactivar('.$reg->idusuario.')" rel="tooltip" data-original-title="Desactivar"><i class="fa fa-check-square"></i></button>'.
                 '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idusuario.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
                 </h5>'	 	 	
                  :
                 '<h5 style="text-align:center;">
                  <button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idusuario.')" rel="tooltip" data-original-title="Editar"><i class="fa fa-pencil-square-o"></i></button>'.
                  '<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idusuario.')" rel="tooltip" data-original-title="Activar"><i class="fa fa-exclamation-circle"></i></button>'.
                  '<button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idusuario.')" rel="tooltip" data-original-title="Eliminar"><i class="fa fa-remove"></i></button>
                  </h5>'
                ,
                "1"=>'<h5 style="text-align:center;">'.$reg->cod_usuario.'</h5>',
                "2"=>'<h5>'.$reg->desc_usuario.'</h5>',
                "3"=>'<h5>'.$reg->departamento.'</h5>',             
				"4"=>($reg->condicion)?
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

	case 'accesosg':
		//Obtenemos todos los accesos de la tabla accesos
		require_once "../modelos/Acceso.php";
		$acceso = new Acceso();
		$rspta = $acceso->listarModulo('escritorio');

		//Obtener los accesos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'">'.' '.'<label>'.$reg->desc_acceso.'</label></li>';
			}
	break;

	case 'accesoscf':
		//Obtenemos todos los accesos de la tabla accesos
		require_once "../modelos/Acceso.php";
		$acceso = new Acceso();
		$rspta = $acceso->listarModulo('config');

		//Obtener los accesos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'">'.' '.'<label>'.$reg->desc_acceso.'</label></li>';
			}
	break;

	case 'accesosi':
		//Obtenemos todos los accesos de la tabla accesos
		require_once "../modelos/Acceso.php";
		$acceso = new Acceso();
		$rspta = $acceso->listarModulo('inventario');

		//Obtener los accesos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'">'.' '.'<label>'.$reg->desc_acceso.'</label></li>';
			}
	break;

	case 'accesosc':
		//Obtenemos todos los accesos de la tabla accesos
		require_once "../modelos/Acceso.php";
		$acceso = new Acceso();
		$rspta = $acceso->listarModulo('compras');

		//Obtener los accesos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'">'.' '.'<label>'.$reg->desc_acceso.'</label></li>';
			}
	break;

	case 'accesosv':
		//Obtenemos todos los accesos de la tabla accesos
		require_once "../modelos/Acceso.php";
		$acceso = new Acceso();
		$rspta = $acceso->listarModulo('ventas');

		//Obtener los accesos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'">'.' '.'<label>'.$reg->desc_acceso.'</label></li>';
			}
	break;

	case 'accesosb':
		//Obtenemos todos los accesos de la tabla accesos
		require_once "../modelos/Acceso.php";
		$acceso = new Acceso();
		$rspta = $acceso->listarModulo('Bancos');

		//Obtener los accesos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los accesos marcados
		$valores=array();

		//Almacenar los accesos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idacceso);
			}

		//Mostramos la lista de accesos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idacceso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.'  name="accesos[]" value="'.$reg->idacceso.'">'.' '.'<label>'.$reg->desc_acceso.'</label></li>';
			}
	break;

	case 'verificar':
		$cod_usuarioa=$_POST['cod_usuarioa'];
	    $clavea=$_POST['clavea'];

	    //Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clavea);

		$rspta=$usuario->verificar($cod_usuarioa, $clavehash);

		$fetch=$rspta->fetch_object();

		if (isset($fetch))
	    {
	        //Declaramos las variables de sesión
	        $_SESSION['idusuario']=$fetch->idusuario;
	        $_SESSION['desc_usuario']=$fetch->desc_usuario;
	        $_SESSION['imagen']=$fetch->imagen;
	        $_SESSION['cod_usuario']=$fetch->cod_usuario;

	        //Obtenemos los accesos del usuario
	    	$marcados = $usuario->listarmarcados($fetch->idusuario);

	    	//Declaramos el array para almacenar todos los accesos marcados
			$valores=array();

			//Almacenamos los accesos marcados en el array
			while ($per = $marcados->fetch_object())
				{
					array_push($valores, $per->idacceso);
				}

			//Determinamos los accesos del usuario
			in_array(0,$valores)?$_SESSION['config']=1:$_SESSION['config']=0;
			in_array(1,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
			in_array(2,$valores)?$_SESSION['usuario']=1:$_SESSION['usuario']=0;
			in_array(3,$valores)?$_SESSION['operacion']=1:$_SESSION['operacion']=0;
			in_array(4,$valores)?$_SESSION['correlativo']=1:$_SESSION['correlativo']=0;
			in_array(5,$valores)?$_SESSION['impuesto']=1:$_SESSION['impuesto']=0;
			in_array(6,$valores)?$_SESSION['moneda']=1:$_SESSION['moneda']=0;
			in_array(7,$valores)?$_SESSION['pais']=1:$_SESSION['pais']=0;

			in_array(20,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;

			in_array(40,$valores)?$_SESSION['inventario']=1:$_SESSION['inventario']=0;
			in_array(41,$valores)?$_SESSION['articulo']=1:$_SESSION['articulo']=0;
			in_array(42,$valores)?$_SESSION['categoria']=1:$_SESSION['categoria']=0;
			in_array(43,$valores)?$_SESSION['unidad']=1:$_SESSION['unidad']=0;
			in_array(44,$valores)?$_SESSION['deposito']=1:$_SESSION['deposito']=0;
			in_array(50,$valores)?$_SESSION['opinventario']=1:$_SESSION['opinventario']=0;
			in_array(51,$valores)?$_SESSION['ajuste']=1:$_SESSION['ajuste']=0;
			in_array(52,$valores)?$_SESSION['reportesi']=1:$_SESSION['ajuste']=0;

			in_array(60,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			in_array(61,$valores)?$_SESSION['proveedor']=1:$_SESSION['proveedor']=0;
			in_array(62,$valores)?$_SESSION['tipoproveedor']=1:$_SESSION['tipoproveedor']=0;
			in_array(63,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;
			in_array(70,$valores)?$_SESSION['opcompras']=1:$_SESSION['opcompras']=0;
			in_array(71,$valores)?$_SESSION['ccompra']=1:$_SESSION['ccompra']=0;
			in_array(72,$valores)?$_SESSION['pcompra']=1:$_SESSION['pcompra']=0;
			in_array(73,$valores)?$_SESSION['fcompra']=1:$_SESSION['fcompra']=0;
			in_array(74,$valores)?$_SESSION['rcompra']=1:$_SESSION['fcompra']=0;

			in_array(80,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
			in_array(81,$valores)?$_SESSION['cliente']=1:$_SESSION['cliente']=0;
			in_array(82,$valores)?$_SESSION['tipocliente']=1:$_SESSION['tipocliente']=0;
			in_array(83,$valores)?$_SESSION['vendedor']=1:$_SESSION['vendedor']=0;
			in_array(84,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;	
			in_array(90,$valores)?$_SESSION['opventas']=1:$_SESSION['opventas']=0;
			in_array(91,$valores)?$_SESSION['cventa']=1:$_SESSION['cventa']=0;
			in_array(92,$valores)?$_SESSION['pventa']=1:$_SESSION['pventa']=0;
			in_array(93,$valores)?$_SESSION['fventa']=1:$_SESSION['fventa']=0;
			in_array(94,$valores)?$_SESSION['rventa']=1:$_SESSION['rventa']=0;

			in_array(100,$valores)?$_SESSION['bancos']=1:$_SESSION['bancos']=0;
			in_array(101,$valores)?$_SESSION['banco']=1:$_SESSION['banco']=0;
			in_array(102,$valores)?$_SESSION['caja']=1:$_SESSION['caja']=0;
			in_array(103,$valores)?$_SESSION['cuenta']=1:$_SESSION['cuenta']=0;
			in_array(104,$valores)?$_SESSION['ipago']=1:$_SESSION['ipago']=0;			
			in_array(120,$valores)?$_SESSION['opbancos']=1:$_SESSION['opbancos']=0;
			in_array(115,$valores)?$_SESSION['movcaja']=1:$_SESSION['movcaja']=0;
			in_array(116,$valores)?$_SESSION['movbanco']=1:$_SESSION['movbanco']=0;

	    }
	    echo json_encode($fetch);
	break;

	case 'salir':
		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al cod_usuario
        header("Location: ../index.php");

	break;
}
?>