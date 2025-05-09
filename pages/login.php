<?php 
    session_start(); // Must be at the very top

    // Redirect if already logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
?>

<h1>Login</h1>

<form method='post'>
    <input type='text' name='user'>
    <input type='password' name='pass'>
    <button>Login</button>
</form>

<?php
    include __DIR__ . '/../includes/db.php';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $sql = "SELECT * FROM [User] WHERE username = ?";
        $params = array($user);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row && password_verify($pass, $row['Password_Hashed'])) {
            echo "Login successful!";
            // Redirect to another page or perform other actions
            $_SESSION['username'] = $user;
            $_SESSION['user_id'] = $row['User_ID']; // Assuming UserID is the first field
            $_SESSION['role'] = $row['Role']; // Assuming role is the second field
            
            // Redirect based on role
            if ($row['Role'] == 'Doctor') {
                header("Location: /index.php?page=doctorPage");
                exit;
            } elseif ($row['Role'] == 'Patient') {
                header("Location: /index.php?page=patientPage");
                exit;
            } elseif ($row['Role'] == 'Admin') {
                header("Location: /index.php?page=adminPage");
                exit;
            } else {
                echo "Unknown role.";   
                header("Location: /index.php?page=login");
            }

        } else {
            echo "Invalid username or password.";
        }
    }
?>