<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Proveedor
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idtipoproveedor,$idzona,$idoperacion,$cod_proveedor,
	$desc_proveedor,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$diascredito,
	$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo)
	{
		$sql="INSERT INTO tbproveedor (idtipoproveedor,idzona,idoperacion,cod_proveedor,desc_proveedor,
		rif,direccion,ciudad,codpostal,contacto,telefono,movil,email,web,diascredito,limite,montofiscal,
		fechareg,aplicacredito,aplicareten,estatus,saldo)
		VALUES ('$idtipoproveedor','$idzona','$idoperacion','$cod_proveedor','$desc_proveedor',
		'$rif','$direccion','$ciudad','$codpostal','$contacto','$telefono','$movil','$email','$web','$diascredito',
		'$limite','$montofiscal','$fechareg','$aplicacredito','$aplicareten','$saldo','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idproveedor,$idtipoproveedor,$idzona,$idoperacion,$cod_proveedor,
	$desc_proveedor,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$diascredito,
	$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo)
	{
		$sql="UPDATE 
		tbproveedor 
		SET
		idtipoproveedor='$idtipoproveedor',
		idzona='$idzona',
		idoperacion='$idoperacion',
		cod_proveedor='$cod_proveedor',
		desc_proveedor='$desc_proveedor',
		rif='$rif',
		direccion ='$direccion',
		ciudad = '$ciudad',
		codpostal ='$codpostal',
		contacto ='$contacto',
		telefono ='$telefono',
		movil= '$movil',
		email ='$email',
		web ='$web',
		diascredito = '$diascredito',
		limite ='$limite',
		montofiscal='$montofiscal,',
		fechareg='$fechareg',
		aplicacredito='$aplicacredito',
		aplicareten='$aplicareten',
		saldo='$saldo'
		WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idproveedor)
	{
		$sql="DELETE 
		FROM tbproveedor 
		WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idproveedor)
	{
		$sql="UPDATE 
		tbproveedor 
		SET 
		estatus='0' 
		WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idproveedor)
	{
		$sql="UPDATE 
		tbproveedor 
		SET 
		estatus='1' 
		WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idproveedor)
	{
		$sql="SELECT 
		pv.idproveedor,
		pv.idtipoproveedor,
		pv.idzona,
		pv.idoperacion,
		t.cod_tipoproveedor,
		t.desc_tipoproveedor,
		op.cod_operacion,
		op.desc_operacion,
		pv.cod_proveedor,
		pv.desc_proveedor,
		pv.rif,
		pv.direccion,
		pv.ciudad,
		pv.codpostal,
		pv.contacto,
		pv.telefono,
		pv.movil,
		pv.email,
		pv.web,
		CONVERT(pv.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(pv.limite,DECIMAL(12,2)) AS limite,
		CONVERT(pv.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(pv.montofiscal,DECIMAL(12,0)) AS montofiscal,
		pv.fechareg,
		pv.aplicacredito,
		pv.aplicareten,
		pv.estatus 
		FROM tbproveedor pv
		INNER JOIN tbtipoproveedor t ON t.idtipoproveedor = pv.idtipoproveedor
		INNER JOIN tboperacion op ON op.idoperacion = pv.idoperacion
		WHERE idproveedor='$idproveedor'";
		return ejecutarConsultaSimpleFila($sql);

	}

	//Implementar un método para mostrar los datos
	public function mostrarcontacto($idproveedor)
	{
		$sql="SELECT * FROM tbproveedor WHERE idproveedor='$idproveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}
		
	public function mostrarsaldo($idproveedor)
	{
		$sql="SELECT 
		pv.idproveedor,
		pv.idtipoproveedor,
		pv.idzona,
		pv.idoperacion,
		t.cod_tipoproveedor,
		t.desc_tipoproveedor,
		op.cod_operacion,
		op.desc_operacion,
		pv.cod_proveedor,
		pv.desc_proveedor,
		pv.rif,
		pv.direccion,
		pv.ciudad,
		pv.codpostal,
		pv.contacto,
		pv.telefono,
		pv.movil,
		pv.email,
		pv.web,
		CONVERT(pv.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(pv.limite,DECIMAL(12,2)) AS limite,
		CONVERT(pv.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(pv.montofiscal,DECIMAL(12,0)) AS montofiscal,
		pv.fechareg,
		pv.aplicacredito,
		pv.aplicareten,
		pv.estatus 
		FROM tbproveedor pv
		INNER JOIN tbtipoproveedor t ON t.idtipoproveedor = pv.idtipoproveedor
		INNER JOIN tboperacion op ON op.idoperacion = pv.idoperacion
		WHERE idproveedor='$idproveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		pv.idproveedor,
		pv.idtipoproveedor,
		pv.idzona,
		pv.idoperacion,
		t.cod_tipoproveedor,
		t.desc_tipoproveedor,
		op.cod_operacion,
		op.desc_operacion,
		pv.cod_proveedor,
		pv.desc_proveedor,
		pv.rif,
		pv.direccion,
		pv.ciudad,
		pv.codpostal,
		pv.contacto,
		pv.telefono,
		pv.movil,
		pv.email,
		pv.web,
		CONVERT(pv.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(pv.limite,DECIMAL(12,2)) as limite,
		CONVERT(pv.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(pv.montofiscal,DECIMAL(12,0)) AS montofiscal,
		pv.fechareg,
		pv.aplicacredito,
		pv.aplicareten,
		pv.estatus 
		FROM tbproveedor pv
		INNER JOIN tbtipoproveedor t ON t.idtipoproveedor = pv.idtipoproveedor
		INNER JOIN tboperacion op ON op.idoperacion = pv.idoperacion";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{	
		$sql="SELECT 
		pv.idproveedor,
		pv.idtipoproveedor,
		pv.idzona,
		pv.idoperacion,
		t.cod_tipoproveedor,
		t.desc_tipoproveedor,
		op.cod_operacion,
		op.desc_operacion,
		pv.cod_proveedor,
		pv.desc_proveedor,
		pv.rif,
		pv.direccion,
		pv.ciudad,
		pv.codpostal,
		pv.contacto,
		pv.telefono,
		pv.movil,
		pv.email,
		pv.web,
		CONVERT(pv.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(pv.limite,DECIMAL(12,2)) as limite,
		CONVERT(pv.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(pv.montofiscal,DECIMAL(12,0)) AS montofiscal,
		pv.fechareg,
		pv.aplicacredito,
		pv.aplicareten,
		pv.estatus 
		FROM tbproveedor pv
		INNER JOIN tbtipoproveedor t ON t.idtipoproveedor = pv.idtipoproveedor
		INNER JOIN tboperacion op ON op.idoperacion = pv.idoperacion
		WHERE pv.estatus='1'";
		return ejecutarConsulta($sql);		
	}	
		
}
?>