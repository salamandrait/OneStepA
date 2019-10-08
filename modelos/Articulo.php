<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcategoria,$idunidad,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,$artref,
	$costo1,$costo2,$costo3,$precio1,$precio2,$precio3,$fechareg,$imagen,$idarticulo,$iddeposito)
	{
		$sql="INSERT INTO tbarticulo (idcategoria,idunidad,idimpuesto,cod_articulo,desc_articulo,tipo,origen,artref,
		costo1,costo2,costo3,precio1,precio2,precio3,fechareg,imagen,estatus)
		VALUES ('$idcategoria','$idunidad','$idimpuesto','$cod_articulo','$desc_articulo','$tipo','$origen','$artref','$costo1','$costo2','$costo3',CONVERT('$precio1',DECIMAL(12,2)),'$precio2','$precio3','$fechareg','$imagen','1')";
		$idarticulo=ejecutarConsulta_retornarID($sql);

		$sw=true;

		$sql_detalle ="INSERT INTO tbstock (idarticulo,iddeposito,cantidad) 
		SELECT '$idarticulo',$iddeposito','0' FROM DUAL 
		WHERE NOT EXISTS (SELECT idarticulo,iddeposito,cantidad FROM tbstock 
		WHERE idarticulo='$idarticulo' AND iddeposito='$iddeposito')";
		ejecutarConsulta($sql_detalle) or $sw = false;
		
		return $sw;
	}

	//Implementamos un método para insertar registros
	public function insertarDep($idarticulo,$iddeposito)
	{
		$sql="INSERT INTO tbstock (idarticulo, iddeposito,cantidad) 
		SELECT '$idarticulo','$iddeposito','0' FROM DUAL 
		WHERE NOT EXISTS (SELECT idarticulo, iddeposito,cantidad FROM tbstock 
		WHERE idarticulo='$idarticulo' AND iddeposito='$iddeposito')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idcategoria,$idunidad,$idimpuesto,$cod_articulo,$desc_articulo,$tipo,$origen,$artref,$costo1,$costo2,$costo3,$precio1,$precio2,$precio3,$fechareg,$imagen)
	{
		$sql="UPDATE tbarticulo 
		SET
		idcategoria = '$idcategoria',
        idunidad = '$idunidad',
        idimpuesto = '$idimpuesto',
		cod_articulo ='$cod_articulo',
		desc_articulo ='$desc_articulo',
		tipo = '$tipo',
		origen = '$origen',
        artref = '$artref',
        costo1 = '$costo1',
        costo2 = '$costo2',
        costo3 = '$costo3',
        precio1 = '$precio1',
        precio2 = '$precio2',
        precio3 = '$precio3',
        fechareg = '$fechareg',
        imagen = '$imagen' 
		WHERE idarticulo ='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idarticulo)
	{
		$sql="DELETE 
		FROM tbarticulo 
		WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	public function VerificarRegistros($idarticulo)
	{
		$sql="SELECT COUNT(*) FROM tbstock WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{


		$sql="UPDATE 
		tbarticulo 
		SET 
		estatus='0' 
		WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE 
		tbarticulo 
		SET 
		estatus='1' 
		WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT 
		a.idarticulo,
		a.idcategoria,
		a.idunidad,
		a.idimpuesto,
		i.cod_impuesto,
		i.desc_impuesto,
		a.cod_articulo,
		a.desc_articulo,
		a.artref,
		a.imagen,
		a.tipo,
		a.origen,
		CONVERT(a.costo1,DECIMAL(12,2)) AS costo1,
		CONVERT(a.costo2,DECIMAL(12,2)) AS costo2,
		CONVERT(a.costo3,DECIMAL(12,2)) AS costo3,
		CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
		CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
		CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
		CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
		a.fechareg
		FROM tbarticulo a 
		INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
		INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
		INNER JOIN tbunidad u ON u.idunidad=a.idunidad
		WHERE a.idarticulo ='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT 
		a.idarticulo,
		a.idcategoria,
		a.idunidad,
		a.cod_articulo,
		a.desc_articulo,
		c.cod_categoria,
		c.desc_categoria,
		a.artref,
		a.imagen,
		a.estatus,
		CONVERT(SUM(s.cantidad),DECIMAL(12,0)) AS stock,
		CONVERT(a.costo1,DECIMAL(12,2)) AS costo1,
		CONVERT(a.costo2,DECIMAL(12,2)) AS costo2,
		CONVERT(a.costo3,DECIMAL(12,2)) AS costo3,
		CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
		CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
		CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
		CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
		a.fechareg,
		a.estatus
		FROM tbarticulo a 
		INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
		INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
		INNER JOIN tbunidad u ON u.idunidad=a.idunidad
		LEFT JOIN tbstock s ON s.idarticulo=a.idarticulo
		GROUP BY a.idarticulo";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectProceso($iddeposito)
	{
		$sql="SELECT 
		a.idarticulo,
		a.idcategoria,
		a.idunidad,
		a.idimpuesto,
		i.cod_impuesto,
		i.desc_impuesto,
		a.cod_articulo,
		a.desc_articulo,
		a.artref,
		a.imagen,
		a.tipo,
		a.origen,
		d.iddeposito,
		d.cod_deposito,
		d.desc_deposito,
		u.cod_unidad,
		u.desc_unidad,
		CONVERT(IFNULL(s.cantidad,0),DECIMAL(12,0)) AS stock,
		CONVERT(a.costo1,DECIMAL(12,2)) AS costo1,
		CONVERT(a.costo2,DECIMAL(12,2)) AS costo2,
		CONVERT(a.costo3,DECIMAL(12,2)) AS costo3,
		CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
		CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
		CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
		CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
		a.fechareg,
		a.estatus
		FROM tbarticulo a 
		INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
		INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
		INNER JOIN tbunidad u ON u.idunidad=a.idunidad
		INNER JOIN tbstock s ON s.idarticulo=a.idarticulo
		INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
		WHERE a.estatus='1' AND d.iddeposito='$iddeposito'";
		return ejecutarConsulta($sql);					
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectVenta($iddeposito)
	{
		$sql="SELECT 
		a.idarticulo,
		a.idcategoria,
		a.idunidad,
		a.idimpuesto,
		i.cod_impuesto,
		i.desc_impuesto,
		a.cod_articulo,
		a.desc_articulo,
		a.artref,
		a.imagen,
		a.tipo,
		a.origen,
		d.iddeposito,
		d.cod_deposito,
		d.desc_deposito,
		u.cod_unidad,
		u.desc_unidad,
		CONVERT(IFNULL(s.cantidad,0),DECIMAL(12,0)) AS stock,
		CONVERT(a.costo1,DECIMAL(12,2)) AS costo1,
		CONVERT(a.costo2,DECIMAL(12,2)) AS costo2,
		CONVERT(a.costo3,DECIMAL(12,2)) AS costo3,
		CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
		CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
		CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
		CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
		a.fechareg,
		a.estatus
		FROM tbarticulo a 
		INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
		INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
		INNER JOIN tbunidad u ON u.idunidad=a.idunidad
		INNER JOIN tbstock s ON s.idarticulo=a.idarticulo
		INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
		WHERE a.estatus='1' AND d.iddeposito='$iddeposito'";
		return ejecutarConsulta($sql);					
	}

	//Implementar un método para listar los registros
	public function rptListar()
	{
		$sql="SELECT 
		a.idarticulo,
		a.idcategoria,
		a.idunidad,
		a.idimpuesto,
		i.cod_impuesto,
		i.desc_impuesto,
		a.cod_articulo,
		a.desc_articulo,
		a.artref,
		a.imagen,
		a.tipo,
		a.origen,
		u.cod_unidad,
		u.desc_unidad,
		CONVERT(s.cantidad,DECIMAL(12,0)) AS stock,
		CONVERT(a.costo1,DECIMAL(12,2)) AS costo1,
		CONVERT(a.costo2,DECIMAL(12,2)) AS costo2,
		CONVERT(a.costo3,DECIMAL(12,2)) AS costo3,
		CONVERT(i.tasa,DECIMAL(12,0)) AS tasa,
		CONVERT(a.precio1,DECIMAL(12,2)) AS precio1,
		CONVERT(a.precio2,DECIMAL(12,2)) AS precio2,
		CONVERT(a.precio3,DECIMAL(12,2)) AS precio3,
		DATE_FORMAT(a.fechareg,'%d,%m,%Y') AS fechareg,
		a.estatus
		FROM tbarticulo a 
		INNER JOIN tbcategoria c ON a.idcategoria=c.idcategoria
		INNER JOIN tbimpuesto i ON i.idimpuesto=a.idimpuesto
		INNER JOIN tbunidad u ON u.idunidad=a.idunidad
		INNER JOIN tbstock s ON s.idarticulo=a.idarticulo
		GROUP BY a.idarticulo";
		return ejecutarConsulta($sql);					
	}
}
?>