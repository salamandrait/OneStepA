<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Operacion
{
		//Implementamos nuestro constructor
	public function _construct()
	{

    }
    

	//Implementamos un método para insertar registros
    public function insertar($cod_operacion,$desc_operacion,$escompra,$esventa,
    $esinventario,$esconfig,$esbanco)
	{
		$sql="INSERT 
		INTO tboperacion (cod_operacion,desc_operacion,escompra,esventa,esinventario,esconfig,esbanco,estatus)
		VALUES ('$cod_operacion','$desc_operacion','$escompra','$esventa','$esinventario','$esconfig','$esbanco','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idoperacion,$cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco)
	{
		$sql="UPDATE 
		tboperacion 
		SET 
        cod_operacion = '$cod_operacion',
        desc_operacion = '$desc_operacion',
        escompra = '$escompra',
        esventa = '$esventa',
        esinventario = '$esinventario',
        esconfig = '$esconfig',
        esbanco = '$esbanco'
		WHERE idoperacion='$idoperacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idoperacion)
	{
		$sql="DELETE 
		FROM tboperacion 
		WHERE idoperacion='$idoperacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idoperacion)
	{
		$sql="UPDATE 
		tboperacion 
		SET 
		estatus='0' 
		WHERE idoperacion='$idoperacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idoperacion)
	{
		$sql="UPDATE 
		tboperacion 
		SET 
		estatus='1' 
		WHERE idoperacion='$idoperacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idoperacion)
	{
		$sql="SELECT * FROM tboperacion 
		WHERE idoperacion='$idoperacion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tboperacion";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select($optipo)
	{	
		if ($optipo=='compra') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND escompra='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='venta') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esventa='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='inventario') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esinventario='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='banco') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esbanco='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		} else if($optipo=='config') {

			$sql="SELECT * FROM tboperacion WHERE estatus='1' AND esconfig='1'
			ORDER BY cod_operacion ASC";
			return ejecutarConsulta($sql);

		}
		
	}
}
?>