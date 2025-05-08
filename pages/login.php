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

        $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
        $params = array($user, $pass);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_fetch($stmt)) {
            echo "Login successful!";
            // Redirect to another page or perform other actions
        } else {
            echo "Invalid username or password.";
        }
    }
?>