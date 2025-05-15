<!DOCTYPE html>
<html lang="en">
<h1>Patient Page</h1>

<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php?page=login");
        exit;
    }

?>


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