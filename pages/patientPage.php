<h1>Patient Page</h1>

<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

?>

<a href="index.php?page=logout">Logout</a>