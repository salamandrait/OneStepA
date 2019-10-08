<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Banco
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idmoneda, $cod_banco,$desc_banco,$telefono,$plazo1,$plazo2)
	{
		$sql="INSERT INTO tbbanco (idmoneda,cod_banco,desc_banco,telefono,plazo1,plazo2,estatus)
		VALUES ('$idmoneda','$cod_banco','$desc_banco','$telefono','$plazo1','$plazo2','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idbanco, $idmoneda,$cod_banco,$desc_banco,$telefono,$plazo1,$plazo2)
	{
		$sql="UPDATE tbbanco 
		SET
		idmoneda='$idmoneda',
		cod_banco='$cod_banco',
		desc_banco='$desc_banco',
		telefono='$telefono',
		plazo1='$plazo1',
		plazo2='$plazo2'
		WHERE idbanco='$idbanco'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idbanco)
	{
		$sql="DELETE 
		FROM tbbanco 
		WHERE idbanco='$idbanco'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idbanco)
	{
		$sql="UPDATE 
		tbbanco 
		SET 
		estatus='0' 
		WHERE idbanco='$idbanco'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idbanco)
	{
		$sql="UPDATE 
		tbbanco 
		SET 
		estatus='1' 
		WHERE idbanco='$idbanco'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idbanco)
	{
		$sql="SELECT 
		b.idbanco,
		b.idmoneda,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		b.telefono,
		b.plazo1,
		b.plazo2,
		b.estatus 
		FROM tbbanco b
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda
		WHERE b.idbanco='$idbanco'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		b.idbanco,
		b.idmoneda,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		b.telefono,
		b.plazo1,
		b.plazo2,
		b.estatus 
		FROM tbbanco b
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		b.idbanco,
		b.idmoneda,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		b.telefono,
		b.plazo1,
		b.plazo2,
		b.estatus 
		FROM tbbanco b
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda WHERE b.estatus='1'
		ORDER BY cod_banco ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function rptListar()
	{
		$sql="SELECT 
		b.idbanco,
		b.idmoneda,
		b.cod_banco,
		b.desc_banco,
		m.cod_moneda,
		m.desc_moneda,
		b.telefono,
		b.plazo1,
		b.plazo2,
		b.estatus 
		FROM tbbanco b
		INNER JOIN tbmoneda m ON m.idmoneda=b.idmoneda";
		return ejecutarConsulta($sql);		
	}
}
?>