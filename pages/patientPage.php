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
    $sqlpatient = "SELECT u.Name,
                          u.age,
                          p.Patient_ID,
                          p.Identification_number,
                          p.Contact_number,
                          p.Gender,
                          p.Address,
                          p.First_visit
                          FROM Patient p
                          Join [User] u On p.User_ID = u.User_ID
                          WHERE p.User_ID = ?";
    $paramsPatient = array($user_id);
    $stmtPatient = sqlsrv_query($conn, $sqlpatient, $paramsPatient);

    if ($stmtPatient === false) {
        die("Error fetching patient data: " . print_r(sqlsrv_errors(), true));
    }

    $patient = sqlsrv_fetch_array($stmtPatient, SQLSRV_FETCH_ASSOC);
    if (!$patient) {
        die("Patient not found");
    }

    // Easily access patient data
    $patient_id = $patient['Patient_ID'];

    // Fetch medical records
    $sqlRecords = "SELECT u_doctor.Name,
                          m.Visit_Date,
                          m.Diagnosis,
                          m.Prescription,
                          m.Notes
                          FROM Medical_Record m
                          Join Doctor d On m.Doctor_ID = d.Doctor_ID
                          Join [User] u_doctor On d.User_ID = u_doctor.User_ID
                          WHERE m.Patient_ID = ?";

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
            <h1>Welcome <?php echo htmlspecialchars($patient['Name']); ?> !</h1>
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
                <h3>Name: <?php echo htmlspecialchars($patient['Name']); ?></h3>
                <p>Patient ID: <?php echo htmlspecialchars($patient_id); ?></p>
                <p>Identification Number: <?php echo htmlspecialchars($patient['Identification_number']); ?></p>
                <p>Contact Number: <?php echo htmlspecialchars($patient['Contact_number']); ?></p>
                <p>Gender: <?php echo htmlspecialchars($patient['Gender']); ?></p>
                <p>Address: <?php echo htmlspecialchars($patient['Address']); ?></p>
                <p>First Visit: <?php echo htmlspecialchars($patient['First_visit']->format('Y-m-d')); ?></p>
            </div>
        </section>

        <section id="medical-records">
            <h2>Medical Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Doctor Name</th>
                        <th>Visit Date</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $counter = 1;
                        while ($record = sqlsrv_fetch_array($stmtRecords, SQLSRV_FETCH_ASSOC)) {
                            // Format the date (SQLSRV returns DateTime objects)
                            
                            echo "<tr>
                                    <td>{$counter}</td>
                                    <td>" . htmlspecialchars($record['Name']) . "</td>
                                    <td>" . htmlspecialchars($record['Visit_Date']->format('Y-m-d')) . "</td>
                                    <td>" . htmlspecialchars($record['Diagnosis']) . "</td>
                                    <td>" . htmlspecialchars($record['Prescription']) . "</td>
                                    <td>" . htmlspecialchars($record['Notes']) . "</td>
                                </tr>";
                            $counter++;
                        }
                        ?>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>