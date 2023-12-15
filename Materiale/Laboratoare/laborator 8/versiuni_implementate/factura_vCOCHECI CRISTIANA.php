<?php
require('./fpdf/fpdf.php');

class PDF extends FPDF
{
	// Page header
	function Header()
	{

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
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-25);
		$centru=192;	
		$this->SetDrawColor(47,140,158);
		$this->SetTextColor(0,0,0);
		$this->SetLineWidth(0.1);
		$this->SetFont('Times','B',7);
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


$pdf->SetFont('Times','',12);
//for($i=1;$i<=40;$i++)
    //$pdf->Cell(0,10,'Printing line number '.$i,0,1);

//body of page
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100);
$pdf->Cell(100, 4, 'Cumparator: ',0,1);

$pdf->SetTextColor(47,140,158);
$pdf->SetFont('Arial','',20);
//$pdf->Cell(0,10,'S.C. DEMO IMPEX S.R.L.',0,1,'L');
// Output text in a 6 cm width column

$pdf->Cell(100,10,'FACTURA',0,0);
$pdf->Cell(100,10,'S.C. DEMO IMPEX S.R.L.',0,1);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,4,'Seria si numarul facturii: SRV-1192',0,0);
$pdf->Cell(100,4,'Nr. ord. reg. com./ an: J32/500/2000',0,1);

$pdf->Cell(100,4,'Data facturii (zi.luna.an): 26.11.2023',0,0);
$pdf->Cell(100,4,'CIF: RO 14468355',0,1);

$pdf->Cell(100,4,'Termen de plata (zi.luna.an) 11.12.2023',0,0);
$pdf->MultiCell(70,4,'Adresa: Bdul Triumfului nr. 4 ap 2 589100 Sibiu, jud. Sibiu, Romania',0,1);

//buton
$pdf->SetFillColor(240,255,255);
$pdf->SetTextColor(47,140,158);
$pdf->Rect($pdf->getX(),$pdf->getY(),60,5,'DF');
$pdf->Image('factura-logo.png', $pdf->getX(),$pdf->getY(), 5, 5);
$pdf->Cell(5);
$pdf->Cell(55,5,'Plateste online (19.408,90 RON)',0,0,'L',false,'www.factureaza.ro');

$pdf->Cell(40);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(70,4,'Banca: Banca Comerciala Sibiu',0,1);
$pdf->Cell(100);
$pdf->Cell(170,4,'IBAN: RO56 RZBR 0000 0600 0329 1177',0,1);
$pdf->Cell(100);
$pdf->Cell(170,4,'Telefon: +40 123 789456',0,1);
$pdf->Cell(100);
$pdf->Cell(170,4,'Email: office@factureaza.ro',0,1);
$pdf->Cell(100);
$pdf->Cell(40,4,'Site: www.factureaza.ro','B',1,'L',false,'www.factureaza.ro');
$pdf->Ln();

//tabel

$height = 15;
$header = array('Nr. crt', 'Denumirea produselor sau a serviciilor', 'U.M.', 'Cant.', 'Pret unitar (fara TVA)  -RON-', 'Valoare (fara tVA) -RON-', 'Cota TVA', 'Valoare TVA -RON', ' Valoarea totala -RON-');
$lines = file('tabel_pdf.txt');
$data = array();
foreach($lines as $line)
        $data[] = explode(';',trim($line));

	$pdf->SetFillColor(47,140,158);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(128,0,0);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('','B');
    // Header
    $w = array(8, 50, 15, 25, 25, 15,15, 15, 15);
	$x= $pdf->getX();
	$y= $pdf->getY();
    for($i=0;$i<count($header);$i++){
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[$i],$height*2,'DF');
        $pdf->MultiCell($w[$i],7,$header[$i],0,'C');
		$x+= $w[$i];
	}
    $pdf->SetFillColor(240,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    // Data
    $fill = true;
	$y= $pdf->getY();
	
	$height = 6;
    foreach($data as $row)
    {
		$x= $pdf->getX();
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[0],$height*2,'DF');
        $pdf->MultiCell($w[0],$height,$row[0],0,'C');
		

		$x+=$w[0];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[1],$height*2,'DF');
        $pdf->MultiCell($w[1],$height,$row[1],0,'L',0);
		$x+=$w[1];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[2],$height*2,'DF');
		$pdf->MultiCell($w[2],$height,$row[2],0,'C',0);
		$x+=$w[2];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[3],$height*2,'DF');
        $pdf->MultiCell($w[3],$height,number_format($row[3]),0,'R',0);
		$x+=$w[3];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[4],$height*2,'DF');
        $pdf->MultiCell($w[4],$height,number_format($row[4]),0,'R',0);
		$x+=$w[4];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[5],$height*2,'DF');
		$pdf->MultiCell($w[5],$height,number_format($row[5]),0,'R',0);
		$x+=$w[5];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[6],$height*2,'DF');
		$pdf->MultiCell($w[6],$height,number_format($row[6]),0,'R',0);
		$x+=$w[6];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[7],$height*2,'DF');
		$pdf->MultiCell($w[7],$height,number_format($row[7]),0,'R',0);
		$x+=$w[7];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[8],$height*2,'DF');
		$pdf->MultiCell($w[8],$height,number_format($row[8]),0,'R',0);
        //$pdf->Ln();
		$y += 2*$height;
    }
	$x= $pdf->getX();
	$pdf->setXY($x, $y);
	$pdf->Rect($x,$y,$w[0]+$w[1]+$w[2]+$w[3]+$w[4],$height*2,'DF');
	$pdf->Multicell($w[0]+$w[1]+$w[2]+$w[3]+$w[4],$height, 'Subtotaluri -RON-',0,'C',0);
		$x+=$w[0]+$w[1]+$w[2]+$w[3]+$w[4];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[5],$height*2,'DF');
		$pdf->MultiCell($w[5],$height,number_format('16310'),0,'R',0);
		$x+=$w[5];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[6],$height*2,'DF');
		$pdf->MultiCell($w[6],$height,number_format('19'),0,'R',0);
		$x+=$w[6];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[7],$height*2,'DF');
		$pdf->MultiCell($w[7],$height,number_format('3098'),0,'R',0);
		$x+=$w[7];
		$pdf->setXY($x, $y);
		$pdf->Rect($x,$y,$w[8],$height*2,'DF');
		$pdf->MultiCell($w[8],$height,number_format('19408'),0,'R',0);

	$x= $pdf->getX();
	$y += 2*$height;
	$pdf->setXY($x, $y);
	$pdf->Rect($x,$y,$w[0]+$w[1]+$w[2]+$w[3]+$w[4],$height*2,'DF');
	$pdf->Multicell($w[0]+$w[1]+$w[2]+$w[3]+$w[4],$height, 'Valoarea totala de plata factura curenta - incl. TVA -RON-',0,'C',0);
	$x+=$w[0]+$w[1]+$w[2]+$w[3]+$w[4];
	$pdf->setXY($x, $y);
	$pdf->Rect($x,$y,$w[5]+$w[6]+$w[7]+$w[8],$height*2,'DF');
	$pdf->Multicell($w[5]+$w[6]+$w[7]+$w[8],$height, number_format('19408'),0,'R',0);


// $pdf->MultiCell(4, 4, 'Nr. crt', 1, 0);
// $pdf->Cell(4);
// $pdf->MultiCell(20, 4, 'Denumirea produselor sau a serviciilor', 1, 0);
// $pdf->Cell(24);
// $pdf->MultiCell(20, 4, 'U.M.', 1, 0);
// $pdf->Cell(44);
// $pdf->MultiCell(20, 4, 'Cant.', 1, 0);
// $pdf->Cell(64);
// $pdf->MultiCell(20, 4, 'Pret unitar (fara TVA)  -RON-', 1, 0);
// $pdf->Cell(84);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
for($i=0;$i<3;$i++)
	$pdf->Ln();
$pdf->Cell(100,4,'Speram intr-o colaborarea frumoasa si pe viitor',0,1);
$pdf->Cell(100,4,'Cu stima si maxima virtute absoluta, Ion Pop S.C. DEMO IMPEX S.R.L',0,1);

$pdf->Ln();

$pdf->Output();
?>
