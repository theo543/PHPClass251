<html>
<head>
<title> Admin Control Panel </title>
</head>

<body>

<?php
    echo "Welcome to the admin panel.";
    include($_SERVER['DOCUMENT_ROOT'] . "/connect.php");
    $link = connect_to_db();
    $accounts = $link->query("SELECT * FROM accounts");
    foreach($accounts as $account) {
        echo "<p>";
        print_r($account);
        echo "</p>";        
    }
?>

</body>

</html>