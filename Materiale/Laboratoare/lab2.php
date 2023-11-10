<?php



$link = mysqli_connect("localhost", "hr", "lab223", "hr");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}



if(count($_POST)>0) {
            $nume=$_POST['nume'];
$prenume=$_POST['prenume'];
$sex=$_POST['sex'];	

$query="insert into formular(nume,prenume,sex) 
values('".$nume."','".$prenume."','".$sex."');";

            $link->query($query);
			$_POST = array();
			header("Location: lab2.php");		
		    exit();
}


mysqli_close($link);

?>