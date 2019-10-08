<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoProveedor
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_tipoproveedor,$desc_tipoproveedor)
	{
		$sql="INSERT 
		INTO tbtipoproveedor (cod_tipoproveedor,desc_tipoproveedor,estatus)
		VALUES ('$cod_tipoproveedor','$desc_tipoproveedor','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idtipoproveedor,$cod_tipoproveedor,$desc_tipoproveedor)
	{
		$sql="UPDATE 
		tbtipoproveedor 
		SET 
		cod_tipoproveedor='$cod_tipoproveedor',
		desc_tipoproveedor='$desc_tipoproveedor'
		WHERE idtipoproveedor='$idtipoproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idtipoproveedor)
	{
		$sql="DELETE 
		FROM tbtipoproveedor 
		WHERE idtipoproveedor='$idtipoproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idtipoproveedor)
	{
		$sql="UPDATE 
		tbtipoproveedor 
		SET 
		estatus='0' 
		WHERE idtipoproveedor='$idtipoproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idtipoproveedor)
	{
		$sql="UPDATE 
		tbtipoproveedor 
		SET 
		estatus='1' 
		WHERE idtipoproveedor='$idtipoproveedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idtipoproveedor)
	{
		$sql="SELECT 
		idtipoproveedor, 
		cod_tipoproveedor, 
		desc_tipoproveedor,
		estatus
		FROM tbtipoproveedor 
		WHERE idtipoproveedor='$idtipoproveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idtipoproveedor, 
		cod_tipoproveedor, 
		desc_tipoproveedor,
		estatus
		FROM tbtipoproveedor";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idtipoproveedor, 
		cod_tipoproveedor, 
		desc_tipoproveedor,
		estatus
		FROM tbtipoproveedor WHERE estatus='1'
		ORDER BY cod_tipoproveedor ASC";
		return ejecutarConsulta($sql);		
	}

	public function rptListar()
	{
		$sql="SELECT 
		idtipoproveedor, 
		cod_tipoproveedor, 
		desc_tipoproveedor,
		estatus
		FROM tbtipoproveedor
		ORDER BY cod_tipoproveedor ASC";
		return ejecutarConsulta($sql);		
	}
}
?>