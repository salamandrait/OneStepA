<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TipoCliente
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_tipocliente,$desc_tipocliente)
	{
		$sql="INSERT 
		INTO tbtipocliente (cod_tipocliente,desc_tipocliente,estatus)
		VALUES ('$cod_tipocliente','$desc_tipocliente','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idtipocliente,$cod_tipocliente,$desc_tipocliente)
	{
		$sql="UPDATE 
		tbtipocliente 
		SET 
		cod_tipocliente='$cod_tipocliente',
		desc_tipocliente='$desc_tipocliente'
		WHERE idtipocliente='$idtipocliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idtipocliente)
	{
		$sql="DELETE 
		FROM tbtipocliente 
		WHERE idtipocliente='$idtipocliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idtipocliente)
	{
		$sql="UPDATE 
		tbtipocliente 
		SET 
		estatus='0' 
		WHERE idtipocliente='$idtipocliente'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idtipocliente)
	{
		$sql="UPDATE 
		tbtipocliente 
		SET 
		estatus='1' 
		WHERE idtipocliente='$idtipocliente'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idtipocliente)
	{
		$sql="SELECT 
		idtipocliente, 
		cod_tipocliente, 
		desc_tipocliente,
		estatus
		FROM tbtipocliente 
		WHERE idtipocliente='$idtipocliente'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idtipocliente, 
		cod_tipocliente, 
		desc_tipocliente,
		estatus
		FROM tbtipocliente";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idtipocliente, 
		cod_tipocliente, 
		desc_tipocliente,
		estatus
		FROM tbtipocliente WHERE estatus='1'
		ORDER BY cod_tipocliente ASC";
		return ejecutarConsulta($sql);	
			
	}

		//Implementar un método para listar los registros y mostrar en el select
		public function rptListar()
		{
			$sql="SELECT 
			idtipocliente, 
			cod_tipocliente, 
			desc_tipocliente,
			estatus
			FROM tbtipocliente
			ORDER BY cod_tipocliente ASC";
			return ejecutarConsulta($sql);	
				
		}
}
?>