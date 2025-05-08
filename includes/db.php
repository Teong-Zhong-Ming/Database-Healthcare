<?php
$serverName = "localhost";
$connectionInfo = array("Database" => "Healthcare_Database", 
                        "UID" => "test1", 
                        "PWD" => "password123");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn) {
    echo "Connection failed:<br>";
    die(print_r(sqlsrv_errors(), true));
} else {
    // Connection successful
    // You can now execute queries or perform other database operations
    echo "Connected to the database successfully.";
}
?>