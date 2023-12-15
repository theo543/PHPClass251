<?php
//require 'includes/dbh.inc.php'; //conexiunea la baza de date
$conn = new mysqli("localhost","root","lab223","hr");
require 'jpgraph/src/jpgraph.php';
require 'jpgraph/src/jpgraph_pie.php';
require 'jpgraph/src/jpgraph_pie3d.php';
$sql = "SELECT department_id, count(employee_id) as angajati from employees 
where department_id is not null GROUP by department_id having count(employee_id)>0;";
$result = $conn->query($sql);
$num_results = $result->num_rows;
$joburi = array();
$angajati = array();
for ($i=0; $i <$num_results; $i++) {
   $row = $result->fetch_assoc();
   array_push($joburi,'Dep'.$row["department_id"].' ');
   array_push($angajati,intval($row["angajati"]));
   echo 'Dep'.$row["department_id"]."   ".$row["angajati"].'# ';}

$fimg ='jpgraph-3d_pie.png';

$data =[40,60,25,34];

$graph = new PieGraph(960,660);

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);
$graph->SetShadow();

$graph->title->Set('A simple 3D Pie plot');
$graph->title->SetFont(FF_FONT1,FS_BOLD);


$p1 = new PiePlot3D($angajati);
$p1->ExplodeSlice(1);
$p1->SetCenter(0.5);
$p1->SetLegends($joburi);
$graph->legend->Pos(.088,0.9);

$graph->Add($p1);
$graph->Stroke($fimg);

if(file_exists($fimg)) echo '<img src="'. $fimg .'" />';
else echo 'Unable to create: '. $fimg;
