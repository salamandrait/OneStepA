<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Unidad
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_unidad,$desc_unidad)
	{
		$sql="INSERT 
		INTO tbunidad (cod_unidad,desc_unidad,estatus)
		VALUES ('$cod_unidad','$desc_unidad','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idunidad,$cod_unidad,$desc_unidad)
	{
		$sql="UPDATE 
		tbunidad 
		SET 
		cod_unidad='$cod_unidad',
		desc_unidad='$desc_unidad'
		WHERE idunidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idunidad)
	{
		$sql="DELETE 
		FROM tbunidad 
		WHERE idunidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idunidad)
	{
		$sql="UPDATE 
		tbunidad 
		SET 
		estatus='0' 
		WHERE idunidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idunidad)
	{
		$sql="UPDATE 
		tbunidad 
		SET 
		estatus='1' 
		WHERE idunidad='$idunidad'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idunidad)
	{
		$sql="SELECT 
		idunidad, 
		cod_unidad, 
		desc_unidad,
		estatus
		FROM tbunidad 
		WHERE idunidad='$idunidad'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idunidad, 
		cod_unidad, 
		desc_unidad,
		estatus
		FROM tbunidad";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idunidad, 
		cod_unidad, 
		desc_unidad,
		estatus
		FROM tbunidad WHERE estatus='1'
		ORDER BY cod_unidad ASC";
		return ejecutarConsulta($sql);		
	}

		//Implementar un método para listar los registros
	public function rptListar()
	{
		$sql="SELECT 
		idunidad, 
		cod_unidad, 
		desc_unidad,
		estatus
		FROM tbunidad
		ORDER BY cod_unidad ASC";
		return ejecutarConsulta($sql);		
	}
}
?>