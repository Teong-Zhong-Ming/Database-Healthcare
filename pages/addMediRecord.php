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
        die("DB connection failed:<br>" . print_r(sqlsrv_errors(), true));
    }

    #######

    $user_id = $_SESSION['user_id'];
    $sqlDoctor = "Select Doctor_ID From Doctor Where User_ID = ?";
    $paramsDoctor = array($user_id);
    $stmtDoctor = sqlsrv_query($conn, $sqlDoctor, $paramsDoctor);

    if ($stmtDoctor === false) {
        die("Error fetching doctor data: " . print_r(sqlsrv_errors(), true));
    }

    $doctor = sqlsrv_fetch_array($stmtDoctor, SQLSRV_FETCH_ASSOC);
    if (!$doctor) {
        die("Doctor not found");
    }

    $doctorId = $doctor['Doctor_ID'];

    ########

    $sqlPatientList = " SELECT p.Patient_ID, u.Name
                        FROM Patient p
                        JOIN [User] u ON p.User_ID = u.User_ID";
    $stmtPatientList = sqlsrv_query($conn, $sqlPatientList);
    if ($stmtPatientList === false) {
        die("Error fetching patient list: " . print_r(sqlsrv_errors(), true));
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records - Best Medical</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Best Medical Logo">
            <h1>Best Medical</h1>
        </div>
    </header>
     <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="index.php?page=doctorPage">Back to Doctor Dashboard</a></li>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>
    <!-- Main Content -->
    <main class="with-sidebar">
        <section id="add-medical-record">
            <h2>Add Medical Record</h2>
            <form action="#" method="post">
                <!-- Patient Name Dropdown -->
                <label for="patient-id">Patient ID:</label>
                <select id="patient-id" name="patient-id" required>
                    <option value="" disabled selected>Select a patient</option>
                        <?php
                            while ($row = sqlsrv_fetch_array($stmtPatientList, SQLSRV_FETCH_ASSOC)) {
                                $patientId = $row['Patient_ID'];
                                $patientName = htmlspecialchars($row['Name']);
                                echo "<option value=\"$patientId\">$patientName ($patientId)</option>";
                            }
                        ?>
                </select>

                <!-- Visit Date -->
                <label for="visit-date">Visit Date:</label>
                <input type="date" id="visit-date" name="visit-date" required>

                <!-- Diagnosis -->
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis" placeholder="Enter diagnosis" required>

                <!-- Prescription -->
                <label for="prescription">Prescription:</label>
                <input type="text" id="prescription" name="prescription" placeholder="Enter prescription" required>

                <!-- Notes -->
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="6" placeholder="Add additional notes"></textarea>

                <!-- Submit Button -->
                <button type="submit">Save Record</button>
            </form>
        </section>
    </main>

</body>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $patientId = $_POST['patient-id'];
    $visitDate = $_POST['visit-date'];
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];
    $notes = $_POST['notes'];


    // Prepare SQL statement
    $sql = "INSERT INTO Medical_Record (Patient_ID, Doctor_ID, Visit_Date, Diagnosis, Prescription, Notes)
            VALUES (?, ?, ?, ?, ?, ?)";

    $params = array($patientId, $doctorId, $visitDate, $diagnosis, $prescription, $notes);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error inserting medical record: " . print_r(sqlsrv_errors(), true));
    } else {
        echo "<script>alert('Medical record added successfully'); window.location.href='index.php?page=doctorPage';</script>";
        exit;
    }
}

?>