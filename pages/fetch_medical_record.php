<?php

    session_start();
    if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'Doctor')) {
        echo '<script>
                alert("You need to login as a DOCTOR to access this page");
                window.location.href = "/index.php?page=login";
              </script>';
        exit;
    }

    $serverName = "localhost";
    $connectionInfo = array(
        "Database" => "Healthcare_Database",
        "UID" => "doctorUser",
        "PWD" => "doctor_password"
    );

    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if (!$conn) {
        die(json_encode(["error" => "Database connection failed"]));
    }

    $patient_id = $_GET['patient_id'] ?? '';

    $sql = "SELECT Medical_Record_ID, Visit_Date, Diagnosis, Prescription, Notes FROM Medical_Record WHERE Patient_ID = ?";
    $stmt = sqlsrv_query($conn, $sql, [$patient_id]);

    $records = [];

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $row['Visit_Date'] = $row['Visit_Date']->format('Y-m-d');
        $records[] = [
            "no" => count($records) + 1,
            "id" => $row['Medical_Record_ID'],
            "date" => $row['Visit_Date'],
            "description" => $row['Prescription'],
            "diagnosis" => $row['Diagnosis'],
            "note" => $row['Notes']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($records);
?>