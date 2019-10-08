<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Categoria
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_categoria,$desc_categoria)
	{
		$sql="INSERT 
		INTO tbcategoria (cod_categoria,desc_categoria,estatus)
		VALUES ('$cod_categoria','$desc_categoria','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcategoria,$cod_categoria,$desc_categoria)
	{
		$sql="UPDATE 
		tbcategoria 
		SET 
		cod_categoria='$cod_categoria',
		desc_categoria='$desc_categoria'
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idcategoria)
	{
		$sql="DELETE 
		FROM tbcategoria 
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idcategoria)
	{
		$sql="UPDATE 
		tbcategoria 
		SET 
		estatus='0' 
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcategoria)
	{
		$sql="UPDATE 
		tbcategoria 
		SET 
		estatus='1' 
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcategoria)
	{
		$sql="SELECT 
		idcategoria, 
		cod_categoria, 
		desc_categoria,
		estatus
		FROM tbcategoria 
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idcategoria, 
		cod_categoria, 
		desc_categoria,
		estatus
		FROM tbcategoria";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idcategoria, 
		cod_categoria, 
		desc_categoria,
		estatus
		FROM tbcategoria WHERE estatus='1'
		ORDER BY cod_categoria ASC";
		return ejecutarConsulta($sql);		
	}

	public function rptListar()
	{
		$sql="SELECT 
		idcategoria, 
		cod_categoria, 
		desc_categoria,
		estatus
		FROM tbcategoria
		ORDER BY cod_categoria ASC";
		return ejecutarConsulta($sql);		
	}
}
?>