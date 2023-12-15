<?php
require('./fpdf/fpdf.php');

class PDF extends FPDF
{
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
function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
    $h = $this->h;
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}
// Page header
function Header() {
	$this->SetTextColor(47,140,158);
	$this->SetFont('Arial','',22);
	$this->Cell(0,10,'S.C. Cubus Arts S.R.L.',0,1,'L');
	$this->SetTextColor(0,0,0);
	$this->SetFont('Arial','',10);
	$this->Cell(37,4,'Nr. ord. reg. com. / an:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(0,4,'J32/508/2000',0,1,'L');
	$this->SetFont('Arial','',10);
	$this->Cell(8,4,'CIF:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(0,4,'RO 13548146',0,1,'L');
	$this->SetFont('Arial','',10);
	$this->Cell(13,4,'Adresa:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(0,4,'Strada Morii 198',0,1,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(0,4,'892200 Lugojoara, jud. Timis, Romania',0,1,'L');
	$this->SetFont('Arial','',10);
	$this->Cell(14,4,'Telefon:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(0,4,'0368 409 233',0,1,'L');
	$this->SetFont('Arial','',10);
	$this->Cell(10,4,'Email:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(0,4,'office@factureaza.ro',0,1,'L'); 
	$this->SetFont('Arial','',10);
	$this->Cell(9,4,'Site: ',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->SetLineWidth(0.6);
	$this->Cell(26,4,'www.cubus.ro','B',1,'L',0,'https://www.cubus.ro');
	$this->SetLineWidth(0.1);
	$this->SetDrawColor(47,140,158);
	$this->Cell(0,5,' ','B',1,'L');

	$this->SetTextColor(47,140,158);
	$this->Image('factura-logo.png', 155, 22, 30, 21);

	$this->Ln(20);
}

// Page footer
function Footer() {
	// Position at 1.5 cm from bottom
	$this->SetY(-25);
	$centru=192;	
	$this->SetDrawColor(47,140,158);
	$this->SetTextColor(0,0,0);
	$this->SetLineWidth(0.1);
	$this->SetFont('Times','',7);
	$this->Cell($centru/3,5,'S.C. Cubus Arts S.R.L.','T',0,'L');
	$this->Cell($centru/3,5,'Adresa: Strada Morii 198','T',0,'L');
	$this->Cell($centru/3,5,'mail: office@factureaza.ro','T',1,'L');
	$this->Cell($centru/3,1,'Nr. ord. reg. com. / an: J32/508/2000',0,0,'L');
	$this->Cell($centru/3,1,'892200 Lugojoara, jud. Timis, Romania',0,0,'L');
	$this->Cell($centru/3,1,'Site: www.cubus.ro',0,1,'L');
	$this->Cell($centru/3,5,'CIF: RO 13548146','B',0,'L');
	$this->Cell($centru/3,5,'Telefon: 0368 409 233','B',0,'L');
	$this->Cell($centru/3,5,' ','B',1,'L');
	$this->ln(3);

	$this->SetTextColor(205,205,205);
	$this->Cell($centru/3,5,'creat prin factureaza.ro',0,0,'L');
}
}

$pdf = new PDF('P','mm','A4');

//A4 => w:210 h: 297
$left=9;
$right=9;
$pdf->SetLeftMargin($left);
$pdf->SetRightMargin($right);
$centru=192;
$pdf->AddPage();

//Factura
	$pdf->SetTextColor(47,140,158);
	$pdf->SetFont('Arial','',22);
	$pdf->Cell(0,10,'Factura',0,1,'L');

	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(40,4,'Seria si numarul facturii: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'SRV-1192',0,1,'L');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(40,4,'Data facturii (zi.luna.an): ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'08.12.2023',0,1,'L');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(47,4,'Termen de plata (zi.luna.an): ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'11.12.2023',0,1,'L');
	$pdf->SetFillColor(207,255,255);
	$pdf->SetDrawColor(47,140,158);
	$pdf->SetTextColor(47,140,158);
	$pdf->Ln();
	$pdf->RoundedRect($pdf->getX(), $pdf->getY(), 55, 4, 1, 'DF');
	$pdf->Cell(55,4,'Plateste Online (19.408,90 RON)', 0, 1, 'L', false, 'https://factureaza.ro/');
$y = $pdf->getY();
$x = 110;

//Cumparator
	$pdf->setXY($x, 70);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'Cumparator',0,1,'L');

	$pdf->setX($x);
	$pdf->SetTextColor(47,140,158);
	$pdf->SetFont('Arial','',22);
	$pdf->Cell(0,10,'S.C. DEMO IMPEX S.R.L.',0,1,'L');

	$pdf->SetTextColor(0,0,0);

	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(37,4,'Nr. ord. reg. com. / an: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'J32/500/2000',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(8,4,'CIF: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'RO 14468355',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(13,4,'Adresa: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'Bdul. Triumfului nr. 4 ap. 2',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'589100 Sibiu, jud. Sibiu, Romania',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(13,4,'Banca: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'Banca Comerciala Sibiu',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,4,'IBAN: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'RO56 RZBR 0000 0600 0329 1177',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(13,4,'Telefon: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'+40 123 789456',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,4,'Email: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,4,'office@factureaza.ro',0,1,'L');
	$pdf->setX($x);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(8,4,'Site: ',0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(32,4,'www.factureaza.ro ','B',1,'L');
	$pdf->SetDrawColor(47,140,158);

$pdf->Ln();	
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

$y = $pdf->getY();
$x = $pdf->getX();
$widths = [20, 50, 15, 15, 20, 20, 10, 20, 20];
$content = [['Nr. crt', 'Denumirea produselor sau a serviciilor', 'U.M.', 'Cant.', 'Pret unitar (fara TVA) -RON-', 'Valoare (fara TVA) -RON-', 'Cota TVA', 'Valoare TVA -RON-', 'Valoare Totala -RON-'], 
['1', 'Prestari servicii programare cf. ctc. 3482/27.10.2023', 'ore', '86', '185,00', '15.910,00', '190', '3.022,90', '18.932,90'],
['2', 'Servicii suport cf. ctc. 3482/06.11.2023', 'ore', '4', '70,00', '280,00', '19,0', '53,20', '333,20'],
['3', 'Domeniu demo-impex.ro', 'buc', '1', '120,00', '120,00', '19,0', '22,80', '142,80']];
$breaks = [3, 2, 2, 2];

$h = 5;
$prev_x = $pdf->getX();
$pdf->SetDrawColor(47,140,158);
for($j = 0; $j < sizeof($content); $j++){
	for ($i=0; $i < sizeof($widths) ; $i++) { 
		$pdf->Rect($x,$y,$widths[$i], $h * $breaks[$j]);
		$pdf->setXY($x, $y);
		$pdf->MultiCell($widths[$i], $h, $content[$j][$i],0,'C');
		$x = $x + $widths[$i];	
	}
	$pdf->SetFont('Arial','B',10);
	$y = $y + $h * $breaks[$j];
	$x = $prev_x;
}
$widths2 = [120, 20, 10, 20, 20];
$widths3 = [120, 70];
$content2 = ['Subtotaluri -RON-', '16.310,00', '19,0', '3.098,90', '19.408,90'];
$content3 = ['Valoare totala de plata factura curenta - incl. TVA -RON-', '19.408,90'];

for ($i=0; $i < sizeof($widths2) ; $i++) { 
	$pdf->Rect($x,$y,$widths2[$i], $h);
	$pdf->setXY($x, $y);
	$pdf->MultiCell($widths2[$i], $h, $content2[$i],0,'C');
	$x = $x + $widths2[$i];	
}
$y = $y + $h;
$x = $prev_x;
for ($i=0; $i < sizeof($widths3) ; $i++) { 
	$pdf->Rect($x,$y,$widths3[$i], $h);
	$pdf->setXY($x, $y);
	$pdf->MultiCell($widths3[$i], $h, $content3[$i],0,'C');
	$x = $x + $widths3[$i];	
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0, 4,'Speram intr-o colaborare fructuoasa si pe viitor.',0,1);
$pdf->Cell(0, 4,'Cu stima maxima si virtute absoluta, Ion Pop S.C. DEMO IMPEX S.R.L',0,1);

$pdf->Output();
?>
