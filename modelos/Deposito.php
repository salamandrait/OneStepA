<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Deposito
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}


	//Implementamos un método para insertar registros
	public function insertar($cod_deposito,$desc_deposito,$responsable,$direccion,$fechareg,$solocompra,$soloventa)
	{
		$sql="INSERT 
		INTO tbdeposito (cod_deposito,desc_deposito,responsable,direccion,fechareg,solocompra,soloventa,estatus)
		VALUES ('$cod_deposito','$desc_deposito','$responsable','$direccion','$fechareg','$solocompra','$soloventa','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($iddeposito,$cod_deposito,$desc_deposito,$responsable,$direccion,$fechareg,$solocompra,$soloventa)
	{
		$sql="UPDATE 
		tbdeposito 
		SET
		cod_deposito = '$cod_deposito',
		desc_deposito = '$desc_deposito',
		responsable = '$responsable',
		direccion = '$direccion',
		fechareg = '$fechareg',
		solocompra = '$solocompra',
		soloventa = '$soloventa'
	  	WHERE iddeposito = '$iddeposito'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($iddeposito)
	{
		$sql="DELETE 
		FROM tbdeposito 
		WHERE iddeposito='$iddeposito'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($iddeposito)
	{
		$sql="UPDATE 
		tbdeposito 
		SET 
		estatus='0' 
		WHERE iddeposito='$iddeposito'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($iddeposito)
	{
		$sql="UPDATE 
		tbdeposito 
		SET 
		estatus='1' 
		WHERE iddeposito='$iddeposito'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($iddeposito)
	{
		$sql="SELECT 
		iddeposito,
		cod_deposito,
		desc_deposito,
		responsable,
		direccion,
		fechareg,
		solocompra,
		soloventa,
		estatus 
		FROM tbdeposito 
		WHERE iddeposito='$iddeposito'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		iddeposito,
		cod_deposito,
		desc_deposito,
		responsable,
		direccion,
		fechareg,
		solocompra,
		soloventa,
		estatus 
		FROM tbdeposito";
		return ejecutarConsulta($sql);		
	}


	public function listarStock($idarticulo)
	{
		$sql="SELECT 
		s.iddeposito,
		d.cod_deposito,
		d.desc_deposito,
		IFNULL(s.cantidad,0) AS stock
		FROM tbstock s
		INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
		WHERE s.idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		iddeposito,
		cod_deposito,
		desc_deposito,
		responsable,
		direccion,
		fechareg,
		solocompra,
		soloventa,
		estatus 
		FROM tbdeposito WHERE estatus='1'
		ORDER BY cod_deposito ASC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function rptListar()
	{
		$sql="SELECT 
		iddeposito,
		cod_deposito,
		desc_deposito,
		responsable,
		direccion,
		fechareg,
		solocompra,
		soloventa,
		estatus 
		FROM tbdeposito
		ORDER BY cod_deposito ASC";
		return ejecutarConsulta($sql);		
	}
}
?>