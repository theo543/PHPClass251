<?php
$link = mysqli_connect("localhost", "?", "?", "bazadedate");

if (!$link) {
    echo "Error: Unable to connect to MySQL.";
    exit;
}

$query="SELECT * FROM departments";

echo $query;
/*

foreach ($link->query($query) as $row) {
    print $row['department_id'] . "\t";
    print $row['department_name'] . "\t";
    print $row['location_id'] . "<br>";
}
*/

mysqli_close($link);
?>
