<?php
require('./fpdf/fpdf.php');
//require('../mc_table.php');

class PDF extends FPDF
{

	protected $widths;
    protected $aligns;
	protected $min_nb;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

	function Setnb($m){
		$this->min_nb = $m;
	}


    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		if($this->min_nb > $nb)
			$nb = $this->min_nb;
        $h = 4*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,4,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }






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




function section1(){
	$centru=120;
	$this->setY(70);
	$this->SetTextColor(47,140,158);
	$this->SetFont('Arial','',16);
	$this->Cell(10,8,'FACTURA',0,1,'L');
	$this->SetTextColor(0,0,0);
	$this->SetFont('Arial','',10);
	$this->Cell(38,4,'Seria si numarul facturii:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(15,4,'SRV-1192',0,1,'L');
	$this->SetFont('Arial','',10);
	$this->Cell(38,4,'Data facturii (zi.luna.an):',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(15,4,'26.11.2023',0,1,'L');
	$this->SetFont('Arial','',10);
	$this->Cell(45,4,'Termen de plata (zi.luna.an):',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(1,4,'11.12.2023',0,1,'L');


	$y = $this->GetY();
	$this->setY($y+1.5);
	$x = $this->GetX();
	$this->setX($x+1);

	$this->SetDrawColor(47,140,158);
	$this->SetTextColor(47,140,158);
	$this->SetFont('Arial','',11);
	$this->SetFillColor(206,255,255);
	$this->Cell(58,6,'Plateste online (19.408,90 RON)',1,0,'L', 1, 'https://factureaza.ro/vizualizare/-?');



	$this->setY(60);
	$this->setX($centru);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Arial','B',10);
	$this->Cell(10,4,'Cumparator:',0,2,'L');
	$this->SetTextColor(47,140,158);
	$this->SetFont('Arial','',16);
	$this->Cell(0,8,'S.C. DEMO IMPEX S.R.L.',0,1,'L');
	$this->setX($centru);
	$this->SetTextColor(0,0,0);
	$this->SetFont('Arial','',10);
	$this->Cell(36,4,'Nr. ord. reg. com. / an:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(15,4,'J32/500/2000',0,1,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(8,4,'CIF:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(15,4,'RO 14468355',0,1,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(13,4,'Adresa:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(1,4,'Bdul. Triumfului nr. 4 ap. 2',0,1,'L');
	$this->setX($centru);
	$this->Cell(1,4,'589100 Sibiu, jud. Sibiu, Romania:',0,2,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(12,4,'Banca:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(1,4,'Banca Comerciala Sibiu',0,1,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(10,4,'IBAN:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(1,4,'RO56 RZBR 0000 0600 0329 1177',0,1,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(13,4,'Telefon:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(1,4,'+40 123 789456',0,1,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(9,4,'Email:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->Cell(1,4,' office@factureaza.ro',0,1,'L');
	$this->setX($centru);
	$this->SetFont('Arial','',10);
	$this->Cell(8,4,'Site:',0,0,'L');
	$this->SetFont('Arial','B',10);
	$this->SetLineWidth(0.6);
	$this->SetDrawColor(0, 0, 0);
	$this->Cell(33,4,'www.factureaza.ro','B',1,'L',0,'www.factureaza.ro');


}


function createTable(){
	$dim = array(5, 52, 15, 15, 20, 20, 10, 20, 20);
	$centru=192;	
	$this->setY(120);

	$this->SetDrawColor(47,140,158);
	$this->SetTextColor(0,0,0);
	$this->SetLineWidth(0.1);
	$this->SetFont('Times','', 9);

	$this->Cell(5,4,'Nr.','TRL',0,'C');
	$this->Cell(52,4,'Denumirea produselor sau a','TRL',0,'C');
	$this->Cell(15,4,'U.M.','TRL',0,'C');
	$this->Cell(15,4,'Cant.','TRL',0,'C');
	$this->Cell(20,4,'Pret unitar','TRL',0,'C');
	$this->Cell(20,4,'Valoare','TRL',0,'C');
	$this->Cell(10,4,'Cota','TRL',0,'C');
	$this->Cell(20,4,'Valoare TVA','TRL',0,'C');
	$this->Cell(20,4,'Valoare Totala','TRL',1,'C');
	
	$this->Cell(5,4,'crt','RL',0,'C');
	$this->Cell(52,4,'serviciilor','RL',0,'C');
	$this->Cell(15,4,'','RL',0,'C');
	$this->Cell(15,4,'','RL',0,'C');
	$this->Cell(20,4,'(fara TVA)','RL',0,'C');
	$this->Cell(20,4,'(fara TVA)','RL',0,'C');
	$this->Cell(10,4,'TVA','RL',0,'C');
	$this->Cell(20,4,'-RON-','RL',0,'C');
	$this->Cell(20,4,'-RON-','RL',1,'C');

	$this->Cell(5,4,'','BRL',0,'C');
	$this->Cell(52,4,'','BRL',0,'C');
	$this->Cell(15,4,'','BRL',0,'C');
	$this->Cell(15,4,'','BRL',0,'C');
	$this->Cell(20,4,'RON','BRL',0,'C');
	$this->Cell(20,4,'RON','BRL',0,'C');
	$this->Cell(10,4,'','BRL',0,'C');
	$this->Cell(20,4,'','BRL',0,'C');
	$this->Cell(20,4,'','BRL',1,'C');

	$this->SetFont('Times','B', 9);

	$this->SetWidths($dim);
	$this->SetAligns(array('L', 'L', 'L', 'R', 'R', 'R', 'R', 'R', 'R'));
	$this->Row(array('1', 'Prestari servicii programare cf. ctc. 3482/27.10.2023', 'ore', '86', '185,00', '15.910,00', '19,0', '3.022,90', '18.932,90'));
	$this->Row(array('2', 'Servicii suport cf. ctc. 3482/06.11.2023', 'ore', '4', '70,00', '280,00', '19,0', '53,20', '333,20'));
	$this->Setnb(6);
	$this->Row(array('3', 'Domeniu demo-impex.ro', 'buc', '1', '120,00', '120,00', '19,0', '22,80', '142,80'));
	$this->Setnb(0);
	$this->SetWidths(array($dim[0]+$dim[1]+$dim[2]+$dim[3]+$dim[4], $dim[5], $dim[6], $dim[7], $dim[8]));
	$this->SetAligns(array('C', 'R', 'R', 'R', 'R'));
	$this->Row(array('Subtotaluri -RON-', '16.310,00', '19,0', '3.098,90', '19.408,90'));
	$this->SetWidths(array($dim[0]+$dim[1]+$dim[2]+$dim[3]+$dim[4], $dim[5]+$dim[6]+$dim[7]+$dim[8]));
	$this->SetAligns(array('C', 'R'));
	$this->Row(array('Valoare totala de plata factura curenta - incl. TVA -RON-', '19.408,90'));

	$this->ln(15);
	$this->SetFont('Times','IB',10);
	$this->Cell(10,4,'Speram intr-o colaborare fructuoasa si pe viitor.',0,1,'L');
	$this->Cell(10,4,'Cu stima maxima si virtute absoluta, Ion Pop S.C. DEMO IMPEX S.R.L.',0,1,'L');
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
$pdf->section1();
$pdf->createTable();
$pdf->SetFont('Times','',12);



$pdf->Output();
?>
