<?php
require('../fpdf181/fpdf.php');
define('EURO', chr(128) );
define('EURO_VAL', 6.55957 );


//////////////////////////////////////
// Public functions                 //
//////////////////////////////////////
//  function sizeOfText( $texte, $larg )
//  function addSociete( $nom, $adresse )
//  function fact_dev( $libelle, $num )
//  function addDevis( $numdev )
//  function addFacture( $numfact )
//  function addDate( $date )
//  function addClient( $ref )
//  function addPageNumber( $page )
//  function addClientAdresse( $adresse )
//  function addReglement( $mode )
//  function addEcheance( $date )
//  function addNumTVA($tva)
//  function addReference($ref)
//  function addCols( $tab )
//  function addLineFormat( $tab )
//  function lineVert( $tab )
//  function addLine( $ligne, $tab )
//  function addRemarque($remarque)
//  function addCadreTVAs()
//  function addCadreEurosFrancs()
//  function addTVAs( $params, $tab_tva, $invoice )
//  function temporaire( $texte )

class PDF_Invoice extends FPDF
{
// private variables
var $colonnes;
var $format;
var $angle=0;

// private functions
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
	$k = $this->k;
	$hp = $this->h;
	if($style=='F')
		$op='f';
	elseif($style=='FD' || $style=='DF')
		$op='B';
	else
		$op='S';
	$MyArc = 4/3 * (sqrt(2) - 1);
	$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
	$xc = $x+$w-$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

	$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
	$xc = $x+$w-$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
	$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
	$xc = $x+$r ;
	$yc = $y+$h-$r;
	$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
	$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
	$xc = $x+$r ;
	$yc = $y+$r;
	$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
	$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
	$this->_out($op);
}

function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
	$h = $this->h;
	$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
						$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}

function Rotate($angle, $x=-1, $y=-1)
{
	if($x==-1)
		$x=$this->x;
	if($y==-1)
		$y=$this->y;
	if($this->angle!=0)
		$this->_out('Q');
	$this->angle=$angle;
	if($angle!=0)
	{
		$angle*=M_PI/180;
		$c=cos($angle);
		$s=sin($angle);
		$cx=$x*$this->k;
		$cy=($this->h-$y)*$this->k;
		$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
	}
}

function _endpage()
{
	if($this->angle!=0)
	{
		$this->angle=0;
		$this->_out('Q');
	}
	parent::_endpage();
}

// public functions
function sizeOfText( $texte, $largeur )
{
	$index    = 0;
	$nb_lines = 0;
	$loop     = TRUE;
	while ( $loop )
	{
		$pos = strpos($texte, "\n");
		if (!$pos)
		{
			$loop  = FALSE;
			$ligne = $texte;
		}
		else
		{
			$ligne  = substr( $texte, $index, $pos);
			$texte = substr( $texte, $pos+1 );
		}
		$length = floor( $this->GetStringWidth( $ligne ) );
		$res = 1 + floor( $length / $largeur) ;
		$nb_lines += $res;
	}
	return $nb_lines;
}

// Company
function addSocieteP($nom,$adresse,$logo)
{
	$r1  = $this->w - 200;
	$r2  = $r1 + 190;
	//alineacion Horizontal
	$x1 = 15;
	$y1 = 10;
    $y2  = $y1 + 16;
	$this->RoundedRect(10, 10, 137, $y2, 2, 'D');	
	//Positionnement en bas
	//$this->Image($logo, 11 ,11, 24 , 24 , $ext_logo);
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','B',9);
	$length = $this->GetStringWidth($nom );
	$this->Cell( $length,10, $nom);
	$this->SetXY( $x1, $y1 + 7 );
	$this->SetFont('Arial','',9);
	$length = $this->GetStringWidth($adresse);
	//Coordonnes de la socit
	$lignes = $this->sizeOfText( $adresse, $length) ;
	$this->MultiCell($length, 6, $adresse);
}

// Company
function addSocieteL( $nom, $adresse,$logo)
{
	$r1  = $this->w - 287;
    $r2  = $r1 + 277;
	$x1 = 15;
	$y1 = 10;
    $y2  = $y1 + 16;
	$this->RoundedRect(10, 10, 224, $y2, 2, 'D');	
	//Positionnement en bas
	//$this->Image($logo , 11 ,11, 24 , 24 , $ext_logo);
	$this->SetXY( $x1, $y1 );
	$this->SetFont('Arial','B',9);
	$length = $this->GetStringWidth($nom );
	$this->Cell( $length,10, $nom);
	$this->SetXY( $x1, $y1 + 7 );
	$this->SetFont('Arial','',9);
	$length = $this->GetStringWidth( $adresse );
	//Coordonnes de la socit
	$lignes = $this->sizeOfText( $adresse, $length) ;
	$this->MultiCell($length, 6, $adresse);
}

// Label and number of invoice/estimate
function fact_devP( $libelle, $num )
{
    $r1  = $this->w - 200;
    $r2  = $r1 + 190;
    $y1  = 6;
    $y2  = $y1 + 0;
    $mid = ($r1 + $r2 ) / 2;
    
    $texte  = $libelle  . $num;    
    $szfont = 10;
    $loop   = 0;
    
    while ( $loop == 0 )
    {
       $this->SetFont( "Arial", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }

    $this->SetLineWidth(0.2);
    $this->SetFillColor(180,180,180);
    $this->RoundedRect($r1,38, ($r2 - $r1), $y2, 1, 'DF');
    $this->SetXY( $r1+8, $y1+2);
    $this->Cell($r2-$r1 -8,68, $texte, 0, 0, "C" );
}

// Label and number of invoice/estimate
function fact_devL( $libelle, $num )
{
    $r1  = $this->w - 287;
    $r2  = $r1 + 277;
    $y1  = 6;
    $y2  = $y1 + 0;
    $mid = ($r1 + $r2 ) / 2;
    
    $texte  = $libelle  . $num;    
    $szfont = 10;
    $loop   = 0;
    
    while ( $loop == 0 )
    {
       $this->SetFont( "Arial", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }

    $this->SetLineWidth(0.35);
    $this->SetFillColor(180,180,180);
    $this->RoundedRect($r1,38, ($r2 - $r1), $y2, 1, 'DF');
    $this->SetXY( $r1+8, $y1+2);
    $this->Cell($r2-$r1 -8,68, $texte, 0, 0, "C" );
}

// Estimate
function addDevis( $numdev )
{
	$string = sprintf("DEV%04d",$numdev);
	$this->fact_dev( "Devis", $string );
}

// Invoice
function addFacture( $numfact )
{
	$string = sprintf("FA%04d",$numfact);
	$this->fact_dev( "Facture", $string );
}

function addDate1( $date )
{
	$r1  = $this->w - 61;
	$r2  = $r1 + 51;
	$y1  = 16;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2, 'D');
	$this->Line( $r1, 24, $r2,24);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 10);
	$this->Cell(8,5, "Fecha", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "Arial", "", 9);
	$this->Cell(8,5,$date, 0,0, "C");
}

function addDate2( $date, $time ,$page)
{
	$r1  = $this->w - 61;
	$r2  = $r1 + 51;
	$y1  = 26;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, 10, ($r2 - $r1), $y2, 2, 'D');
	$this->Line( $r1,27,$r2,27);
	$this->Line( $r1,19,$r2,19);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 10);
	$this->Cell(-2,-11, "Fecha", 0, 0, "R");
	$this->Cell(25,-11, "Hora", 0, 0, "R");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
	$this->SetFont( "Arial", "", 10);
	$this->Cell(1,-8,$date, 0,0, "R");
	$this->Cell(25,-8,$time, 0,0, "R");
	$this->SetFont( "Arial", "B", 12);
	$this->Cell(-5,-40,$page, 0,0, "R");
}


function addClient( $ref )
{
	$r1  = $this->w - 31;
	$r2  = $r1 + 19;
	$y1  = 17;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);

	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 9);
	$this->Cell(10,5, "CLIENTE", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
	$this->SetFont( "Arial", "", 9);
	$this->Cell(10,5,$ref, 0,0, "C");
}

function addPageNumber( $page )
{
	$r1  = $this->w - 80;
	$r2  = $r1 + 19;
	$y1  = 17;
	$y2  = $y1;
	$mid = $y1 + ($y2 / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
	$this->SetFont( "Arial", "B", 9);
	$this->Cell(10,5, "PAGE", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
	$this->SetFont( "Arial", "", 9);
	$this->Cell(10,5,$page, 0,0, "C");
}

// Client address
function addClientAdresse( $cliente,$num_documento,$domicilio,$email,$telefono )
{

	$r1     = $this->w - 200;
	$r2     = $r1 + 68;
	$y1     = 35;
	$y2  = $y1;
	$this->SetFillColor(255,255,255);
	$this->RoundedRect($r1, $y1, 190, 30, 2, 'DF');
	$this->SetXY( $r1, $y1);
	$this->SetFont( "Arial", "B", 9);
	$this->MultiCell( 60, 4, "");
	$this->SetXY( $r1+2, $y1+3);
	$this->SetFont( "Arial", "", 9);
	$this->MultiCell( 190, 4, $cliente,0);
	$this->SetXY( $r1+2, $y1+10);
	$this->MultiCell( 30, 4, $num_documento,0);
	$this->SetXY( $r1+2, $y1+17);
	$this->MultiCell( 190, 4, $domicilio,0);
	$this->SetXY( $r1+2, $y1+24);
	$this->MultiCell( 100, 4, $telefono,0);
	$this->SetXY( 130, $y1+24);
	$this->MultiCell( 190, 4, $email,0);	
}
// Mode of payment
function addReglement( $mode )
{
	$r1  = 10;
	$r2  = $r1 + 60;
	$y1  = 80;
	$y2  = $y1+10;
	$mid = $y1 + (($y2-$y1) / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1+1 );
	$this->SetFont( "Arial", "B",9);
	$this->Cell(10,4, "CLIENTE", 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1 + 5 );
	$this->SetFont( "Arial", "", 9);
	$this->Cell(10,5,$mode, 0,0, "C");
}

// Expiry date
function addEcheance( $documento,$numero )
{
	$r1  = 80;
	$r2  = $r1 + 40;
	$y1  = 80;
	$y2  = $y1+10;
	$mid = $y1 + (($y2-$y1) / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + ($r2 - $r1)/2 - 5 , $y1+1 );
	$this->SetFont( "Arial", "B", 9);
	$this->Cell(10,4, $numero, 0, 0, "C");
	$this->SetXY( $r1 + ($r2-$r1)/2 - 5 , $y1 + 5 );
	$this->SetFont( "Arial", "", 9);
	$this->Cell(10,5,$numero, 0,0, "C");
}

// VAT number
function addNumTVA($tva)
{
	$this->SetFont( "Arial", "B", 10);
	$r1  = $this->w - 80;
	$r2  = $r1 + 70;
	$y1  = 80;
	$y2  = $y1+10;
	$mid = $y1 + (($y2-$y1) / 2);
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
	$this->Line( $r1, $mid, $r2, $mid);
	$this->SetXY( $r1 + 16 , $y1+1 );
	$this->Cell(40, 4, "DIRECCION", '', '', "C");
	$this->SetFont( "Arial", "", 9);
	$this->SetXY( $r1 + 16 , $y1+5 );
	$this->Cell(40, 5, $tva, '', '', "C");
}

function addReference($ref)
{
	$this->SetFont( "Arial", "", 10);
	$length = $this->GetStringWidth( "R�f�rences : " . $ref );
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = 92;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, "R�f�rences : " . $ref);
}

function addCols( $tab )
{
	global $colonnes;
	
	$r1  = 10;
	$r2  = $this->w - ($r1 * 2) ;
	$y1  = 70;
	$y2  = $this->h - 50 - $y1;
	$this->SetXY( $r1, $y1 );
	$this->Rect( $r1, $y1, $r2, $y2, "D");
	$this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
	$colX = $r1;
	$colonnes = $tab;
	while ( list( $lib, $pos ) = each ($tab) )
	{
		
		$this->SetXY( $colX, $y1+2 );
		$this->Cell( $pos, 1, $lib, 0, 0, "C");
		$colX += $pos;
		$this->Line( $colX, $y1, $colX, $y1+$y2);
		
	}
	$this->SetFillColor(55,55,55);
}

function addColsL( $tab, $altura )
{
	global $colonnes;
	
	$r1  = 10;
	$r2  = $this->w - ($r1 * 2) ;
	$y1  = $altura;
	$y2  = $this->h - 50 - $y1;
	$this->SetXY( $r1, $y1 );
	$this->Rect( $r1, $y1, $r2, $y2, "D");
	$this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
	$colX = $r1;
	$colonnes = $tab;
	while ( list( $lib, $pos ) = each ($tab) )
	{
		$this->SetXY( $colX, $y1+2 );
		$this->Cell( $pos, 1, $lib, 0, 0, "C");
		$colX += $pos;
		$this->Line( $colX, $y1, $colX, $y1+$y2);
	}
}

function addLineFormat( $tab )
{
	global $format, $colonnes;
	
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		if ( isset( $tab["$lib"] ) )
			$format[ $lib ] = $tab["$lib"];
	}
}

function lineVert( $tab )
{
	global $colonnes;

	reset( $colonnes );
	$maxSize=0;
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		$texte = $tab[ $lib ];
		$longCell  = $pos -2;
		$size = $this->sizeOfText( $texte, $longCell );
		if ($size > $maxSize)
			$maxSize = $size;
	}
	return $maxSize;
}

// add a line to the invoice/estimate
/*    $ligne = array( "REFERENCE"    => $prod["ref"],
                      "DESIGNATION"  => $libelle,
                      "QUANTITE"     => sprintf( "%.2F", $prod["qte"]) ,
                      "P.U. HT"      => sprintf( "%.2F", $prod["px_unit"]),
                      "MONTANT H.T." => sprintf ( "%.2F", $prod["qte"] * $prod["px_unit"]) ,
                      "TVA"          => $prod["tva"] );
*/
function addLine( $ligne, $tab )
{
	global $colonnes, $format;

	$ordonnee     = 10;
	$maxSize      = $ligne;

	reset( $colonnes );
	while ( list( $lib, $pos ) = each ($colonnes) )
	{
		$longCell  = $pos -2;
		$texte     = $tab[ $lib ];
		$length    = $this->GetStringWidth( $texte );
		$tailleTexte = $this->sizeOfText( $texte, $length );
		$formText  = $format[ $lib ];
		$this->SetXY( $ordonnee, $ligne-1);
		$this->MultiCell( $longCell, 4 , $texte, 0, $formText);
		if ( $maxSize < ($this->GetY()  ) )
			$maxSize = $this->GetY() ;
		$ordonnee += $pos;
	}
	return ( $maxSize - $ligne );
}

function addRemarque($remarque)
{
	$this->SetFont( "Arial", "", 10);
	$length = $this->GetStringWidth( "Remarque : " . $remarque );
	$r1  = 10;
	$r2  = $r1 + $length;
	$y1  = $this->h - 45.5;
	$y2  = $y1+5;
	$this->SetXY( $r1 , $y1 );
	$this->Cell($length,4, "Remarque : " . $remarque);
}

function addCadreTVAs($monto)
{
	$this->SetFont( "Arial", "B", 8);
	$r1  = 10;
	$r2  = $r1 + 113;
	$y1  = $this->h - 45;
	$y2  = $y1+20;
	$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2, 'D');
	$this->SetXY( $r1+9, $y1+3);
	$this->Cell(10,4, "Importe Total");
	$this->SetFont( "Arial", "", 8);
	$this->SetXY( $r1+9, $y1+7);
	$this->MultiCell(100,4, $monto);
}

function addCadreEurosFrancs($impuesto)
{
	$r1  = $this->w - 75;
	$r2  = $r1 + 75;
	$y1  = $this->h - 45;
	$y2  = $y1+20;
	$this->RoundedRect(125, $y1, ($r2 - $r1), ($y2-$y1), 2, 'D');
	$this->Line( $r1+20,  $y1, $r1+20, $y2); // avant EUROS
	//$this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
	//$this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
	$this->SetFont( "Arial", "B", 9);
	$this->SetXY( $r1+22, $y1 );
	$this->SetFont( "Arial", "", 9);
	//$this->SetXY( $r1+42, $y1 );
	//$this->Cell(15,4, "FRANCS", 0, 0, "C");
	$this->SetFont( "Arial", "B", 9);
	$this->SetXY( $r1, $y1+1 );
	$this->Cell(20,4, "SUBTOTAL Bs.:", 0, 0, "R");
	$this->SetXY( $r1, $y1+8 );
	$this->Cell(20,4, $impuesto, 0, 0, "R");
	$this->SetXY( $r1, $y1+15 );
	$this->Cell(20,4, "TOTAL Bs.:", 0, 0, "R");
}

function addCadreEurosFrancsL($impuesto,$xl )
{
	$r1  = $this->w - 100;
	$r2  = $r1 + 162;
	$y1  = $this->h - 48;
	$y2  = $y1+10;
	$this->RoundedRect($xl, $y1, ($r2 - $r1), ($y2-$y1), 2, 'D');

	//$this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
	//$this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
	$this->SetFont( "Arial", "B", 9);
	$this->SetXY( $r1+22, $y1 );
	$this->SetFont( "Arial", "", 9);
	//$this->SetXY( $r1+42, $y1 );
	//$this->Cell(15,4, "FRANCS", 0, 0, "C");
	$this->SetFont( "Arial", "B", 9);
	$this->SetXY( $r1, $y1+8 );
	$this->Cell(20,4, "SUBTOTAL Bs.:", 0, 0, "R");
	$this->SetXY( $r1, $y1+8 );
	$this->Cell(20,4, $impuesto, 0, 0, "R");
	$this->SetXY( $r1, $y1+8 );
	$this->Cell(20,4, "TOTAL Bs.:", 0, 0, "R");
}

// remplit les cadres TVA / Totaux et la remarque
// params  = array( "RemiseGlobale" => [0|1],
//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
//                      "remise"         => value,     // {montant de la remise}
//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
//                  "FraisPort"     => [0|1],
//                      "portTTC"        => value,     // montant des frais de ports TTC
//                                                     // par defaut la TVA = 19.6 %
//                      "portHT"         => value,     // montant des frais de ports HT
//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
//                  "AccompteExige" => [0|1],
//                      "accompte"         => value    // montant de l'acompte (TTC)
//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
//                  "Remarque" => "texte"              // texte
// tab_tva = array( "1"       => 19.6,
//                  "2"       => 5.5, ... );
// invoice = array( "px_unit" => value,
//                  "qte"     => qte,
//                  "tva"     => code_tva );
function addTVAs($subtotal, $iva, $total,$moneda )
{
	$this->SetFont('Arial','',9);
	$re  = $this->w - 30;
	$rf  = $this->w - 29;
	$y1  = $this->h - 40;
	$this->SetFont( "Arial", "B", 10);
	$this->SetXY( $re, $y1-4 );
	$this->Cell( 17,4, $moneda.number_format($subtotal,2,",","."), '0', '0', 'R');
	$this->SetXY( $re, $y1+3 );
	$this->Cell( 17,4, $moneda.number_format($iva,2,",","."), '0', '0', 'R');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	$this->SetXY( $re, $y1+10 );
	$this->Cell( 17,4, $moneda.number_format($total,2,",","."), '0', '0', 'R');	
}

function addTVAsL($yl1,$yl2,$yl3,$xl,$subtotal, $iva, $total,$moneda )
{
	$this->SetFont('Arial','',9);
	$re  = $this->w - 40;
	$rf  = $this->w - 40;
	$y1  = $this->h - 40;
	$this->SetFont( "Arial", "B", 10);
	$this->SetXY( $re, $y1);
	$this->Cell($yl1,$xl, $moneda.number_format($subtotal,2,",","."), '0', '0', 'R');
	$this->SetXY( $re, $y1);
	$this->Cell($yl2,$xl, $moneda.number_format($iva,2,",","."), '0', '0', 'R');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	$this->SetXY( $re, $y1);
	$this->Cell($yl3,$xl, $moneda.number_format($total,2,",","."), '0', '0', 'R');	
}

// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
function temporaire( $texte )
{
	$this->SetFont('Arial','B',50);
	$this->SetTextColor(203,203,203);
	$this->Rotate(45,55,190);
	$this->Text(55,190,$texte);
	$this->Rotate(0);
	$this->SetTextColor(0,0,0);
}

function addTVAsRpt($item1,$ylinea1,$item2,$ylinea2,$item3,$ylinea3,$item4,$ylinea4,$item5,$ylinea5,$item6,$ylinea6,$item7,$ylinea7,$item8,$ylinea8,$yposicion)
{
	
	$re  = $this->w - 30;
	$rf  = $this->w - 30;
	$y1  = $this->h - 52;
	$r1  = $this->w - 75;
	$r2  = $r1 + 277;
	$y1  = $this->h - $yposicion;
	//$y1  = $this->h - 25;
	$y2  = $y1+10;
	$this->RoundedRect(10, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');

	$this->SetXY( $re, $y1+4);
	$this->Cell(-240,4, "Totales ", 0, 0, "R");
	
	$this->SetXY( $re, $y1+4);
	$this->Cell( $ylinea1,4, $item1, '0', '0', 'R');

	$this->SetXY( $re, $y1+4);
	$this->Cell( $ylinea2,4, $item2, '0', '0', 'R');

	$this->SetXY( $re, $y1+4);
	$this->Cell( $ylinea3,4, $item3, '0', '0', 'R');

	$this->SetXY( $re, $y1+4);
	$this->Cell( $ylinea4,4, $item4, '0', '0', 'R');

	$this->SetXY( $re, $y1+4);
	$this->Cell( $ylinea5,4, $item5, '0', '0', 'R');

	$this->SetXY( $r1, $y1+4 );
	$this->Cell( $ylinea6,4, $item6, '0', '0', 'R');

	$this->SetXY( $r1, $y1+4 );
	$this->Cell( $ylinea7,4, $item7, '0', '0', 'R');

	$this->SetXY( $r1, $y1+4 );
	$this->Cell( $ylinea8,4, $item8, '0', '0', 'R');
}



}
?>
