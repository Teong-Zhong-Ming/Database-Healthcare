<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../index.php?page=home");
        exit;
    }

?>
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
<!-- Main Content -->
    <main>
        <section id="create-account">
        <h1>Doctor Register</h1>

        <form method="post" action="">
            <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><br>
            <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br>
            <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" required><br>
            <label for="identification_number">Identification_number:</label><br>
                <input type="text" id="identification_number" name="identification_number" required><br>
            <label for="contact_number">Contact Number:</label><br>
                <input type="text" id="contact_number" name="contact_number" required><br>
            <label for="gender">Gender:</label><br>
                <select id="gender" name="gender" required>
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="NTS">Prefer Not To Say</option>
                </select><br>
            <label for="address">Address:</label><br>
                <input type="text" id="address" name="address" required><br>
            <label for="specialization">Specialization:</label><br>
                <input type="text" id="specialization" name="specialization" required><br>
            <label for="role">Role:</label><br>
                <input type="text" id="role" name="role" value="Doctor" readonly><br>
            <button type="submit" name="registerbtn" value="registerbtn">Register</button>
        </form>
        </section>
    </main>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerbtn'])) {

    include __DIR__ . '/../includes/db.php';

    // User info
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $role = $_POST['role']; // Will be "Doctor"

    // Doctor-specific info
    $identification_number = $_POST['identification_number'];
    $contact_number = $_POST['contact_number'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $specialization = $_POST['specialization'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Begin transaction
    sqlsrv_begin_transaction($conn);

    try {
        // Insert into User table
        $sql = "INSERT INTO [User] (Age, Name, Username, Password_Hashed, Role) 
                OUTPUT INSERTED.User_ID
                VALUES (?, ?, ?, ?, ?)";
        $params = array($age, $name, $username, $hashedPassword, $role);
        $stmtUser = sqlsrv_query($conn, $sql, $params);

        if ($stmtUser === false) {
            throw new Exception("User registration failed: " . print_r(sqlsrv_errors(), true));
        }

        // Get the inserted User_ID
        if (sqlsrv_fetch($stmtUser)) {
            $userID = sqlsrv_get_field($stmtUser, 0);
        } else {
            throw new Exception("Failed to retrieve user ID");
        }

        // Insert into Doctor table
        $sqlDoctor = "INSERT INTO Doctor (User_ID, Identification_number, Contact_number, Gender, Address, Specialization) 
                     VALUES (?, ?, ?, ?, ?, ?)";
        $paramsDoctor = array($userID, $identification_number, $contact_number, $gender, $address, $specialization);
        $stmtDoctor = sqlsrv_query($conn, $sqlDoctor, $paramsDoctor);

        if ($stmtDoctor === false) {
            throw new Exception("Doctor registration failed: " . print_r(sqlsrv_errors(), true));
        }

        // Commit transaction if both inserts succeeded
        sqlsrv_commit($conn);
        echo "<p class='success'>✅ Doctor registration successful!</p>";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        sqlsrv_rollback($conn);
        echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    }
}
?>

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Best Medical. All rights reserved.</p>
    </footer>
</body>
</html>