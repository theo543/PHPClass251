<?php
require("../dblogin.secret.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = mysqli_connect("localhost", $dbuser, $dbpass, "hr");
unset($dbuser, $dbpass);

$_POST["hobby"] = $_POST["hobby"][0];
foreach($_POST as $key => $value) {
    echo "<p>" . htmlspecialchars(strval($key)) . " => " . htmlspecialchars(strval($value)) . "</p>";
}

$fields = array("nume","prenume","stare_civila","zi","luna","an","domiciliu","oras","judet","cod_postal","email","hobby","telefon","fax","vrea_mail","vrea_posta","vrea_fax");
$insert_fields = join(",", $fields);
$insert_params = join(",", array_pad(array(), count($fields), "?"));
$stmt = $link->prepare("INSERT INTO form($insert_fields) VALUES ($insert_params)");
$params = array();
foreach($fields as $field) {
    if((!array_key_exists($field, $_POST)) || (strlen($_POST[$field]) == 0)) {
        array_push($params, NULL);
    } else {
        array_push($params, $_POST[$field]);
    }
}
$stmt->execute($params);

echo "<b>Insert done.</b>";

mysqli_close($link);
