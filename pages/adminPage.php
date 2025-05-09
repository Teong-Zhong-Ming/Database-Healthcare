<?php
    session_start();
    if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../index.php?page=home");
        exit;
    }
    
    echo "<h1>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h1>";
    echo "<p>Your role is: " . htmlspecialchars($_SESSION['role']) . "</p>";
    echo "<p>Your ID is: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
?>

<h1>Admin Page</h1>
<div>
    <a href="index.php?page=patientRegister">Register Patient</a>
    <a href="index.php?page=doctorRegister">Register Doctor</a>
</div>
<?php 

    
?>

<a href="index.php?page=logout">Logout</a>