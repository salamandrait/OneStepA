<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cliente
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idvendedor,$idtipocliente,$idzona,$idoperacion,$cod_cliente,
	$desc_cliente,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$diascredito,
	$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo)
	{
		$sql="INSERT INTO tbcliente (idvendedor,idtipocliente,idzona,idoperacion,cod_cliente,desc_cliente,
		rif,direccion,ciudad,codpostal,contacto,telefono,movil,email,web,diascredito,limite,montofiscal,
		fechareg,aplicacredito,aplicareten,saldo,estatus)
		VALUES ('$idvendedor','$idtipocliente','$idzona','$idoperacion','$cod_cliente','$desc_cliente',
		'$rif','$direccion','$ciudad','$codpostal','$contacto','$telefono','$movil','$email','$web','$diascredito',
		'$limite','$montofiscal','$fechareg','$aplicacredito','$aplicareten','$saldo','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcliente,$idvendedor,$idtipocliente,$idzona,$idoperacion,$cod_cliente,
	$desc_cliente,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,$diascredito,
	$limite,$montofiscal,$fechareg,$aplicacredito,$aplicareten,$saldo)
	{
		$sql="UPDATE 
		tbcliente 
		SET
		idvendedor='$idvendedor',
		idtipocliente='$idtipocliente',
		idzona='$idzona',
		idoperacion='$idoperacion',
		cod_cliente='$cod_cliente',
		desc_cliente='$desc_cliente',
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
		saldo='$saldo',
		aplicareten='$aplicareten'
		WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idcliente)
	{
		$sql="DELETE 
		FROM tbcliente 
		WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idcliente)
	{
		$sql="UPDATE 
		tbcliente 
		SET 
		estatus='0' 
		WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcliente)
	{
		$sql="UPDATE 
		tbcliente 
		SET 
		estatus='1' 
		WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcliente)
	{
		$sql="SELECT 
		cl.idcliente,
		cl.idzona,
		cl.idoperacion,
		cl.idvendedor,
		t.cod_tipocliente,
		t.desc_tipocliente,
		op.cod_operacion,
		op.desc_operacion,
		v.cod_vendedor,
		v.desc_vendedor,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		cl.direccion,
		cl.ciudad,
		cl.codpostal,
		cl.contacto,
		cl.telefono,
		cl.movil,
		cl.email,
		cl.web,
		CONVERT(cl.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(cl.limite,DECIMAL(12,2)) AS limite,
		CONVERT(cl.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(cl.montofiscal,DECIMAL(12,0)) AS montofiscal,
		cl.fechareg,
		cl.aplicacredito,
		cl.aplicareten,
		cl.estatus 
		FROM tbcliente cl
		INNER JOIN tbvendedor v ON v.idvendedor = cl.idvendedor
		INNER JOIN tbtipocliente t ON t.idtipocliente = cl.idtipocliente
		INNER JOIN tboperacion op ON op.idoperacion = cl.idoperacion
		WHERE idcliente='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);

	}

	//Implementar un método para mostrar los datos
	public function mostrarcontacto($idcliente)
	{
		$sql="SELECT * FROM tbcliente WHERE idcliente='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);
	}
		
	public function mostrarsaldo($idcliente)
	{
		$sql="SELECT 
		cl.idcliente,
		cl.idtipocliente,
		cl.idzona,
		cl.idoperacion,
		cl.idvendedor,
		t.cod_tipocliente,
		t.desc_tipocliente,
		op.cod_operacion,
		op.desc_operacion,
		v.cod_vendedor,
		v.desc_vendedor,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		cl.direccion,
		cl.ciudad,
		cl.codpostal,
		cl.contacto,
		cl.telefono,
		cl.movil,
		cl.email,
		cl.web,
		CONVERT(cl.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(cl.limite,DECIMAL(12,2)) AS limite,
		CONVERT(cl.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(cl.montofiscal,DECIMAL(12,0)) AS montofiscal,
		cl.fechareg,
		cl.aplicacredito,
		cl.aplicareten,
		cl.estatus 
		FROM tbcliente cl
		INNER JOIN tbvendedor v ON v.idvendedor = cl.idvendedor
		INNER JOIN tbtipocliente t ON t.idtipocliente = cl.idtipocliente
		INNER JOIN tboperacion op ON op.idoperacion = cl.idoperacion
		WHERE idcliente='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		cl.idcliente,
		cl.idtipocliente,
		cl.idzona,
		cl.idoperacion,
		cl.idvendedor,
		t.cod_tipocliente,
		t.desc_tipocliente,
		op.cod_operacion,
		op.desc_operacion,
		v.cod_vendedor,
		v.desc_vendedor,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		cl.direccion,
		cl.ciudad,
		cl.codpostal,
		cl.contacto,
		cl.telefono,
		cl.movil,
		cl.email,
		cl.web,
		CONVERT(cl.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(cl.limite,DECIMAL(12,2)) as limite,
		CONVERT(cl.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(cl.montofiscal,DECIMAL(12,0)) AS montofiscal,
		cl.fechareg,
		cl.aplicacredito,
		cl.aplicareten,
		cl.estatus		
		FROM tbcliente cl
		INNER JOIN tbvendedor v ON v.idvendedor = cl.idvendedor
		INNER JOIN tbtipocliente t ON t.idtipocliente = cl.idtipocliente
		INNER JOIN tboperacion op ON op.idoperacion = cl.idoperacion";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{	
		$sql="SELECT 
		cl.idcliente,
		cl.idtipocliente,
		cl.idzona,
		cl.idoperacion,
		cl.idvendedor,
		t.cod_tipocliente,
		t.desc_tipocliente,
		op.cod_operacion,
		op.desc_operacion,
		v.cod_vendedor,
		v.desc_vendedor,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		cl.direccion,
		cl.ciudad,
		cl.codpostal,
		cl.contacto,
		cl.telefono,
		cl.movil,
		cl.email,
		cl.web,
		CONVERT(cl.diascredito,DECIMAL(12,0)) AS diascredito,
		CONVERT(cl.limite,DECIMAL(12,2)) as limite,
		CONVERT(cl.saldo,DECIMAL(12,2)) AS saldo,
		CONVERT(cl.montofiscal,DECIMAL(12,0)) AS montofiscal,
		cl.fechareg,
		cl.aplicacredito,
		cl.aplicareten,
		cl.estatus 
		FROM tbcliente cl
		INNER JOIN tbtipocliente t ON t.idtipocliente = cl.idtipocliente
		INNER JOIN tboperacion op ON op.idoperacion = cl.idoperacion
		INNER JOIN tbvendedor v ON v.idvendedor = cl.idvendedor
		WHERE cl.estatus='1'";
		return ejecutarConsulta($sql);		
	}	
		
}
?>