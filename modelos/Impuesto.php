<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Impuesto
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_impuesto,$desc_impuesto,$tasa)
	{
		$sql="INSERT 
		INTO tbimpuesto (cod_impuesto,desc_impuesto,tasa,estatus)
		VALUES ('$cod_impuesto','$desc_impuesto','$tasa','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idimpuesto,$cod_impuesto,$desc_impuesto,$tasa)
	{
		$sql="UPDATE 
		tbimpuesto 
		SET 
		cod_impuesto='$cod_impuesto',
		desc_impuesto='$desc_impuesto',
		tasa='$tasa'
		WHERE idimpuesto='$idimpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idimpuesto)
	{
		$sql="DELETE 
		FROM tbimpuesto 
		WHERE idimpuesto='$idimpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idimpuesto)
	{
		$sql="UPDATE 
		tbimpuesto 
		SET 
		estatus='0' 
		WHERE idimpuesto='$idimpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idimpuesto)
	{
		$sql="UPDATE 
		tbimpuesto 
		SET 
		estatus='1' 
		WHERE idimpuesto='$idimpuesto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idimpuesto)
	{
		$sql="SELECT 
		idimpuesto, 
		cod_impuesto, 
		desc_impuesto,
		CONVERT(tasa,DECIMAL(13,0)) AS tasa,
		estatus
		FROM tbimpuesto 
		WHERE idimpuesto='$idimpuesto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idimpuesto, 
		cod_impuesto, 
		desc_impuesto,
		CONVERT(tasa,DECIMAL(13,0)) AS tasa,
		estatus
		FROM tbimpuesto";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idimpuesto, 
		cod_impuesto, 
		desc_impuesto,
		CONVERT(tasa,DECIMAL(13,0)) AS tasa,
		estatus
		FROM tbimpuesto WHERE estatus='1'";
		return ejecutarConsulta($sql);		
	}
}
?>