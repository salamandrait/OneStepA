<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Vendedor
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_vendedor,$desc_vendedor,$rif, $direccion,$fechareg, $comisionv, $comisionc, $esvendedor, $escobrador)
	{
		$sql="INSERT INTO tbvendedor 
		(cod_vendedor,desc_vendedor,rif,direccion,fechareg,comisionv,comisionc,esvendedor,escobrador,estatus)
		VALUES 
		('$cod_vendedor','$desc_vendedor','$rif','$direccion','$fechareg','$comisionv','$comisionc','$esvendedor','$escobrador','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idvendedor,$cod_vendedor,$desc_vendedor,$rif,$direccion,$fechareg, $comisionv, $comisionc, $esvendedor, $escobrador)
	{
		$sql="UPDATE tbvendedor 
		SET 
		cod_vendedor='$cod_vendedor',
		desc_vendedor='$desc_vendedor',
		rif='$rif',
		direccion='$direccion',
		fechareg='$fechareg', 
		comisionv='$comisionv', 
		comisionc='$comisionc', 
		esvendedor='$esvendedor', 
		escobrador='$escobrador'
		WHERE idvendedor='$idvendedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idvendedor)
	{
		$sql="DELETE 
		FROM tbvendedor 
		WHERE idvendedor='$idvendedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idvendedor)
	{
		$sql="UPDATE 
		tbvendedor 
		SET 
		estatus='0' 
		WHERE idvendedor='$idvendedor'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idvendedor)
	{
		$sql="UPDATE 
		tbvendedor 
		SET 
		estatus='1' 
		WHERE idvendedor='$idvendedor'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idvendedor)
	{
		$sql="SELECT 
		idvendedor, 
		cod_vendedor,
		desc_vendedor,
		rif,
		direccion,
		fechareg, 
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
		FROM tbvendedor 
		WHERE idvendedor='$idvendedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		idvendedor, 
		cod_vendedor,
		desc_vendedor,
		rif,
		direccion,
		fechareg, 
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
		FROM tbvendedor";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		idvendedor, 
		cod_vendedor,
		desc_vendedor,
		rif,
		direccion,
		fechareg, 
		comisionv, 
		comisionc, 
		esvendedor, 
		escobrador,
		estatus
		FROM tbvendedor 
		WHERE estatus='1'";
		return ejecutarConsulta($sql);		
	}

		//Implementar un método para listar los registros y mostrar en el select
		public function rptListar()
		{
			$sql="SELECT 
			idvendedor, 
			cod_vendedor,
			desc_vendedor,
			rif,
			direccion,
			fechareg, 
			comisionv, 
			comisionc, 
			esvendedor, 
			escobrador,
			estatus
			FROM tbvendedor";
			return ejecutarConsulta($sql);		
		}
}
?>