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
<main>
    <section id="create-account">
        <h1>Admin Registration</h1>
            <form method="post" action="">
                <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                <label for="role">Role:</label>
                    <input type="text" id="role" name="role" value="Admin" readonly>
                <button type="submit" name="registerbtn" value="registerbtn">Register Admin</button>
            </form>
    </section>
</main>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registerbtn'])) {

    include __DIR__ . '/../includes/db.php';
    
    // // Verify security code (store this securely in your environment)
    // $valid_security_code = "YOUR_SECURE_ADMIN_CODE"; // Change this and store in config
    // if ($_POST['security_code'] !== $valid_security_code) {
    //     die("<p class='error'>❌ Invalid security code</p>");
    // }

    // User info
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $role = $_POST['role']; // Will be "Admin"

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

        // Insert into Admin table with current timestamp
        $sqlAdmin = "INSERT INTO Admin (User_ID, Last_Access) 
                     VALUES (?, NULL)";
        $paramsAdmin = array($userID);
        $stmtAdmin = sqlsrv_query($conn, $sqlAdmin, $paramsAdmin);

        if ($stmtAdmin === false) {
            throw new Exception("Admin registration failed: " . print_r(sqlsrv_errors(), true));
        }

        // Commit transaction if both inserts succeeded
        sqlsrv_commit($conn);
        echo "<p class='success'>✅ Admin registration successful!</p>";
        
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