<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Acceso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbacceso"; 
		return ejecutarConsulta($sql);		
	}

	public function listarModulo($modulo)
	{
		$sql="SELECT * FROM tbacceso WHERE modulo='$modulo'
		ORDER BY idacceso ASC"; 
		return ejecutarConsulta($sql);		
	}
}

?>