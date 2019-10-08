<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ajuste
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	public function generarCod()
	{
		$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
		FROM tbcorrelativo WHERE tabla='tbajuste' AND estatus='1'";
		return ejecutarConsulta($sql);
	}

	public function ActCod()
	{
		$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbajuste' AND estatus='1'";
		return ejecutarConsulta($sql);
    }

	//Implementamos un método para insertar registros
	public function insertar($idusuario,$cod_ajuste,$desc_ajuste,$tipo,$totalstock,$totalh,
	$fechareg,$idarticulo,$iddeposito,$cantidad,$costo)
	{
		$sql="INSERT INTO tbajuste (idusuario,cod_ajuste,desc_ajuste,tipo,estatus,totalstock,totalh,fechareg,fechadb)
		VALUES ('$idusuario','$cod_ajuste','$desc_ajuste','$tipo','Registrado','$totalstock','$totalh','$fechareg',NOW())";
		$idajuste=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		if ($tipo=='Entrada') {
			while ($num_elementos < count($idarticulo))
			{
				$sql_detalle ="INSERT INTO tbajustee (idajuste,idarticulo,iddeposito,cantidad,costo,tipo) 
				VALUES ('$idajuste','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$cantidad[$num_elementos]','$costo[$num_elementos]','$tipo')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		} else 	if ($tipo=='Salida'){
			while ($num_elementos < count($idarticulo))
			{
				$sql_detalle ="INSERT INTO tbajustes (idajuste,idarticulo,iddeposito,cantidad,costo,tipo) 
				VALUES ('$idajuste','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$cantidad[$num_elementos]','$costo[$num_elementos]','$tipo')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		} else 	if ($tipo=='Inventario'){
			while ($num_elementos < count($idarticulo))
			{
				$sql_detalle ="INSERT INTO tbajustei (idajuste,idarticulo,iddeposito,cantidad,costo,tipo) 
				VALUES ('$idajuste','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]','$cantidad[$num_elementos]','$costo[$num_elementos]','$tipo')";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		}
		
		return $sw;
	}

	public function AddStockArt($idarticulo,$iddeposito,$cantidad,$tipo)
	{	
		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			if ($tipo=="Entrada") 
			{
				$sql_detalle ="UPDATE 
				tbstock SET
				cantidad=cantidad + '$cantidad[$num_elementos]'
				WHERE 
				idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
			else if ($tipo=="Salida") 
			{
				$sql_detalle ="UPDATE 
				tbstock SET
				cantidad=cantidad - '$cantidad[$num_elementos]'
				WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
			else if ($tipo=="Inventario") 
			{
				$sql_detalle ="UPDATE 
				tbstock SET
				cantidad='$cantidad[$num_elementos]'
				WHERE idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		}
		return $sw;
	}


	public function AnularStock($idajuste,$tipo)
	{
		if ($tipo=='Entrada') {

			$sql="UPDATE tbajustee
			SET 
			anular='1'
			WHERE idajuste='$idajuste'";
			return ejecutarConsulta($sql);

		} 
		
		if ($tipo=='Salida'){
			
			$sql="UPDATE tbajustes
			SET 
			anular='1'
			WHERE idajuste='$idajuste'";
			return ejecutarConsulta($sql);			

		} 

		if ($tipo=='Inventario'){
			
			$sql="UPDATE tbajustei
			SET 
			anular='1'
			WHERE idajuste='$idajuste'";
			return ejecutarConsulta($sql);
			
		}
			
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idajuste)
	{
		$sql="UPDATE tbajuste 
		SET estatus='eliminado' 
		WHERE idajuste='$idajuste'";
		return ejecutarConsulta($sql);
	}
		
	//Implementamos un método para anular Registros
	public function anular($idajuste)
	{
		$sql="UPDATE 
		tbajuste 
		SET estatus='Anulado' 
		WHERE idajuste='$idajuste'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idajuste,$cod_ajuste,$desc_ajuste)
	{
		$sql="UPDATE 
		tbajuste 
		SET 
		cod_ajuste='$cod_ajuste',
		desc_ajuste='$desc_ajuste'
		WHERE idajuste='$idajuste'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idajuste)
	{
		$sql="SELECT
		aj.idusuario, 
		aj.idajuste,
		aj.cod_ajuste,
		aj.desc_ajuste,
		aj.tipo,
		aj.estatus,
		CONVERT(aj.totalstock,DECIMAL(12,2)) AS totalstock,
		CONVERT(aj.totalh,DECIMAL(12,2)) AS totalh,
		aj.fechareg
		FROM tbajuste aj 
		WHERE idajuste='$idajuste'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		aj.idajuste,
		aj.cod_ajuste,
		aj.desc_ajuste,
		aj.tipo,
		aj.estatus,
		CONVERT(aj.totalstock,DECIMAL(12,2)) AS totalstock,
		CASE
		WHEN aj.tipo ='Entrada' THEN CONVERT(aj.totalh,DECIMAL(12,2))
		WHEN aj.tipo ='Salida' THEN CONVERT(-aj.totalh,DECIMAL(12,2))
		ELSE CONVERT(aj.totalh,DECIMAL(12,2)) END AS totalh,
		DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
		FROM tbajuste aj
		WHERE aj.estatus <> 'eliminado'";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalle($idajuste)
	{
		$sql="SELECT 
			ajd.idajusted, 
			ajd.idajuste,
			ajd.idarticulo,
			ajd.iddeposito,
			a.cod_articulo,
			a.desc_articulo,
			d.cod_deposito,
			d.desc_deposito,
			u.desc_unidad,
			CONVERT(ajd.cantidad,DECIMAL(12,0)) AS cantidad,
			CONVERT(ajd.costo,DECIMAL(12,2)) AS costo,
			CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald, 
			ajd.tipo
			FROM tbajustee ajd
			INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
			INNER JOIN tbunidad u ON a.idunidad=u.idunidad
			INNER JOIN tbdeposito d ON d.iddeposito=ajd.iddeposito
			WHERE ajd.idajuste='$idajuste'
			UNION
			SELECT 
			ajd.idajusted, 
			ajd.idajuste,
			ajd.iddeposito,
			ajd.idarticulo,
			a.cod_articulo,
			a.desc_articulo,
			d.cod_deposito,
			d.desc_deposito,
			u.desc_unidad,
			CONVERT(ajd.cantidad,DECIMAL(12,0)) AS cantidad,
			CONVERT(ajd.costo,DECIMAL(12,2)) AS costo,
			CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald, 
			ajd.tipo
			FROM tbajustes ajd
			INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
			INNER JOIN tbunidad u ON a.idunidad=u.idunidad
			INNER JOIN tbdeposito d ON d.iddeposito=ajd.iddeposito
			WHERE ajd.idajuste='$idajuste'
			UNION
			SELECT 
			ajd.idajusted, 
			ajd.idajuste,
			ajd.iddeposito,
			ajd.idarticulo,
			a.cod_articulo,
			a.desc_articulo,
			d.cod_deposito,
			d.desc_deposito,
			u.desc_unidad,
			CONVERT(ajd.cantidad,DECIMAL(12,0)) AS cantidad,
			CONVERT(ajd.costo,DECIMAL(12,2)) AS costo,
			CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald, 
			ajd.tipo
			FROM tbajustei ajd
			INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
			INNER JOIN tbunidad u ON a.idunidad=u.idunidad
			INNER JOIN tbdeposito d ON d.iddeposito=ajd.iddeposito
			WHERE ajd.idajuste='$idajuste'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		aj.idajuste,
		aj.cod_ajuste,
		aj.desc_ajuste,
		aj.tipo,
		aj.estatus,
		CONVERT(aj.totalstock,DECIMAL(12,2)) AS totalstock,
		CONVERT(aj.totalh,DECIMAL(12,2)) AS totalh,
		DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
		FROM tbajuste aj 
		WHERE aj.estatus='1'
		ORDER BY cod_ajuste ASC";
		return ejecutarConsulta($sql);		
	}

	public function rptGeneral()
	{
		$sql="SELECT 
		aj.idajuste,
		aj.cod_ajuste,
		aj.desc_ajuste,
		aj.tipo,
		aj.estatus,
		aj.totalstock,
		CASE
		WHEN aj.tipo ='Entrada' THEN aj.totalh
		WHEN aj.tipo ='Salida' THEN -aj.totalh
		ELSE aj.totalh END AS totalh,
		DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
		FROM tbajuste aj 
		WHERE aj.estatus <>'eliminado'
		ORDER BY cod_ajuste ASC";
		return ejecutarConsulta($sql);		
	}

	//Cabecera del Reporte de Ajuste

	public function rptAjusteH($idajuste)
	{

		$sql="SELECT 
		aj.idajuste,
		aj.idusuario,
		aj.cod_ajuste,
		aj.desc_ajuste,
		u.cod_usuario,
		u.desc_usuario,
		aj.tipo,
		aj.estatus,
		aj.totalh,
		DATE_FORMAT(aj.fechareg,'%d-%m-%Y') AS fechareg
		FROM tbajuste aj
		INNER JOIN tbusuario u ON u.idusuario=aj.idusuario
		WHERE aj.idajuste='$idajuste'";
		return ejecutarConsulta($sql);
	}

	public function rptAjusteD($idajuste)
	{

		$sql="SELECT 
			ajd.idajusted, 
			ajd.idajuste,
			ajd.iddeposito,
			ajd.idarticulo,
			a.cod_articulo,
			a.desc_articulo,
			d.cod_deposito,
			d.desc_deposito,
			u.desc_unidad,
			CONVERT(ajd.cantidad,DECIMAL(12,0)) AS cantidad,
			CONVERT(ajd.costo,DECIMAL(12,2)) AS costo,
			CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald, 
			ajd.tipo
			FROM tbajustee ajd
			INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
			INNER JOIN tbunidad u ON a.idunidad=u.idunidad
			INNER JOIN tbdeposito d ON d.iddeposito=ajd.iddeposito
			WHERE ajd.idajuste='$idajuste'
			UNION
			SELECT 
			ajd.idajusted, 
			ajd.idajuste,
			ajd.iddeposito,
			ajd.idarticulo,
			a.cod_articulo,
			a.desc_articulo,
			d.cod_deposito,
			d.desc_deposito,
			u.desc_unidad,
			CONVERT(-ajd.cantidad,DECIMAL(12,0)) AS cantidad,
			CONVERT(-ajd.costo,DECIMAL(12,2)) AS costo,
			CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald, 
			ajd.tipo
			FROM tbajustes ajd
			INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
			INNER JOIN tbunidad u ON a.idunidad=u.idunidad
			INNER JOIN tbdeposito d ON d.iddeposito=ajd.iddeposito
			WHERE ajd.idajuste='$idajuste'
			UNION
			SELECT 
			ajd.idajusted, 
			ajd.idajuste,
			ajd.iddeposito,
			ajd.idarticulo,
			a.cod_articulo,
			a.desc_articulo,
			d.cod_deposito,
			d.desc_deposito,
			u.desc_unidad,
			CONVERT(ajd.cantidad,DECIMAL(12,0)) AS cantidad,
			CONVERT(ajd.costo,DECIMAL(12,2)) AS costo,
			CONVERT(ajd.cantidad*ajd.costo,DECIMAL(12,2)) AS totald, 
			ajd.tipo
			FROM tbajustei ajd
			INNER JOIN tbarticulo a ON a.idarticulo=ajd.idarticulo
			INNER JOIN tbunidad u ON a.idunidad=u.idunidad
			INNER JOIN tbdeposito d ON d.iddeposito=ajd.iddeposito
			WHERE ajd.idajuste='$idajuste'";
		return ejecutarConsulta($sql);
	}
}
?>