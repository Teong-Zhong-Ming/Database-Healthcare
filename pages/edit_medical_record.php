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

    ########

    $record_id = $_GET['record_id'] ?? null;

    if ($record_id) {
        // Fetch the record using this ID and display/edit it in a form
        $sql = "SELECT m.*, u.Name AS Patient_Name
                FROM Medical_Record m
                JOIN Patient p ON m.Patient_ID = p.Patient_ID
                JOIN [User] u ON p.User_ID = u.User_ID
                WHERE m.Medical_Record_ID = ?";

        $stmt = sqlsrv_query($conn, $sql, [$record_id]);
        $record = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

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
        <section id="edit-medical-record">
            <h2>Edit Medical Record</h2>
            <form action="#" method="post">
                <input type="hidden" name="record_id" value="<?= htmlspecialchars($record['Medical_Record_ID']) ?>">
                
                <!-- Patient Name Dropdown -->
                <label for="patient-name">Patient ID:</label>
                <select id="patient-id" name="patient-id" required>
                    <option value="" disabled selected>Select a patient</option>
                    <?php
                        $selectedPatientId = $record['Patient_ID'];

                        while ($row = sqlsrv_fetch_array($stmtPatientList, SQLSRV_FETCH_ASSOC)) {
                            $patientId = $row['Patient_ID'];
                            $patientName = $row['Name'];
                            $selected = ($patientId === $selectedPatientId) ? "selected" : "";
                            echo "<option value=\"$patientId\" $selected>$patientName ($patientId)</option>";
                        }
                    ?>
                </select>

                <!-- Visit Date -->
                <label for="visit-date">Visit Date:</label>
                <input type="date" id="visit-date" name="visit-date"
                        value="<?= $record['Visit_Date'] ? $record['Visit_Date']->format('Y-m-d') : '' ?>" required>

                <!-- Diagnosis -->
                <label for="diagnosis">Diagnosis:</label>
                <input type="text" id="diagnosis" name="diagnosis" 
                        value="<?= htmlspecialchars($record['Diagnosis']) ?>" required>

                <!-- Prescription -->
                <label for="prescription">Prescription:</label>
                <input type="text" id="prescription" name="prescription" 
                        value="<?= htmlspecialchars($record['Prescription']) ?>" required>

                <!-- Notes -->
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="8"><?= htmlspecialchars($record['Notes']) ?></textarea>

                <!-- Submit Button -->
                <button type="submit">Save Changes</button>
            </form>
        </section>
    </main>

</body>
</html>

<?php 
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $record_id) {
        $patientId     = $_POST['patient-id'];
        $visitDate     = $_POST['visit-date'];
        $diagnosis     = $_POST['diagnosis'];
        $prescription  = $_POST['prescription'];
        $notes         = $_POST['notes'];

        $sqlUpdate = "UPDATE Medical_Record
                    SET Patient_ID = ?, Visit_Date = ?, Diagnosis = ?, Prescription = ?, Notes = ?
                    WHERE Medical_Record_ID = ?";

        $params = [$patientId, $visitDate, $diagnosis, $prescription, $notes, $record_id];
        $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $params);

        if ($stmtUpdate === false) {
            echo "<script>alert('Failed to update record: " . json_encode(sqlsrv_errors()) . "');</script>";
        } else {
            echo "<script>
                    alert('Record updated successfully');
                    window.location.href = 'index.php?page=doctorPage';
                </script>";
            exit;
        }
        sqlsrv_close($conn);
    }
?>