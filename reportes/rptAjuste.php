<?php
//Incluímos el archivo MasterFact.php;
require('MasterFact.php');

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Alto de Columnas
$colh=7;

//Obtenemos Datos de la empresa
require_once "../modelos/Empresa.php";
$empresa= new Empresa();
$rsptaem = $empresa->listar();
//Recorremos todos los valores obtenidos
$rengem = $rsptaem->fetch_object();
$ext_logo = "jpeg";

//Datos de la empresa de la clase Factura
$pdf->addSocieteP(
    utf8_decode($rengem->desc_empresa),utf8_decode("Rif.: ").$rengem->rif."\n" .
    utf8_decode("Dirección: ").utf8_decode($rengem->direccion)."\n".
    utf8_decode("Teléfono: ").$rengem->telefono."       ".
    "Email: ".$rengem->email,$rengem->imagen1.'.jpg');

//Encabezado del Reporte
require_once "../modelos/Ajuste.php";
$ajuste= new Ajuste();
//Id para Obteneter el Reporte
$rspta = $ajuste->rptAjusteH($_GET["id"]);;

//Recorremos todos los valores obtenidos
$reng = $rspta->fetch_object();
 //Asignamos Valores Correspondientes
$pdf->fact_dev("Ajuste Nro : ","$reng->cod_ajuste");//Nro de Reporte
$pdf->addDate(utf8_decode($reng->tipo),"$reng->fechareg");//Fecha

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresseRpt(
"Usuario.: ".utf8_decode($reng->desc_usuario),
"Descripcion: ".utf8_decode($reng->desc_ajuste),
"","","",15);//7.5 Pixeles por Fila

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta

$cols=array( "Codigo"=>29,
             "Descripcion"=>86,
             "Cant."=>12,
             "Costo"=>30,
             "Total"=>33);
$pdf->addCols( $cols);

$cols=array( "Codigo"=>"L",
             "Descripcion"=>"L",
             "Cant."=>"R",
             "Costo"=>"R",
             "Total"=>"R");
             
$pdf->addLineFormat( $cols);

$pdf->addLineFormat( $cols);



//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 61;

//Obtenemos todos los detalles de la venta actual
$rsptad = $ajuste->rptAjusteD($_GET["id"]);
while ($regd = $rsptad->fetch_object()) {
    $line = array( "Codigo"=> "$regd->cod_articulo",
                  "Descripcion"=> utf8_decode("$regd->desc_articulo"),
                  "Cant."=> "$regd->cantidad",
                  "Costo"=> number_format("$regd->costo",2,",","."),
                  "Total"=> number_format("$regd->totald",2,",","."));
              $size = $pdf->addLine( $y, $line );
              $y   += $size + 2;
}

//Marca de Agua
$marca=$reng->estatus=='Anulado'?"Anulado":"";
$pdf->temporaire(" $marca ");

//Mostramos el impuesto
$pdf->addTVAsRpt("","",number_format("$reng->totalh",2,",","."));
//$pdf->addCadreEurosFrancs("");
$pdf->Output('Ajuste Nro '.$reng->cod_ajuste,'I');
?>