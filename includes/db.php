<?php
    $serverName = "localhost";
    $connectionInfo = array("Database" => "Healthcare_Database", 
                            "UID" => "roleChecker", 
                            "PWD" => "password123");
    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if (!$conn) {
        echo "Connection failed:<br>";
        die(print_r(sqlsrv_errors(), true));
    } 
?>