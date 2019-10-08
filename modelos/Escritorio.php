<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Escritorio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

    }

    public function TotalClientes()
	{
        $sql="SELECT COUNT(idcliente) AS clie, 
        SUM(saldo) AS saldotc
        FROM tbcliente
        WHERE estatus='1'";
		return ejecutarConsulta($sql);
    }

    public function TotalProveedores()
	{
        $sql="SELECT COUNT(idproveedor) AS prov, 
        SUM(saldo) AS saldotp
        FROM tbproveedor
        WHERE estatus='1'";
		return ejecutarConsulta($sql);
    }

    public function TotalCategorias()
	{
        $sql="SELECT COUNT(idcategoria) AS categoria FROM tbcategoria";
		return ejecutarConsulta($sql);
    }

    public function TotalArticulos()
	{
        $sql="SELECT COUNT(idarticulo) AS articulo FROM tbarticulo";
		return ejecutarConsulta($sql);
    }

    public function TotalStockArticulo()
	{
        $sql="SELECT SUM(cantidad) AS stock FROM tbstock";
		return ejecutarConsulta($sql);
    }
    

    public function TotalPCompra()
	{
        $sql="SELECT
        DATE_FORMAT(pc.fechareg,'%Y') AS fechapc,
        IFNULL(SUM(pc.totalh),0) AS totalpc
        FROM tbcompra pc
        WHERE pc.estatus = 'Registrado' AND pc.tipo='Pedido'
        ORDER BY pc.fechareg DESC LIMIT 0,12";
		return ejecutarConsulta($sql);
    }

    public function TotalFCompra()
	{
        $sql="SELECT
        DATE_FORMAT(fc.fechareg,'%Y') AS fechafc,
        IFNULL(SUM(fc.totalh),0) AS totalfc
        FROM tbcompra fc
        WHERE fc.estatus = 'Registrado'  AND fc.tipo='Factura'
        ORDER BY fc.fechareg DESC LIMIT 0,1";
		return ejecutarConsulta($sql);
    }
    
    public function TotalPVenta()
	{
		$sql="SELECT
        DATE_FORMAT(pv.fechareg,'%Y') AS fechapv,
        IFNULL(SUM(pv.totalh),0) AS totalpv
        FROM tbventa pv
        WHERE pv.estatus = 'Registrado' AND pv.tipo='Pedido'
        ORDER BY pv.fechareg DESC LIMIT 0,1";
		return ejecutarConsulta($sql);
    }

    public function TotalFVenta()
	{
		$sql="SELECT
        DATE_FORMAT(fv.fechareg,'%Y') AS fechafv,
        IFNULL(SUM(fv.totalh),0) AS totalfv
        FROM tbventa fv
        WHERE fv.estatus = 'Registrado' AND fv.tipo='Factura'
        ORDER BY fv.fechareg DESC LIMIT 0,12";
		return ejecutarConsulta($sql);
    }

    
    public function ventasultimos_10dias()
	{
		$sql="SELECT 
        DATE_FORMAT(fechareg,'%d-%m') AS fechav, 
        SUM(totalh) AS totalv
        FROM tbventa
        WHERE estatus='Registrado' AND tipo<>'Cotizacion'
        GROUP BY fechav ORDER BY fechav DESC";
		return ejecutarConsulta($sql);
    }
    
    public function comprasultimos_10dias()
	{
		$sql="SELECT 
        DATE_FORMAT(fechareg,'%d-%m') AS fechac, 
        SUM(totalh) AS totalc
        FROM tbcompra
        WHERE estatus='Registrado'  AND tipo<>'Cotizacion'
        GROUP BY fechac ORDER BY fechac DESC";
		return ejecutarConsulta($sql);
    }
    
    public function ventasultimos_12meses()
	{
		$sql="SELECT 
        DATE_FORMAT(fechareg,'%m-%Y') AS fechayv,
        SUM(totalh) AS totalyv 
        FROM tbventa
        WHERE estatus='Registrado'  AND tipo<>'Cotizacion'
        GROUP BY MONTH(fechareg) ORDER BY fechareg DESC LIMIT 0,12";
		return ejecutarConsulta($sql);
    }

    public function comprasultimos_12meses()
	{
		$sql="SELECT 
        DATE_FORMAT(fechareg,'%m-%Y') AS fechayc,
        SUM(totalh) AS totalyc
        FROM tbcompra
        WHERE estatus='Registrado'  AND tipo<>'Cotizacion'
        GROUP BY MONTH(fechareg) ORDER BY fechareg DESC LIMIT 0,12";
		return ejecutarConsulta($sql);
    }
   
}
?>