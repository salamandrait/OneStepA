<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Zona
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_zona,$desc_zona)
	{
		$sql="INSERT 
		INTO tbzona (cod_zona,desc_zona,estatus)
		VALUES ('$cod_zona','$desc_zona','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idzona,$cod_zona,$desc_zona)
	{
		$sql="UPDATE 
		tbzona 
		SET 
		cod_zona='$cod_zona',
		desc_zona='$desc_zona'
		WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idzona)
	{
		$sql="DELETE 
		FROM tbzona 
		WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idzona)
	{
		$sql="UPDATE 
		tbzona 
		SET 
		estatus='0' 
		WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idzona)
	{
		$sql="UPDATE 
		tbzona 
		SET 
		estatus='1' 
		WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idzona)
	{
		$sql="SELECT 
		idzona, 
		cod_zona, 
		desc_zona,
		estatus
		FROM tbzona 
		WHERE idzona='$idzona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idzona, 
		cod_zona, 
		desc_zona,
		estatus
		FROM tbzona";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idzona, 
		cod_zona, 
		desc_zona,
		estatus
		FROM tbzona WHERE estatus='1'
		ORDER BY cod_zona ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function rptListar()
	{
		$sql="SELECT 
		idzona, 
		cod_zona, 
		desc_zona,
		estatus
		FROM tbzona
		ORDER BY cod_zona ASC";
		return ejecutarConsulta($sql);		
	}
}
?>