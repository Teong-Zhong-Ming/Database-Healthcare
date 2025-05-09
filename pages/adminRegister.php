<h1>Admin Registration</h1>

<form method="post" action="">
    <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
    <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
    <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" required><br>
    <label for="role">Role:</label><br>
        <input type="text" id="role" name="role" value="Admin" readonly><br>
    <button type="submit" name="registerbtn" value="registerbtn">Register Admin</button>
</form>

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