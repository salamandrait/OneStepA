<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Moneda
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_moneda,$desc_moneda)
	{
		$sql="INSERT 
		INTO tbmoneda (cod_moneda,desc_moneda,estatus)
		VALUES ('$cod_moneda','$desc_moneda','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idmoneda,$cod_moneda,$desc_moneda)
	{
		$sql="UPDATE 
		tbmoneda 
		SET 
		cod_moneda='$cod_moneda',
		desc_moneda='$desc_moneda'
		WHERE idmoneda='$idmoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idmoneda)
	{
		$sql="DELETE 
		FROM tbmoneda 
		WHERE idmoneda='$idmoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idmoneda)
	{
		$sql="UPDATE 
		tbmoneda 
		SET 
		estatus='0' 
		WHERE idmoneda='$idmoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idmoneda)
	{
		$sql="UPDATE 
		tbmoneda 
		SET 
		estatus='1' 
		WHERE idmoneda='$idmoneda'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idmoneda)
	{
		$sql="SELECT 
		idmoneda, 
		cod_moneda, 
		desc_moneda,
		estatus
		FROM tbmoneda 
		WHERE idmoneda='$idmoneda'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idmoneda, 
		cod_moneda, 
		desc_moneda,
		estatus
		FROM tbmoneda";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idmoneda, 
		cod_moneda, 
		desc_moneda,
		estatus
		FROM tbmoneda WHERE estatus='1'
		ORDER BY cod_moneda ASC";
		return ejecutarConsulta($sql);		
	}
}
?>