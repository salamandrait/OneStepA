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
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->SetFont('Tahoma','','8');
$pdf->AddPage();

//Alto de Columnas
$colh=6;

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteL(
    utf8_decode($rengem->desc_empresa),utf8_decode("Rif.: ").$rengem->rif."\n" .
    utf8_decode("Dirección: ").utf8_decode($rengem->direccion)."\n".
    utf8_decode("Teléfono: ").$rengem->telefono."       ".
    "Email: ".$rengem->email,$rengem->imagen1);

$pdf->addDate2($rengem->fecharpt, $rengem->timerpt, 'Pagina '.$pdf->PageNo().'/{nb}');

$pdf->SetDrawColor(254,255,254);
$pdf->fact_devL("Listado de Articulos ","");

$pdf->SetFont('Tahoma','','10');
$pdf->Ln(40);


    //Comenzamos a crear las filas de los registros según la consulta mysql
    require_once "../modelos/Articulo.php";
    $articulo = new Articulo();

    $rspta = $articulo->rptListar();

    $fill = true;
    //la suma total de las columas es 277
    $pdf->SetFont('Arial','','10');
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(254,255,254);
    $pdf->Cell(5,$colh, 'R', 'LRB', 0,'C',$fill);
    $pdf->Cell(22,$colh, 'Codigo', 'LRB', 0,'C',$fill);
    $pdf->Cell(76,$colh, 'Descripcion', 'LRB', 0,'C',$fill);
    $pdf->Cell(16,$colh, 'Unidad', 'LRB', 0,'C',$fill);
    $pdf->Cell(16,$colh, 'Stock', 'LRB', 0,'C',$fill);
    $pdf->Cell(30,$colh, 'Costo ', 'LRB', 0,'C',$fill);
    $pdf->Cell(10,$colh, 'Tasa', 'LRB', 0,'C',$fill);
    $pdf->Cell(28,$colh, 'Precio 1', 'LRB', 0,'C',$fill);
    $pdf->Cell(28,$colh, 'Precio 2', 'LRB', 0,'C',$fill);
    $pdf->Cell(28,$colh, 'Precio 3', 'LRB', 0,'C',$fill);
    $pdf->Cell(18,$colh, 'Estatus', 'LRB', 0,'C',$fill);
    $pdf->Ln();
    $contador=0;
    $sumacosto1=0;
    $sumaprecio1=0;
    $sumaprecio2=0;
    $sumaprecio3=0;
    

    $pdf->SetFillColor(200,200,200);
    $fill = false;
    while ($row = $rspta->fetch_assoc()) {

        // Colores, ancho de línea y fuente en negrita; 
        $pdf->SetTextColor(0);

        $pdf->SetLineWidth(0.5);
        $pdf->SetFont('Arial','','8');

    $yl='L';//alineacion
    $yb='B';//Negrita
    $yr='R';//Alineacion Numeros

    //la suma total de las columas es 277
    $pdf->Cell(5,$colh,($contador+1).'',$yb,0,'',$fill);
    $pdf->Cell(22,$colh,' '.$row['cod_articulo'],$yb,0,'',$fill);
    $pdf->Cell(76,$colh, ' '.$row['desc_articulo'],$yb,0,$yl,$fill);
    $pdf->Cell(16,$colh,$row['cod_unidad'],$yb,0,'C',$fill);
    $pdf->Cell(16,$colh, ''.number_format($row['stock'],0).' ',$yb,0,$yr,$fill);
    $pdf->Cell(30,$colh,number_format($row['costo1'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(10,$colh,number_format($row['tasa'],0).' ',$yb,0,'C',$fill);
    $pdf->Cell(28,$colh,number_format($row['precio1'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(28,$colh,number_format($row['precio2'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(28,$colh,number_format($row['precio3'],2,",",".").' ',$yb,0,$yr,$fill);
    $pdf->Cell(18,$colh, utf8_decode(($row['estatus']==1)? 'Activo' : 'Inactivo'),$yb,0,'C',$fill);
    $contador++;
    $sumacosto1+=$row['costo1'];
    $sumaprecio1+=$row['precio1'];
    $sumaprecio2+=$row['precio2'];
    $sumaprecio3+=$row['precio3'];
    $pdf->Ln();
    $fill = !$fill;
    
   }

$pdf->SetFont('Arial','B','10');
$pdf->SetDrawColor(0);
$pdf->SetAutoPageBreak(-5);
$pdf->addTVAsRpt("","","","","","","","",number_format($sumacosto1,2,",","."),"-81",number_format($sumaprecio1,2,",","."),"4",number_format($sumaprecio2,2,",","."),"34",number_format($sumaprecio2,2,",","."),"64","20");

$pdf->AliasNbPages();
$pdf->Output('Listado de Articulos','I');
?>