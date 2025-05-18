<?php 
    session_start(); // Must be at the very top

    // Redirect if already logged in
    if (isset($_SESSION['user_id'])) {
        echo '<script>
                alert("You are already logged in.");
                window.location.href = "/index.php?page=logout";
              </script>';
        exit;
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Best Medical</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="../assets/images/logo.png" alt="Best Medical Logo">
            <h1>Best Medical</h1>
            <?php
            include("includes/header.php");
            ?>
        </div>
    </header>

    <!-- Main Content -->
    <main class="login-page">
        <section id="login-form">
            <h2>Login</h2>
            <form action="#" method="post">
                <label for="user">Username</label>
                <input type="user" id="user" name="user" placeholder="Enter name user" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="pass" placeholder="Enter password" required>

                <button type="submit">Login</button>
            </form>
        </section>
    </main>


<?php
    include __DIR__ . '/../includes/db.php';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $sql = "SELECT User_ID, Age, Username, Name, Password_Hashed, Role FROM [User] WHERE username = ?";
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
            sqlsrv_close($conn);

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
</body>
</html>