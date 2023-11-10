<?php
function connect_to_db() {
    // Login to the database
    // dblogin must set $dbuser and $dbpass variables
    include($_SERVER['DOCUMENT_ROOT'] . "/../dblogin.php");
    // Report all errors.
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $link = mysqli_connect("localhost", $dbuser, $dbpass, "Lab4");
    unset($dbuser, $dbpass);
    return $link;
}
