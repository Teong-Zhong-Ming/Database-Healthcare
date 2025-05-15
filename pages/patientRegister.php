<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Best Medical</title>
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
            <li><a href="index.php?page=adminPage">Back to Admin Dashboard</a></li>
            <li><a href="index.php?page=logout" class="logout">Log Out</a></li>
        </ul>
    </aside>
<main class="with-sidebar">
<section id="create-account">
    <h1>Patient Register</h1>

    <form method="post" action="">
        <label for="name">Name:</label>
            <input type="text" id="name" name="name">
        <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        <label for="age">Age:</label>
            <input type="number" id="age" name="age">
        <label for="identification_number">Identification Number:</label>
            <input type="text" id="identification_number" name="identification_number">
        <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number">
        <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="NTS">Prefer Not To Say</option>
            </select>
        <label for="address">Address:</label>
            <input type="text" id="address" name="address">
        <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="Patient" readonly>
        <button type="submit" name="registerbtn" value="registerbtn">Register</button>
    </form>
</section>
</main>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerbtn'])) {

    include __DIR__ . '/../includes/db.php';

    // get admin id
    $sqlGetAdmin = "SELECT Admin_ID FROM Admin WHERE User_ID = ?";
    $paramsGetAdmin = array($user_id);
    $stmtGetAdmin = sqlsrv_query($conn, $sqlGetAdmin, $paramsGetAdmin);
    
    if ($stmtGetAdmin === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if (sqlsrv_fetch($stmtGetAdmin)) {
        $admin_id = sqlsrv_get_field($stmtGetAdmin, 0);
    } else {
        die("Admin not found in Admin table");
    }

    // User info
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $role = $_POST['role'];

    // Patient-specific info
    $identification_number = $_POST['identification_number'];
    $contact_number = $_POST['contact_number'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $first_visit = date("Y-m-d H:i:s");

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO [User] (Age, Name, Username, Password_Hashed, Role) 
            OUTPUT INSERTED.User_ID
            VALUES (?, ?, ?, ?, ?)";
    $params = array($age, $name, $username, $hashedPassword, $role);

    $stmtUser = sqlsrv_query($conn, $sql, $params);

    if ($stmtUser === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Get the inserted User_ID
    if (sqlsrv_fetch($stmtUser)) {
        $userID = sqlsrv_get_field($stmtUser, 0);
    } else {
        die("Failed to retrieve user ID");
    }

    // Insert into Patient table
    $sqlPatient = "INSERT INTO Patient (User_ID, Identification_number, Contact_number, Gender, Address, First_visit) VALUES (?, ?, ?, ?, ?, ?)";
    $paramsPatient = array($userID, $identification_number, $contact_number, $gender, $address, $first_visit);
    $stmtPatient = sqlsrv_query($conn, $sqlPatient, $paramsPatient);

    if ($stmtPatient === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "<p>✅ Patient registration successful!</p>";
    }
}
?>
</body>
</html>