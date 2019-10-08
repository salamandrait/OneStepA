<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Pais
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idmoneda,$cod_pais,$desc_pais)
	{
		$sql="INSERT 
		INTO tbpais (idmoneda,cod_pais,desc_pais)
		VALUES ('$idmoneda','$cod_pais','$desc_pais)";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idpais,$idmoneda,$cod_pais,$desc_pais)
	{
		$sql="UPDATE 
		tbpais 
		SET
		idmoneda='$idmoneda',
		cod_pais='$cod_pais',
		desc_pais='$desc_pais'
		WHERE idpais='$idpais'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idpais)
	{
		$sql="DELETE 
		FROM tbpais 
		WHERE idpais='$idpais'";
		return ejecutarConsulta($sql);
	}



	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpais)
	{
		$sql="SELECT 
		p.idpais,
		p.idmoneda,
		p.cod_pais, 
		p.desc_pais,
		m.cod_moneda,
		m.desc_moneda
		FROM 
		tbpais p 
		INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda 
		WHERE p.idpais='$idpais'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		p.idpais,
		p.idmoneda,
		p.cod_pais, 
		p.desc_pais,
		m.cod_moneda,
		m.desc_moneda
		FROM 
		tbpais p 
		INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		p.idpais,
		p.idmoneda,
		p.cod_pais, 
		p.desc_pais,
		m.cod_moneda,
		m.desc_moneda
		FROM tbpais p 
		INNER JOIN tbmoneda m ON m.idmoneda=p.idmoneda
		ORDER BY cod_pais ASC";
		return ejecutarConsulta($sql);		
	}
}
?>