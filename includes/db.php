<?php
$serverName = "localhost";
$connectionInfo = array("Database" => "YourDB", "UID" => "your_user", "PWD" => "your_password");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}
?>