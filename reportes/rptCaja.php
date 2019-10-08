<?php
//Incluímos el archivo Factura.php
require('ReportesG.php');

//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Empresa.php";
$empresa= new Empresa();
$rsptaem = $empresa->listar();
//Recorremos todos los valores obtenidos
$rengem = $rsptaem->fetch_object();
//Formato para la Imagen de la Empresa
$ext_logo = "jpg";

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->SetFont('Tahoma','','8');
$pdf->AddPage();

//Alto de Columnas
$colh=6;

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteP(
    utf8_decode($rengem->desc_empresa),utf8_decode("Rif.: ").$rengem->rif."\n" .
    utf8_decode("Dirección: ").utf8_decode($rengem->direccion)."\n".
    utf8_decode("Teléfono: ").$rengem->telefono."       ".
    "Email: ".$rengem->email,$rengem->imagen1);

$pdf->addDate2($rengem->fecharpt, $rengem->timerpt, 'Pagina '.$pdf->PageNo().'/{nb}');

$pdf->SetFont('Arial','','10');
$pdf->SetTextColor(0);
$pdf->SetDrawColor(254,255,254);
$pdf->fact_devP("Listado de Cajas ","" );
$pdf->SetFont('Tahoma','','10');
$pdf->Ln(40);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Caja.php";
$caja = new Caja();

$rspta = $caja->rptListar();

$fill = true;
$pdf->SetFont('Arial','','10');
$pdf->SetTextColor(0);
$pdf->SetDrawColor(254,255,254);
$pdf->Cell(5,$colh, 'R', 'LRB', 0,'C',$fill);
$pdf->Cell(15,$colh, 'Codigo','LRB', 0,'C',$fill);
$pdf->Cell(49,$colh, 'Descripcion', 'LRB', 0,'C',$fill);
$pdf->Cell(20,$colh, 'Moneda', 'LRB', 0,'C',$fill);
$pdf->Cell(28,$colh, 'S. Efectivo', 'LRB', 0,'C',$fill);
$pdf->Cell(28,$colh, 'S. Documentos', 'LRB', 0,'C',$fill);
$pdf->Cell(28,$colh, 'Total', 'LRB', 0,'C',$fill);
$pdf->Cell(18,$colh, 'Estatus', 'LRB', 0,'C',$fill);
$pdf->Ln();
$contador=0;
$totalreg=0;

$fill = false;
while ($row = $rspta->fetch_assoc()) {

    // Colores, ancho de línea y fuente en negrita;
    $pdf->SetTextColor(0);

    $pdf->SetLineWidth(0.5);
    $pdf->SetFont('Arial','','8');


    $yl='L';//alineacion
    $yb='B';//Negrita
    $yr='R';//Alineacion Numeros
    $pdf->Cell(5,$colh,($contador+1).'',$yb,0,'',$fill);
    $pdf->Cell(15,$colh, ' '.utf8_decode($row['cod_caja']),$yb,0,$yl,$fill);
    $pdf->Cell(49,$colh, ' '.utf8_decode($row['desc_caja']),$yb,0,$yl,$fill);
    $pdf->Cell(20,$colh, ' '.utf8_decode($row['desc_moneda']),$yb,0,$yl,$fill);
    $pdf->Cell(28,$colh,number_format($row['saldoefectivo'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(28,$colh,number_format($row['saldodocumento'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(28,$colh,number_format($row['saldototal'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(18,$colh, utf8_decode(($row['estatus']==1)? 'Activo' : 'Inactivo'),$yb,0,'C',$fill);
    $contador++;
    $totalreg=$contador;

    $pdf->Ln();
    $fill = !$fill;
}

$pdf->SetFont('Arial','B','10');
$pdf->SetDrawColor(0);
$pdf->SetAutoPageBreak(-5);
$fill = false;
$pdf->SetY(-25);
$pdf->Cell(0,10,' Total Registros : '.$totalreg,$yb,0,$yl,$fill);
$pdf->AliasNbPages();
$pdf->Output('Listado de Cajas','I');
?>