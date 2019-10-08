<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Correlativo
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($desc_correlativo,$grupo,$tabla,$precadena,$cadena,$cod_num,$largo)
	{
		$sql="INSERT 
		INTO tbcorrelativo (desc_correlativo,grupo,tabla,precadena,cadena,cod_num,largo,estatus)
		VALUES ('$desc_correlativo','$grupo','$tabla','$precadena','$cadena','$cod_num','$largo','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcorrelativo,$precadena,$cadena,$cod_num,$largo)
	{
		$sql="UPDATE 
		tbcorrelativo 
		SET 
		precadena ='$precadena',
		cadena = '$cadena',
		cod_num = '$cod_num',
		largo = '$largo'
		WHERE idcorrelativo='$idcorrelativo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idcorrelativo)
	{
		$sql="DELETE 
		FROM tbcorrelativo 
		WHERE idcorrelativo='$idcorrelativo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idcorrelativo)
	{
		$sql="UPDATE 
		tbcorrelativo 
		SET 
		estatus='0' 
		WHERE idcorrelativo='$idcorrelativo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idcorrelativo)
	{
		$sql="UPDATE 
		tbcorrelativo 
		SET 
		estatus='1' 
		WHERE idcorrelativo='$idcorrelativo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcorrelativo)
	{
		$sql="SELECT 
		idcorrelativo,
		desc_correlativo,
		grupo,
		tabla,
		precadena,
		cadena,
		cod_num,
		largo,
		estatus 
		FROM tbcorrelativo 
		WHERE idcorrelativo='$idcorrelativo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idcorrelativo,
		desc_correlativo,
		grupo,
		tabla,
		precadena,
		REPEAT(cadena,largo) AS cadena,
		CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS cod_num,
		largo,
		estatus 
		FROM tbcorrelativo";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idcorrelativo,
		desc_correlativo,
		grupo,
		tabla,
		precadena,
		REPEAT(cadena,largo) AS cadena,
		RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo) AS cod_num,
		largo,
		estatus 
		FROM tbcorrelativo 
		WHERE estatus='1'";
		return ejecutarConsulta($sql);		
	}
}
?>