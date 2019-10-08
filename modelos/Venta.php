<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Venta
{
		//Implementamos nuestro constructor
	public function _construct()
	{

	}

	public function generarCod($ftipo)
	{
		if ($ftipo=='Cotizacion') {
			$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
			FROM tbcorrelativo WHERE tabla='tbcventa' AND estatus='1'";
			return ejecutarConsulta($sql);

		} else if ($ftipo=='Pedido'){

			$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
			FROM tbcorrelativo WHERE tabla='tbpventa' AND estatus='1'";
			return ejecutarConsulta($sql);

		} else if ($ftipo=='Factura'){

			$sql="SELECT CONCAT(precadena,RIGHT(CONCAT(REPEAT(cadena,largo),cod_num+1),largo)) AS codnum 
			FROM tbcorrelativo WHERE tabla='tbfventa' AND estatus='1'";
			return ejecutarConsulta($sql);
		}
	}

	public function ActCod($tipo)
	{
		if ($tipo=='Cotizacion') {

			$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbcventa'";
			return ejecutarConsulta($sql);

		} else if ($tipo=='Pedido'){

			$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbpventa'";
			return ejecutarConsulta($sql);
			
		} else if ($tipo=='Factura'){

			$sql="UPDATE tbcorrelativo SET cod_num=cod_num+1 WHERE tabla='tbfventa'";
			return ejecutarConsulta($sql);
			
		}
	}

	//Implementamos un método para insertar registros
	public function insertar($idusuario,$idcliente,$idvendedor,$cod_venta,$desc_venta,$numerod,$numeroc,$tipo,$origen,$estatus,
	$subtotalh,$impuestoh,$totalh,$saldoh,$fechareg,$fechaven,$idarticulo,$iddeposito,$cantidad,$precio,$tasa)
	{
		$sql="INSERT INTO tbventa (idusuario,idcliente,idvendedor,cod_venta,desc_venta,numerod,numeroc,
		tipo,origen,estatus,subtotalh,impuestoh,totalh,saldoh,fechareg,fechaven,fechadb)
		VALUES ('$idusuario','$idcliente','$idvendedor','$cod_venta','$desc_venta','$numerod','$numeroc','$tipo','$origen',
		'Registrado','$subtotalh','$impuestoh','$totalh','$saldoh','$fechareg','$fechaven',NOW())";
		$idventa=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle ="INSERT INTO tbventad (idventa,idarticulo,iddeposito,cantidad,precio,tasa) 
			VALUES ('$idventa','$idarticulo[$num_elementos]','$iddeposito[$num_elementos]',
			'$cantidad[$num_elementos]','$precio[$num_elementos]','$tasa[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	//Método para Actualizar el Stock de los Articulos en el Almacen Correspondiente
	public function AddStockArt($idarticulo,$iddeposito,$cantidad)
	{	
		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
				$sql_detalle ="UPDATE 
				tbstock SET
				cantidad=cantidad - '$cantidad[$num_elementos]'
				WHERE 
				idarticulo='$idarticulo[$num_elementos]' AND iddeposito='$iddeposito[$num_elementos]'";
				ejecutarConsulta($sql_detalle) or $sw = false;
				$num_elementos=$num_elementos + 1;
		}
		return $sw;
	}

	public function actDetalle($tipo,$idventa)
	{
		$sql="UPDATE tbventad
		SET 
		anulado='1'
		WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para Eliminar los datos de un registro
	public function eliminar($idventa)
	{
		$sql="UPDATE 
		tbventa 
		SET 
		estatus='Eliminado',
		fechadb=NOW() 
		WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function anular($idventa)
	{
		$sql="UPDATE 
		tbventa 
		SET 
		estatus='Anulado',
		fechadb=NOW() 
		WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function addsaldocliente($idcliente,$totalh)
	{
			$sql="UPDATE tbcliente
			SET 
			saldo = saldo + '$totalh'
			WHERE idcliente='$idcliente'";
			return ejecutarConsulta($sql);
	}

	public function delSaldo($tipo,$idcliente,$totalh)
	{
            $sql="UPDATE tbcliente
			SET 
			saldo = saldo - '$totalh'
			WHERE idcliente='$idcliente'";
            return ejecutarConsulta($sql);
    }

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT 
		v.idventa,
		v.idcliente,
		v.idvendedor,
		v.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		vd.cod_vendedor,
		vd.desc_vendedor,
		v.cod_venta,
		v.desc_venta,
		v.tipo,
		v.numerod,
		v.numeroc,
		v.origen,
		v.estatus,
		CONVERT(v.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(v.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(v.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(v.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE(v.fechareg) AS fechareg,
		DATE(v.fechaven) AS fechaven
		FROM tbventa v
		INNER JOIN tbcliente cl ON cl.idcliente=v.idcliente
		INNER JOIN tbusuario u ON u.idusuario=v.idusuario
		INNER JOIN tbvendedor vd ON vd.idvendedor=v.idvendedor
		WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($tipo)
	{
		$sql="SELECT 
		v.idventa,
		v.idcliente,
		v.idvendedor,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		vd.cod_vendedor,
		vd.desc_vendedor,
		v.cod_venta,
		v.desc_venta,
		v.tipo,
		v.numerod,
		v.numeroc,
		v.origen,
		v.estatus,
		CONVERT(v.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(v.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(v.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(v.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE_FORMAT(v.fechareg,'%d-%m-%Y') AS fechareg,
		DATE_FORMAT(v.fechaven,'%d-%m-%Y') AS fechaven
		FROM tbventa v
		INNER JOIN tbcliente cl ON cl.idcliente=v.idcliente 
		INNER JOIN tbvendedor vd ON vd.idvendedor=v.idvendedor
		WHERE v.estatus<>'eliminado' AND v.tipo='$tipo'";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT
		vd.idventa,
		vd.idarticulo,
		vd.iddeposito,
		a.cod_articulo, 
		a.desc_articulo,
		d.cod_deposito,
		d.desc_deposito,
		CONVERT(vd.cantidad, DECIMAL(12,0)) AS cantidad,
		CONVERT(vd.precio, DECIMAL(12,2)) AS precio,
		CONVERT(vd.precio * vd.cantidad, DECIMAL(12,2)) AS subtotald,
		CONVERT(((vd.precio * vd.cantidad) * vd.tasa)/100, DECIMAL(12,2)) AS impsubd,
		CONVERT((((vd.precio * vd.cantidad) * vd.tasa)/100) + (vd.precio * vd.cantidad), DECIMAL(12,2)) AS totald
		FROM tbventad vd
		INNER JOIN tbarticulo a ON a.idarticulo=vd.idarticulo
		INNER JOIN tbdeposito d ON d.iddeposito=vd.iddeposito
		WHERE vd.idventa ='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT 
		v.idventa,
		v.idcliente,
		v.idvendedor,
		v.idusuario,
		u.cod_usuario,
		u.desc_usuario,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif,
		vd.cod_vendedor,
		vd.desc_vendedor,
		v.cod_venta,
		v.desc_venta,
		v.tipo,
		v.numerod,
		v.numeroc,
		v.origen,
		v.estatus,
		CONVERT(v.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(v.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(v.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(v.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE(v.fechareg) AS fechareg,
		DATE(v.fechaven) AS fechaven
		FROM tbventa v
		INNER JOIN tbcliente cl ON cl.idcliente=v.idcliente
		INNER JOIN tbusuario u ON u.idusuario=v.idusuario
		INNER JOIN tbvendedor vd ON vd.idvendedor=v.idvendedor
		WHERE v.estatus='1' ORDER BY cod_venta ASC";
		return ejecutarConsulta($sql);		
	}

	public function RptVentaH($idventa)
	{
		$sql="SELECT
		v.idventa,
		v.cod_venta, 
		v.idcliente, 
		v.idvendedor,
		cl.cod_cliente,
		cl.desc_cliente,
		cl.rif, 
		cl.direccion, 
		cl.telefono,
		cl.email,
		vd.cod_vendedor,
		vd.desc_vendedor,
		v.numerod, 
		v.numeroc,
		CONVERT(v.subtotalh,DECIMAL(12,2)) AS subtotalh,
		CONVERT(v.impuestoh,DECIMAL(12,2)) AS impuestoh,
		CONVERT(v.totalh,DECIMAL(12,2)) AS totalh,
		CONVERT(v.saldoh,DECIMAL(12,2)) AS saldoh,
		DATE_FORMAT(v.fechareg,'%d-%m-%Y') AS fechareg,
		DATE_FORMAT(v.fechaven,'%d-%m-%Y') AS fechaven
		FROM tbventa v
		INNER JOIN tbcliente pv ON cl.idcliente=v.idcliente
		INNER JOIN tbvendedor vd ON vd.idvendedor=v.idvendedor
		WHERE v.idventa ='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function RptVentaD($idventa)
	{
		$sql="SELECT
		vd.idventa,
		vd.idarticulo,
		vd.iddeposito,
		a.cod_articulo, 
		a.desc_articulo,
		d.cod_deposito,
		d.desc_deposito,
		CONVERT(vd.cantidad, DECIMAL(12,0)) AS cantidad,
		CONVERT(vd.precio, DECIMAL(12,2)) AS precio,
		CONVERT(vd.tasa, DECIMAL(12,2)) AS tasa,
		CONVERT(vd.precio*vd.cantidad, DECIMAL(12,2)) AS subtotald,
		CONVERT(((vd.precio*vd.cantidad)*vd.tasa)/100, DECIMAL(12,2)) AS impsubd,
		CONVERT((((vd.precio*vd.cantidad)*vd.tasa)/100) + (vd.precio*vd.cantidad),DECIMAL(12,2)) AS totald
		FROM tbventad cd
		INNER JOIN tbarticulo a ON a.idarticulo=vd.idarticulo
		INNER JOIN tbdeposito d ON d.iddeposito=vd.iddeposito
		WHERE vd.idventa ='$idventa'";
		return ejecutarConsulta($sql);
	}
}
?>