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
$pdf->fact_devP("Listado de Zonas ","" );
$pdf->SetFont('Tahoma','','10');
$pdf->Ln(40);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Zona.php";
$zona = new Zona();

$rspta = $zona->rptListar();

$fill = true;
$pdf->SetFont('Arial','','10');
$pdf->SetTextColor(0);
$pdf->SetDrawColor(254,255,254);
$pdf->Cell(5,$colh, 'R', 'LRB', 0,'C',$fill);
$pdf->Cell(30,$colh, 'Codigo','LRB', 0,'C',$fill);
$pdf->Cell(135,$colh, 'Descripcion', 'LRB', 0,'C',$fill);
$pdf->Cell(20,$colh, 'Estatus', 'LRB', 0,'C',$fill);
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
    $pdf->Cell(30,$colh, ' '.utf8_decode($row['cod_zona']),$yb,0,$yl,$fill);
    $pdf->Cell(135,$colh, ' '.utf8_decode($row['desc_zona']),$yb,0,$yl,$fill);
    $pdf->Cell(20,$colh, utf8_decode(($row['estatus']==1)? 'Activo' : 'Inactivo'),$yb,0,'C',$fill);
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
$pdf->Output('Listado de Zonas','I');
?>