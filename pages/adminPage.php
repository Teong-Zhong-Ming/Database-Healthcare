<!DOCTYPE html>
<html lang="en">
<?php
/*
    session_start();
    if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../index.php?page=home");
        exit;
    }
    
    echo "<h1>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h1>";
    echo "<p>Your role is: " . htmlspecialchars($_SESSION['role']) . "</p>";
    echo "<p>Your ID is: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
    */
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
            <li><a href="index.php?page=adminRegister">Register Admin</a></li>
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>P001</td>
                        <td>John Doe</td>
                        <td>john.doe@example.com</td>
                    </tr>
                    <tr>
                        <td>P002</td>
                        <td>Alice Johnson</td>
                        <td>alice.johnson@example.com</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="doctors">
            <h2>Doctors List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Specialization</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>D001</td>
                        <td>Dr. Jane Smith</td>
                        <td>Cardiology</td>
                    </tr>
                    <tr>
                        <td>D002</td>
                        <td>Dr. Alex Brown</td>
                        <td>Pediatrics</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="medical-records">
            <h2>Medical Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
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
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>