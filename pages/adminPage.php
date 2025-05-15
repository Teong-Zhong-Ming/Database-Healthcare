<!DOCTYPE html>
<html lang="en">
<?php

    session_start();
    if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'Admin')) {
        echo '<script>
                alert("You need to login as a ADMIN to access this page");
                window.location.href = "/index.php?page=login";
              </script>';
        exit;
    }

    $serverName = "localhost";
    $connectionInfo = array(
        "Database" => "Healthcare_Database",
        "UID" => "adminUser",
        "PWD" => "admin_password" 
    );

    $conn = sqlsrv_connect($serverName, $connectionInfo);
    if (!$conn) {
        die("DB connection failed:<br>" . print_r(sqlsrv_errors(), true));
    }
    
    echo "<h1>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h1>";
    echo "<p>Your role is: " . htmlspecialchars($_SESSION['role']) . "</p>";
    echo "<p>Your ID is: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
?>

<?php 

    
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Best Medical</title>
    <link rel="stylesheet" href="..\assets\css\style.css">
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
            <li><a href="index.php?page=patientRegister">Register Patient</a></li>
            <li><a href="index.php?page=doctorRegister">Register Doctor</a></li>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="with-sidebar">
        <section id="patients">
            <h2>Patients List</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Identification Number</th>
                        <th>Contact Number</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>First Visit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sqlPatient = "Select 
                                        u.Name,
                                        u.Age,
                                        p.Identification_Number,
                                        p.Contact_number,
                                        p.Gender,
                                        p.Address,
                                        p.First_visit From Patient p
                                        Join [User] u On p.User_ID = u.User_ID
                                        Where u.Role = 'Patient'";
                        $stmtPatient = sqlsrv_query($conn, $sqlPatient);

                        if ($stmtPatient === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        $counter = 1;
                        while ($row = sqlsrv_fetch_array($stmtPatient, SQLSRV_FETCH_ASSOC)) {
                            $dateString = $row['First_visit']->format('Y-m-d H:i:s');
                            echo "<tr>
                                    <td>$counter</td>
                                    <td>".htmlspecialchars($row['Name'])."</td>
                                    <td>".htmlspecialchars($row['Age'])."</td>
                                    <td>".htmlspecialchars($row['Identification_Number'])."</td>
                                    <td>".htmlspecialchars($row['Contact_number'])."</td>
                                    <td>".htmlspecialchars($row['Gender'])."</td>
                                    <td>".htmlspecialchars($row['Address'])."</td>
                                    <td>".htmlspecialchars($dateString)."</td>
                                </tr>";
                            $counter++;
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <section id="doctors">
            <h2>Doctors List</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Doctor Name</th>
                        <th>Age</th>
                        <th>Identification Number</th>
                        <th>Contact Number</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Specialization</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sqlDoctor = "Select 
                                        u.Name,
                                        u.Age,
                                        d.Identification_Number,
                                        d.Contact_number,
                                        d.Gender,
                                        d.Address,
                                        d.Specialization From Doctor d
                                        Join [User] u On d.User_ID = u.User_ID
                                        Where u.Role = 'Doctor'";
                        $stmtDoctor = sqlsrv_query($conn, $sqlDoctor);

                        if ($stmtDoctor === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }

                        $counter = 1;
                        while ($row = sqlsrv_fetch_array($stmtDoctor, SQLSRV_FETCH_ASSOC)) {
                            echo "<tr>
                                    <td>$counter</td>
                                    <td>".htmlspecialchars($row['Name'])."</td>
                                    <td>".htmlspecialchars($row['Age'])."</td>
                                    <td>".htmlspecialchars($row['Identification_Number'])."</td>
                                    <td>".htmlspecialchars($row['Contact_number'])."</td>
                                    <td>".htmlspecialchars($row['Gender'])."</td>
                                    <td>".htmlspecialchars($row['Address'])."</td>
                                    <td>".htmlspecialchars($row['Specialization'])."</td>
                                </tr>";
                            $counter++;
                        }
                    ?>
                    <!-- <tr>
                        <td>D001</td>
                        <td>Dr. Jane Smith</td>
                        <td>Cardiology</td>
                    </tr>
                    <tr>
                        <td>D002</td>
                        <td>Dr. Alex Brown</td>
                        <td>Pediatrics</td>
                    </tr> -->
                </tbody>
            </table>
        </section>

        <section id="medical-records">
            <h2>Medical Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sqlMedical = "SELECT 
                                    u_patient.Name AS PatientName,
                                    u_doctor.Name AS DoctorName,
                                    m.Visit_Date, 
                                    m.Diagnosis,
                                    m.Prescription, 
                                    m.Notes
                                FROM Medical_Record m
                                JOIN Patient p ON m.Patient_ID = p.Patient_ID
                                JOIN [User] u_patient ON p.User_ID = u_patient.User_ID
                                JOIN Doctor d ON m.Doctor_ID = d.Doctor_ID
                                JOIN [User] u_doctor ON d.User_ID = u_doctor.User_ID
                                ORDER BY m.Visit_Date DESC";
                        
                        $stmtMedical = sqlsrv_query($conn, $sqlMedical);
                        
                        if ($stmtMedical === false) {
                            die("Error fetching medical records: " . print_r(sqlsrv_errors(), true));
                        }
                        
                        $counter = 1;
                        while ($row = sqlsrv_fetch_array($stmtMedical, SQLSRV_FETCH_ASSOC)) {
                            $date = $row['Visit_Date']->format('Y-m-d');
                            echo "<tr>
                                    <td>$counter</td>
                                    <td>".htmlspecialchars($row['PatientName'])."</td>
                                    <td>Dr. ".htmlspecialchars($row['DoctorName'])."</td>
                                    <td>".htmlspecialchars($date)."</td>
                                    <td>".htmlspecialchars($row['Diagnosis'])."</td>
                                    <td>".htmlspecialchars($row['Prescription'])."</td>
                                    <td>".htmlspecialchars($row['Notes'])."</td>
                                </tr>";
                        }
                        ?>
                    <!-- <tr>
                        <td>P001</td>
                        <td>2023-01-15</td>
                        <td>Annual Checkup</td>
                        <td>Healthy</td>
                    </tr>
                    <tr>
                        <td>P002</td>
                        <td>2023-02-20</td>
                        <td>Flu Symptoms</td>
                        <td>Influenza</td>
                    </tr> -->
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>