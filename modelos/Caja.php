<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Caja
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idmoneda,$cod_caja,$desc_caja,$fechareg)
	{
		$sql="INSERT INTO tbcaja (idmoneda,cod_caja,desc_caja,fechareg,estatus)
		VALUES ('$idmoneda','$cod_caja','$desc_caja','$fechareg','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcaja,$idmoneda,$cod_caja,$desc_caja, $fechareg)
	{
		$sql="UPDATE tbcaja 
		SET
		idmoneda='$idmoneda',
		cod_caja='$cod_caja',
		desc_caja='$desc_caja',
		fechareg='$fechareg'
		WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idcaja)
	{
		$sql="DELETE 
		FROM tbcaja 
		WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idcaja)
	{
		$sql="UPDATE 
		tbcaja 
		SET 
		estatus='0' 
		WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcaja)
	{
		$sql="UPDATE 
		tbcaja 
		SET 
		estatus='1' 
		WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcaja)
	{
		$sql="SELECT 
		c.idcaja,
		c.idmoneda,
		c.cod_caja,
		c.desc_caja,
		m.cod_moneda,
		m.desc_moneda,
		CONVERT(c.saldoefectivo,DECIMAL(12,2)) AS saldoefectivo,
		CONVERT(c.saldodocumento,DECIMAL(12,2)) AS saldodocumento,
		CONVERT(c.saldototal,DECIMAL(12,2)) AS saldototal,
		c.fechareg,
		c.estatus 
		FROM
		tbcaja c
		INNER JOIN tbmoneda m ON m.idmoneda=c.idmoneda
		WHERE c.idcaja='$idcaja'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		c.idcaja,
		c.idmoneda,
		c.cod_caja,
		c.desc_caja,
		m.cod_moneda,
		m.desc_moneda,
		CONVERT(c.saldoefectivo,DECIMAL(12,2)) AS saldoefectivo,
		CONVERT(c.saldodocumento,DECIMAL(12,2)) AS saldodocumento,
		CONVERT(c.saldototal,DECIMAL(12,2)) AS saldototal,
		DATE_FORMAT(c.fechareg,'%d-%m-%Y') AS fechareg,
		c.estatus 
		FROM
		tbcaja c
		INNER JOIN tbmoneda m ON m.idmoneda=c.idmoneda";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		c.idcaja,
		c.idmoneda,
		c.cod_caja,
		c.desc_caja,
		m.cod_moneda,
		m.desc_moneda,
		CONVERT(c.saldoefectivo,DECIMAL(12,2)) AS saldoefectivo,
		CONVERT(c.saldodocumento,DECIMAL(12,2)) AS saldodocumento,
		CONVERT(c.saldototal,DECIMAL(12,2)) AS saldototal,
		c.fechareg,
		c.estatus 
		FROM
		tbcaja c
		INNER JOIN tbmoneda m ON m.idmoneda=c.idmoneda WHERE estatus='1'
		ORDER BY cod_caja ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function rptListar($buscar1=null,$buscar2=null)
	{
		$sql="SELECT 
		c.idcaja,
		c.idmoneda,
		c.cod_caja,
		c.desc_caja,
		m.cod_moneda,
		m.desc_moneda,
		CONVERT(c.saldoefectivo,DECIMAL(12,2)) AS saldoefectivo,
		CONVERT(c.saldodocumento,DECIMAL(12,2)) AS saldodocumento,
		CONVERT(c.saldototal,DECIMAL(12,2)) AS saldototal,
		c.fechareg,
		c.estatus 
		FROM
		tbcaja c
		INNER JOIN tbmoneda m ON m.idmoneda=c.idmoneda
		ORDER BY cod_caja ASC";
		return ejecutarConsulta($sql);		
	}
}
?>