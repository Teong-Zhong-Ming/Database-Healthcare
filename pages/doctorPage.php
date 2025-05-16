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

    ####################
    $user_id = $_SESSION['user_id'];
    $sqlDoctor = "SELECT u.Name,
                         u.Age,
                         d.Doctor_ID,
                         d.Identification_number,
                         d.Contact_number,
                         d.Gender,
                         d.Address,
                         d.Specialization
                         FROM Doctor d
                         Join [User] u On d.User_ID = u.User_ID
                         WHERE d.User_ID = ?";

    $paramsDoctor = array($user_id);
    $stmtDoctor = sqlsrv_query($conn, $sqlDoctor, $paramsDoctor);
    if ($stmtDoctor === false) {
        die("Error fetching doctor data: " . print_r(sqlsrv_errors(), true));
    }

    $doctor = sqlsrv_fetch_array($stmtDoctor, SQLSRV_FETCH_ASSOC);
    $doctor_id = $doctor['Doctor_ID'];

    ####################

    $sqlMedicalRecords = "Select u_patient.Name AS Patient_Name,
                                 p.Patient_ID,
                                 m.Medical_Record_ID,
                                 m.Visit_Date,
                                 m.Diagnosis,
                                 m.Prescription,
                                 m.Notes
                                 From Medical_Record m
                                 Join Patient p On m.Patient_ID = p.Patient_ID
                                 Join [User] u_patient On p.User_ID = u_patient.User_ID
                                 Where m.Doctor_ID = ?
                                 Order By m.Visit_Date DESC";
    $paramsMedicalRecords = array($doctor_id);
    $stmtMedicalRecords = sqlsrv_query($conn, $sqlMedicalRecords, $paramsMedicalRecords);
    if ($stmtMedicalRecords === false) {
        die("Error fetching medical records: " . print_r(sqlsrv_errors(), true));
    }                            
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Best Medical</title>
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
            <li><a href="index.php?page=medical_records">Edit Medical Record</a></li>
            <li><a href="index.php?page=addMediRecord">Add Medical Record</a></li>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="with-sidebar">
        <section id="profile">
            <h2>Doctor Profile</h2>
            <div class="profile-card">
                <h3>Name: <?php echo htmlspecialchars($doctor['Name'])?></h3>
                <p>Doctor ID: <?php echo htmlspecialchars($doctor['Doctor_ID'])?></p>
                <p>Age: <?php echo htmlspecialchars($doctor['Age'])?></p>
                <p>Identification Number: <?php echo htmlspecialchars($doctor['Identification_number'])?></p>
                <p>Contact Number: <?php echo htmlspecialchars($doctor['Contact_number'])?></p>
                <p>Gender: <?php echo htmlspecialchars($doctor['Gender'])?></p>
                <p>Address <?php echo htmlspecialchars($doctor['Address'])?></p>
                <p>Specialization: <?php echo htmlspecialchars($doctor['Specialization'])?></p>
            </div>
        </section>

        <section id="patients">
            <h2>Patients Under Care</h2>
            <ul class="patient-list">
                <?php 
                    while ($row = sqlsrv_fetch_array($stmtMedicalRecords, SQLSRV_FETCH_ASSOC)) {
                        $patient_id = $row['Patient_ID'];
                        $patient_name = $row['Patient_Name'];
                        echo "<li>
                                <h3>Patient: " . htmlspecialchars($patient_name) . "</h3>
                                <p>ID: " . htmlspecialchars($patient_id) . "</p>
                                <a href='#' class='view-details' data-patient-id='" . htmlspecialchars($patient_id) . "'>View Medical Records</a>
                              </li>";
                    }
                ?>
            </ul>
        </section>
    </main>

    <!-- Modal for Medical Records -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Medical Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Diagnosis</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="modal-body">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>


    <script>
        
        document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("modal");
        const closeBtn = document.querySelector(".close");

        // Close modal
        closeBtn.onclick = () => modal.style.display = "none";
        window.onclick = (event) => {
            if (event.target === modal) modal.style.display = "none";
        };

            // Use event delegation for dynamic elements
            document.body.addEventListener("click", function (e) {
                if (e.target.classList.contains("view-details")) {
                    e.preventDefault();
                    const patientId = e.target.dataset.patientId;

                    fetch(`pages/fetch_medical_record.php?patient_id=${patientId}`)
                        .then(response => response.json())
                        .then(records => {
                            const modalBody = document.getElementById("modal-body");
                            modalBody.innerHTML = "";

                            if (!records.length) {
                                modalBody.innerHTML = "<tr><td colspan='4'>No records found</td></tr>";
                            }

                            records.forEach(record => {
                                const row = `<tr>
                                                <td>${record.no}</td>
                                                <td>${record.date}</td>
                                                <td>${record.description}</td>
                                                <td>${record.diagnosis}</td>
                                                <td>${record.note}</td>
                                                <td><button class="edit-btn" data-record-id="${record.id}">Edit</button></td>
                                            </tr>`;
                                modalBody.insertAdjacentHTML("beforeend", row);
                            });

                            modal.style.display = "block";
                        })
                        .catch(error => {
                            console.error("Error fetching records:", error);
                            alert("Could not fetch records.");
                        });
                }
            });

            document.body.addEventListener("click", function (e) {
                if (e.target.classList.contains("edit-btn")) {
                    const recordId = e.target.dataset.recordId;
                    window.location.href = `index.php?page=edit_medical_record&record_id=${recordId}`;
                }
            });
        });
    </script>

</body>
</html>