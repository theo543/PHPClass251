<?php

//imaginea cu tabla de sah
$newImage="chessBoard.jpg";
$board=imagecreatefromjpeg($newImage);


//deschidem fisierul ce contina configuratia tablei de sah
//o linie din fisier contine, in ordine, numele piesei (P-pion,C-cal,N-nebun,T-tura,Q-regina,R-rege) , culoarea (A-alb, N-negru), randul (A-H) si pozitia ocupate pe tabla de sah(1-8)
$filename="config.txt";
$myfile = fopen($filename, "r") or die("Fisierul nu poate fi deschis");


//am creat vectorul $positions pentru a atribui fiecarui rand un anumit numar
$positions=array(
	'A'=>1,
	'B'=>2,
	'C'=>3,
	'D'=>4,
	'E'=>5,
	'F'=>6,
	'G'=>7,
	'H'=>8
);

$i=0;

//nr de linii din fisier
$nrOfLines=count(file($filename));

while($i!=$nrOfLines)
{
	$confLine=fgets($myfile);
	
	//verificam ce tip de piesa este si ce culoare are	
	if($confLine[0]=="T" && $confLine[1]=="N")
	{
		$piece="turan.png";
	}
	if($confLine[0]=="C" && $confLine[1]=="N")
	{
		$piece="caln.png";
	}

	if($confLine[0]=="Q" && $confLine[1]=="N")
	{
		$piece="reginan.png";
	}

	if($confLine[0]=="N" && $confLine[1]=="N")
	{
		$piece="nebunn.png";
	}

	if($confLine[0]=="P" && $confLine[1]=="N")
	{
		$piece="pionn.png";
	}

	if($confLine[0]=="R" && $confLine[1]=="N")
	{
		$piece="regen.png";
	}

	if($confLine[0]=="T" && $confLine[1]=="A")
	{
		$piece="turaa.png";
	}
	if($confLine[0]=="C" && $confLine[1]=="A")
	{
		$piece="cala.png";
	}

	if($confLine[0]=="Q" && $confLine[1]=="A")
	{
		$piece="reginaa.png";
	}

	if($confLine[0]=="N" && $confLine[1]=="A")
	{
		$piece="nebuna.png";
	}

	if($confLine[0]=="P" && $confLine[1]=="A")
	{
		$piece="piona.png";
	}

	if($confLine[0]=="R" && $confLine[1]=="A")
	{
		$piece="regea.png";
	}

	//adaugam piesa pe tabla de sah
	$stamp=imagecreatefrompng($piece);
	$sx = imagesx($stamp);
	$sy = imagesy($stamp);

	$marge_right=70*$confLine[3];
	$marge_bottom=70*$positions[$confLine[2]]-1;

	imagecopy($board, $stamp, imagesx($board) - $sx - $marge_right, imagesy($board) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

	//crestem nr de linii
	$i++;
	
}

//cream imaginea finala a tablei de sah
header('Content-type:image/png');
imagejpeg($board);
imagedestroy($board);


fclose($myfile);
?>
