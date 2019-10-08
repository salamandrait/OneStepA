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
$pdf = new PDF_Invoice( 'L', 'mm', 'A4' );
$pdf->AddPage();

//Alto de Columnas
$colh=7;

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteL(
    utf8_decode($rengem->desc_empresa),utf8_decode("Rif.: ").$rengem->rif."\n" .
    utf8_decode("Dirección: ").utf8_decode($rengem->direccion)."\n".
    utf8_decode("Teléfono: ").$rengem->telefono."       ".
    "Email: ".$rengem->email,$rengem->imagen1);

$pdf->addDate2($rengem->fecharpt, $rengem->timerpt, 'Pagina '.$pdf->PageNo().'/{nb}');

$pdf->fact_devL("Listado de Ajustes ","" );
$pdf->Ln(40);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Ajuste.php";
$ajuste = new Ajuste();

$rspta = $ajuste->rptGeneral();

$fill = true;

//la suma total de las columas es 277 
$pdf->Cell(25,$colh,  'Codigo','LRB', 0,'C',$fill);
$pdf->Cell(132,$colh, 'Descripcion', 'LRB', 0,'C',$fill);
$pdf->Cell(25,$colh, 'Tipo', 'LRB', 0,'C',$fill);
$pdf->Cell(25,$colh, 'Estatus', 'LRB', 0,'C',$fill);
$pdf->Cell(40,$colh, 'Total', 'LRB', 0,'C',$fill);
$pdf->Cell(30,$colh, 'Fecha', 'LRB', 0,'C',$fill);
$pdf->Ln();

while ($row = $rspta->fetch_assoc()) {

    // Colores, ancho de línea y fuente en negrita;
    $pdf->SetFillColor(0);
    $pdf->SetTextColor(0);

    $pdf->SetLineWidth(.30);
    $pdf->SetFont('Arial','I');

$fill = false;

$yl='L';
$yb='B';
$yc='C';
$yr='R';
$pdf->Cell(25,$colh, ' '.$row['cod_ajuste'],$yb,0,$yl,$fill);
$pdf->Cell(132,$colh, ''.$row['desc_ajuste'],$yb,0,$yl,$fill);
$pdf->Cell(25,$colh, ' '.$row['tipo'],$yb,0,$yl,$fill);
$pdf->Cell(25,$colh, ' '.$row['estatus'],$yb,0,$yl,$fill);
$pdf->Cell(40,$colh, ''.number_format($row['totalh'],2,",","."),$yb,0,$yr,$fill);
$pdf->Cell(30,$colh, ''.$row['fechareg'],$yb,0,$yc,$fill);
$pdf->Ln();
$fill = !$fill;
}


$pdf->AliasNbPages();
$pdf->Output('Listado de Ajustes','I');
?>