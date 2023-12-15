<?php
//require 'includes/dbh.inc.php'; //conexiunea la baza de date
require dirname(__FILE__) . '/../dblogin.secret.php';
$conn = new mysqli("localhost", $dbuser, $dbpass, "hr");
require 'jpgraph/src/jpgraph.php';
require 'jpgraph/src/jpgraph_bar.php';
$sql = "SELECT job_id, count(employee_id) as angajati from employees 
where job_id is not null GROUP by job_id having count(employee_id)>0;";
$result = $conn->query($sql);
$num_results = $result->num_rows;
$joburi = array();
$angajati = array();
$list = "";
$list .= '<ul>';
for ($i=0; $i <$num_results; $i++) {
   $row = $result->fetch_assoc();
   array_push($joburi,'Job '.$row["job_id"].' ');
   array_push($angajati,intval($row["angajati"]));
   $list .= '<li>Job'.$row["job_id"]."   ".$row["angajati"].'# </li>';
}
$list .=  '</ul>';

$data =[40,60,25,34];

$graph = new Graph(960,660);

$theme_class= new VividTheme;
$graph->SetScale("textlin");
$graph->SetTheme($theme_class);
$graph->SetShadow();

$graph->title->Set('A simple 3D Pie plot');
$graph->title->SetFont(FF_FONT1,FS_BOLD);


$p1 = new BarPlot($angajati);
$p1->SetCenter(0.5);
$graph->xaxis->SetTickLabels($joburi);
$graph->legend->Pos(.088,0.9);

$graph->Add($p1);

if(php_sapi_name() == "cli" && isset($argv[1])) {
   $graph->Stroke($argv[1]);
   exit;
}

$img = $graph->Stroke(_IMG_HANDLER);

ob_start();
imagepng($img);
$imageData = base64_encode(ob_get_contents());
ob_end_clean();

echo '<img src="data:image/png;base64,'.$imageData.'">';
echo $list;
