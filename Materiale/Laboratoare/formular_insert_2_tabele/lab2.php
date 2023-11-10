<?php

//sex, stare_civila, hobby
$sex=$_POST['sex'];
$stare=$_POST['stare_civila'];
$hobby=$_POST['hobby'];


echo $sex.'<br/>'.$stare.'<br/>';
print_r($hobby);

$link = mysqli_connect("localhost", "hr", "lab223", "hr");

$qr =' insert into incoming set sex="'.$_POST['sex'].'", stare="'.$_POST['stare_civila'].'"';
$res = $link->query($qr);

$idmain = $link->insert_id;

 

foreach ($_POST['hobby'] as $k=>$v) {
   $qr =' insert into incoming_hobbys set cod_inc="'.$idmain.'", denumire="'.$v.'"';
   $res = $link->query($qr);
}


mysqli_close($link);
?>