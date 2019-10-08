<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Usuario
{
	//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cod_usuario,$desc_usuario,$direccion,$telefono,$email,$departamento,
	$clave,$imagen,$fechareg,$accesos)
	{
		$sql="INSERT INTO tbusuario(cod_usuario,desc_usuario,direccion,telefono,email,departamento,
		clave,imagen,fechareg,condicion)
		VALUES ('$cod_usuario','$desc_usuario','$direccion','$telefono','$email','$departamento',
		'$clave','$imagen','$fechareg','1')";
		$idusuarionew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($accesos))
		{
			$sql_detalle = "INSERT 
			INTO tbusuarioac (idusuario, idacceso) 
			VALUES('$idusuarionew','$accesos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
    public function editar($idusuario,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,$departamento,
	$clave,$imagen,$fechareg,$accesos)
	{
		$sql="UPDATE 
		tbusuario 
		SET 
		cod_usuario = '$cod_usuario',
		desc_usuario = '$desc_usuario',
		direccion = '$direccion',
		telefono = '$telefono',
		email = '$email',
		departamento = '$departamento',
		clave = '$clave',
		imagen = '$imagen',
		fechareg = '$fechareg'
		WHERE idusuario = '$idusuario'";
		ejecutarConsulta($sql);
	
		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM tbusuarioac WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);
	
		$num_elementos=0;
		$sw=true;
	
		while ($num_elementos < count($accesos))
		{
			$sql_detalle = "INSERT 
			INTO tbusuarioac (idusuario, idacceso) 
			VALUES('$idusuario', '$accesos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
	
		return $sw;	
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idusuario)
	{
		$sql="DELETE FROM tbusuario WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminaracceso($idusuario)
	{
		$sql="DELETE FROM tbusuarioac WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE tbusuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE tbusuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM tbusuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM tbusuario";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM tbusuario where condicion='1'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM tbusuarioac WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}
	
	//Función para verificar el acceso al sistema
	public function verificar($cod_usuario,$clave)
	{
		$sql="SELECT 
		idusuario,cod_usuario,desc_usuario,direccion,telefono,email,departamento,clave,imagen,fechareg
		FROM tbusuario 
		WHERE cod_usuario='$cod_usuario' AND clave='$clave' AND condicion='1'
		ORDER BY cod_usuario ASC"; 
		return ejecutarConsulta($sql);  

		//--( ( @sCo_Uni_d IS NULL OR @sCo_Uni_d <= co_uni)--
		//--AND ( @sCo_Uni_h IS NULL OR co_uni <= @sCo_uni_h ) )
	}
}

?>