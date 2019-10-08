<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Compra
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	public function generarCod($ftipo)
	{
		if ($ftipo=='Cotizacion') {
			$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
			FROM tbcorrelativo WHERE tabla='tbccompra' AND estatus='1'";
			return ejecutarConsulta($sql);

		} else if ($ftipo=='Pedido'){

			$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
			FROM tbcorrelativo WHERE tabla='tbpcompra' AND estatus='1'";
			return ejecutarConsulta($sql);

		} else if ($ftipo=='Factura'){

			$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
			FROM tbcorrelativo WHERE tabla='tbfcompra' AND estatus='1'";
			return ejecutarConsulta($sql);
		}
	}

	public function ActCod($tipo)
	{
		if ($tipo=='Cotizacion') {

			$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbccompra'";
			return ejecutarConsulta($sql);

		} else if ($tipo=='Pedido'){

			$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbpcompra'";
			return ejecutarConsulta($sql);
			
		} else if ($tipo=='Factura'){

			$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbfcompra'";
			return ejecutarConsulta($sql);
			
		}
	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario,$idproveedor,$cod_compra,$desc_compra,$numerod,$numeroc,$tipo,$origen,$estatus,
	$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,$idarticulo,$iddeposito,$cantidad,$costo,$tasa)
	{
		$sql="INSERT INTO tbcompra (idusuario,idproveedor,cod_compra,desc_compra,numerod,numeroc,
		tipo,origen,estatus,subtotalh,impuestoh,totalh,saldoh,fechareg,fechaven,fechadb)
		VALUES ('$idusuario','$idproveedor','$cod_compra','$desc_compra','$numerod','$numeroc','$tipo','$origen',
		'Registrado','$subtotalh','$impuestoh','$totalh','$saldoh','$fechareg','$fechaven',NOW())";
		$idcompra=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle ="INSERT INTO tbcomprad (idcompra,idarticulo,iddeposito,cantidad,costo,tasa) 
			VALUES ('$idcompra','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',
			'$cantidad[$num_elementos]','$costo[$num_elementos]','$tasa[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	//Método para Actualizar el Stock de los Articulos en el Almacen Correspondiente
	public function AddStockArt($tipo,$idarticulo,$iddeposito,$cantidad)
	{	
		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			if ($tipo!="Cotizacion") 
			{
				$sql_detalle ="UPDATE 
				tbstock SET
				cantidad=cantidad + '$cantidad[$num_elementos]'
				WHERE 
				idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
			}
		}
		return $sw;
	}

	public function actDetalle($tipo,$idcompra)
	{
		if ($tipo!='Cotizacion') {

			$sql="UPDATE tbcomprad
			SET 
			anulado='1'
			WHERE idcompra='$idcompra'";
			return ejecutarConsulta($sql);
		}
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idcompra)
	{
		$sql="UPDATE 
		tbcompra 
		SET 
		estatus='Eliminado',
		fechadb=NOW() 
		WHERE idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function anular($idcompra)
	{
		$sql="UPDATE 
		tbcompra 
		SET 
		estatus='Anulado',
		fechadb=NOW() 
		WHERE idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	public function addsaldoproveedor($tipo,$idproveedor,$totalh)
	{
		if ($tipo!='Cotizacion') {
			$sql="UPDATE tbproveedor
			SET 
			saldo = saldo + '$totalh'
			WHERE idproveedor='$idproveedor'";
			return ejecutarConsulta($sql);
		}
	}

	public function delSaldo($tipo,$idproveedor,$totalh)
	{
        if ($tipo !='Cotizacion') {
            $sql="UPDATE tbproveedor
			SET 
			saldo = saldo - '$totalh'
			WHERE idproveedor='$idproveedor'";
            return ejecutarConsulta($sql);
        }
    }

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcompra)
	{
		$sql="SELECT 
		c.idcompra,
		c.idproveedor,
		c.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		p.cod_proveedor,
		p.desc_proveedor,
		p.rif,
		c.cod_compra,
		c.desc_compra,
		c.tipo,
		c.numerod,
		c.numeroc,
		c.origen,
		c.estatus,
		CONVERT(c.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(c.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(c.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE(c.fechareg) AS fechareg,
		DATE(c.fechaven) AS fechaven
		FROM tbcompra c
		INNER JOIN tbproveedor p ON p.idproveedor=c.idproveedor
		INNER JOIN tbusuario u ON u.idusuario=c.idusuario
		WHERE c.idcompra='$idcompra'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($tipo)
	{
		$sql="SELECT 
		c.idcompra,
		c.idproveedor,
		pv.cod_proveedor,
		pv.desc_proveedor,
		pv.rif,
		c.cod_compra,
		c.desc_compra,
		c.tipo,
		c.numerod,
		c.numeroc,
		c.origen,
		c.estatus,
		CONVERT(c.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(c.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(c.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE_FORMAT(c.fechareg,'%d-%m-%Y') AS fechareg,
		DATE_FORMAT(c.fechaven,'%d-%m-%Y') AS fechaven
		FROM tbcompra c
		INNER JOIN tbproveedor pv ON pv.idproveedor=c.idproveedor 
		WHERE c.estatus<>'eliminado' AND c.tipo='$tipo'";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalle($idcompra)
	{
		$sql="SELECT
		cd.idcompra,
		cd.idarticulo,
		cd.iddeposito,
		a.cod_articulo, 
		a.desc_articulo,
		d.cod_deposito,
		d.desc_deposito,
		CONVERT(cd.cantidad, DECIMAL(12,0)) AS cantidad,
		CONVERT(cd.costo, DECIMAL(12,2)) AS costo,
		CONVERT(cd.costo * cd.cantidad, DECIMAL(12,2)) AS subtotald,
		CONVERT(((cd.costo * cd.cantidad) * cd.tasa)/100, DECIMAL(12,2)) AS impsubd,
		CONVERT((((cd.costo * cd.cantidad) * cd.tasa)/100) + (cd.costo * cd.cantidad), DECIMAL(12,2)) AS totald
		FROM tbcomprad cd
		INNER JOIN tbarticulo a ON a.idarticulo=cd.idarticulo
		INNER JOIN tbdeposito d ON d.iddeposito=cd.iddeposito
		WHERE cd.idcompra ='$idcompra'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		c.idcompra,
		c.idproveedor,
		c.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		p.cod_proveedor,
		p.desc_proveedor,
		p.rif,
		c.cod_compra,
		c.desc_compra,
		c.tipo,
		c.numerod,
		c.numeroc,
		c.origen,
		c.estatus,
		CONVERT(c.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(c.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(c.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE(c.fechareg) AS fechareg,
		DATE(c.fechaven) AS fechaven
		FROM tbcompra c
		INNER JOIN tbproveedor p ON p.idproveedor=c.idproveedor
		INNER JOIN tbusuario u ON u.idusuario=c.idusuario
		WHERE estatus='1' ORDER BY cod_compra ASC";
		return ejecutarConsulta($sql);		
	}

	public function RptCompraH($idcompra)
	{
		$sql="SELECT 
		c.cod_compra, 
		c.idproveedor, 
		pv.cod_proveedor,
		pv.desc_proveedor,
		pv.rif, 
		pv.direccion, 
		pv.telefono,
		pv.email, 
		c.numerod, 
		c.numeroc,
		CONVERT(c.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(c.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(c.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(c.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE_FORMAT(c.fechareg,'%d-%m-%Y') AS fechareg,
		DATE_FORMAT(c.fechaven,'%d-%m-%Y') AS fechaven
		FROM tbcompra c
		INNER JOIN tbproveedor pv ON pv.idproveedor=c.idproveedor
		WHERE cc.idcompra ='$idcompra'";
		return ejecutarConsulta($sql);
	}

	public function RptCompraD($idcompra)
	{
		$sql="SELECT
		cd.idcompra,
		cd.idarticulo,
		cd.iddeposito,
		a.cod_articulo, 
		a.desc_articulo,
		d.cod_deposito,
		d.desc_deposito,
		CONVERT(cd.cantidad, DECIMAL(12,0)) AS cantidad,
		CONVERT(cd.costo, DECIMAL(12,2)) AS costo,
		CONVERT(cd.tasa, DECIMAL(12,2)) AS tasa,
		CONVERT(cd.costo*cd.cantidad, DECIMAL(12,2)) AS subtotald,
		CONVERT(((cd.costo*cd.cantidad)*cd.tasa)/100, DECIMAL(12,2)) AS impsubd,
		CONVERT((((cd.costo*cd.cantidad)*cd.tasa)/100) + (cd.costo*cd.cantidad),DECIMAL(12,2)) AS totald
		FROM tbcomprad cd
		INNER JOIN tbarticulo a ON a.idarticulo=cd.idarticulo
		INNER JOIN tbdeposito d ON d.iddeposito=cd.iddeposito
		WHERE cd.idcompra ='$idcompra'";
		return ejecutarConsulta($sql);
	}
}
?>