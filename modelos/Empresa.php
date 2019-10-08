<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Empresa
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_empresa,$desc_empresa,$rif,$direccion,$codpostal,$telefono,$movil,
	$contacto,$email,$web,$imagen1,$imagen2,$esfiscal,$montofiscal)
	{
		$sql="INSERT INTO tbempresa (cod_empresa,desc_empresa,rif,direccion,codpostal,telefono,movil,contacto,email,
		web,imagen1,imagen2,esfiscal,montofiscal)
		VALUES ('$cod_empresa','$desc_empresa','$rif','$direccion','$codpostal','$telefono','$movil','$contacto','$email',
		'$web','$imagen1','$imagen2','1','$montofiscal')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idempresa,$cod_empresa,$desc_empresa,$rif,$direccion,$codpostal,$telefono,$movil,
	$contacto,$email,$web,$imagen1,$imagen2,$esfiscal,$montofiscal)
	{
		$sql="UPDATE tbempresa 
		SET
		cod_empresa = '$cod_empresa',
		desc_empresa = '$desc_empresa',
		rif = '$rif',
		direccion = '$direccion',
		codpostal = '$codpostal',
		telefono = '$telefono',
		movil = '$movil',
		contacto = '$contacto',
		email = '$email',
		web = '$web',
		imagen1 = '$imagen1',
		imagen2 = '$imagen2',
		esfiscal = '$esfiscal',
		montofiscal = '$montofiscal' 
		WHERE idempresa = '$idempresa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idempresa)
	{
		$sql="DELETE 
		FROM tbempresa 
		WHERE idempresa='$idempresa'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idempresa)
	{
		$sql="UPDATE 
		tbempresa 
		SET 
		estatus='0' 
		WHERE idempresa='$idempresa'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idempresa)
	{
		$sql="UPDATE 
		tbempresa 
		SET 
		estatus='1' 
		WHERE idempresa='$idempresa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idempresa)
	{
		$sql="SELECT 
		idempresa,
		cod_empresa,
		desc_empresa,
		rif,
		direccion,
		codpostal,
		telefono,
		movil,
		contacto,
		email,
		web,
		imagen1,
		imagen2,
		esfiscal,
		CONVERT(montofiscal,DECIMAL(18,0)) AS montofiscal
		FROM tbempresa WHERE idempresa='$idempresa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT   
		idempresa,
		cod_empresa,
		desc_empresa,
		rif,
		direccion,
		codpostal,
		telefono,
		movil,
		contacto,
		email,
		web,
		imagen1,
		imagen2,
		esfiscal,
		CONVERT(montofiscal,DECIMAL(18,0)) AS montofiscal,
		DATE_FORMAT(CURDATE(),'%d-%m-%Y') AS fecharpt,
		CURTIME() AS timerpt 
		FROM tbempresa";
		return ejecutarConsulta($sql);	
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM tbempresa WHERE condicion='1'";
		return ejecutarConsulta($sql);		
	}
}
?>