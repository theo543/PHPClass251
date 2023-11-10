<html>
<head>
<title>Form Submit</title>
</head>
<?php

$ip = $_SERVER["REMOTE_ADDR"];
$username = $_POST["username"];
$email = $_POST["email"];

if(strlen($username) == 0) {
    echo "Username cannot be blank.";
} else if(strlen($email) == 0) {
    echo "Please enter an email.";
} else {

    include($_SERVER['DOCUMENT_ROOT'] . "/connect.php");
    $link = connect_to_db();

    $stmt = $link->prepare("INSERT INTO accounts (ip, username, email) VALUES (?, ?, ?)");
    $parameters = array($ip, $username, $email);

    echo "<p>";

    try {
        $stmt->execute($parameters);
        echo "<b>Insert done.</b>";
    } catch (Exception $e) {
        echo "<b><h1>Insert failed.</h1></b>";
        echo $e;
    }

    echo "</p>";
}

mysqli_close($link);

?>

<p><a href=..>Back to homepage</a></p>

</html>
