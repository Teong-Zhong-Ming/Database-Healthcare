<?php 
    session_start();
    if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'Patient')) {
        echo '<script>
                alert("You need to login as a PATIENT to access this page");
                window.location.href = "/index.php?page=login";
              </script>';
        exit;
    }

    $serverName = "localhost";
    $connectionInfo = array(
        "Database" => "Healthcare_Database",
        "UID" => "patientUser",
        "PWD" => "patient_password" 
    );

    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if (!$conn) {
        die("DB connection failed:<br>" . print_r(sqlsrv_errors(), true));
    }

    $user_id = $_SESSION['user_id'];
    $sqlpatient = "SELECT * FROM Patient WHERE User_ID = ?";
    $paramsPatient = array($user_id);
    $stmtPatient = sqlsrv_query($conn, $sqlpatient, $paramsPatient);

    if ($stmtPatient === false) {
        die("Error fetching patient data: " . print_r(sqlsrv_errors(), true));
    }

    $patient = sqlsrv_fetch_array($stmtPatient, SQLSRV_FETCH_ASSOC);
    $patient_id = $patient['Patient_ID'];

    if (!$patient) {
        die("Patient not found");
    }

    // Fetch medical records
    $sqlRecords = "SELECT * FROM Medical_Record WHERE patient_id = ? ORDER BY Visit_Date DESC";
    $paramsMedicalRecords = array($patient_id);
    $stmtRecords = sqlsrv_query($conn, $sqlRecords, $paramsMedicalRecords);

    if ($stmtRecords === false) {
        die("Error fetching medical records: " . print_r(sqlsrv_errors(), true));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Best Medical</title>
    <link rel="stylesheet" href="..\assets\css\style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Best Medical Logo">
            <h1>Best Medical</h1>
            <h1>Welcome () !</h1>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="with-sidebar">
        <section id="profile">
            <h2>Patient Profile</h2>
            <div class="profile-card">
                <h3>Name: John Doe</h3>
                <p>ID: P001</p>
                <p>Date of Birth: 1990-05-15</p>
                <p>Email: john.doe@example.com</p>
            </div>
        </section>

        <section id="medical-records">
            <h2>Medical Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2023-01-15</td>
                        <td>Annual Checkup</td>
                        <td>Healthy</td>
                    </tr>
                    <tr>
                        <td>2023-02-20</td>
                        <td>Flu Symptoms</td>
                        <td>Influenza</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>