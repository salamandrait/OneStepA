<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cuenta
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,
	$direccion,$telefono,$email,$saldod,$saldoh,$saldot,$fechareg)
	{
		$sql="INSERT INTO tbcuenta (idbanco,cod_cuenta,desc_cuenta,tipo,numcuenta,agencia,ejecutivo,
		direccion,telefono,email,saldod,saldoh,saldot,fechareg,estatus)
		VALUES ('$idbanco','$cod_cuenta','$desc_cuenta','$tipo','$numcuenta','$agencia','$ejecutivo',
		'$direccion','$telefono','$email','$saldod','$saldoh','$saldot','$fechareg','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcuenta,$idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,
	$direccion,$telefono,$email,$saldod,$saldoh,$saldot,$fechareg)
	{
		$sql="UPDATE tbcuenta 
		SET 
		idbanco='$idbanco',
		cod_cuenta='$cod_cuenta',
		desc_cuenta='$desc_cuenta',
		tipo='$tipo',
		numcuenta='$numcuenta',
		agencia='$agencia',
		ejecutivo='$ejecutivo',
		direccion='$direccion',
		telefono='$telefono',
		email='$email',
		saldod='$saldod',
		saldoh='$saldoh',
		saldot='$saldot',
		fechareg='$fechareg'
		WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idcuenta)
	{
		$sql="DELETE 
		FROM tbcuenta 
		WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idcuenta)
	{
		$sql="UPDATE 
		tbcuenta 
		SET 
		estatus='0' 
		WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcuenta)
	{
		$sql="UPDATE 
		tbcuenta 
		SET 
		estatus='1' 
		WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcuenta)
	{
		$sql="SELECT
		c.idcuenta,
		c.idbanco,
		c.cod_cuenta,
		c.desc_cuenta,
		c.tipo,
		c.numcuenta,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		c.agencia,
		c.ejecutivo,
		c.direccion,
		c.telefono,
		c.email,
		CONVERT(c.saldod,DECIMAL(12,2)) AS saldod,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		CONVERT(c.saldot,DECIMAL(12,2)) AS saldot,
		c.fechareg,
		c.estatus
		FROM tbcuenta c
		INNER JOIN tbbanco b ON b.idbanco=c.idbanco
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
		WHERE c.idcuenta='$idcuenta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT
		c.idcuenta,
		c.idbanco,
		c.cod_cuenta,
		c.desc_cuenta,
		c.tipo,
		c.numcuenta,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		c.agencia,
		c.ejecutivo,
		c.direccion,
		c.telefono,
		c.email,
		CONVERT(c.saldod,DECIMAL(12,2)) AS saldod,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		CONVERT(c.saldot,DECIMAL(12,2)) AS saldot,
		DATE_FORMAT(c.fechareg,'%d-%m-%Y') AS fechareg,
		c.estatus
		FROM tbcuenta c
		INNER JOIN tbbanco b ON b.idbanco=c.idbanco
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT
		c.idcuenta,
		c.idbanco,
		c.cod_cuenta,
		c.desc_cuenta,
		c.tipo,
		c.numcuenta,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		c.agencia,
		c.ejecutivo,
		c.direccion,
		c.telefono,
		c.email,
		CONVERT(c.saldod,DECIMAL(12,2)) AS saldod,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		CONVERT(c.saldot,DECIMAL(12,2)) AS saldot,
		c.fechareg,
		c.estatus
		FROM tbcuenta c
		INNER JOIN tbbanco b ON b.idbanco=c.idbanco
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
		WHERE c.estatus='1' ORDER BY cod_cuenta ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function rptListar()
	{
		$sql="SELECT
		c.idcuenta,
		c.idbanco,
		c.cod_cuenta,
		c.desc_cuenta,
		c.tipo,
		c.numcuenta,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		c.agencia,
		c.ejecutivo,
		c.direccion,
		c.telefono,
		c.email,
		CONVERT(c.saldod,DECIMAL(12,2)) AS saldod,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		CONVERT(c.saldot,DECIMAL(12,2)) AS saldot,
		DATE_FORMAT(c.fechareg,'%d-%m-%Y') AS fechareg,
		c.estatus
		FROM tbcuenta c
		INNER JOIN tbbanco b ON b.idbanco=c.idbanco
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda";
		return ejecutarConsulta($sql);		
	}
}
?>