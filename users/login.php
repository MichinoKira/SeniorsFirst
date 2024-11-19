<?php
// login.php

require '../db/db_config.php';
session_start(); // Start session at the top

function redirectWithError($error) {
    $_SESSION['error'] = $error;
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        redirectWithError("Both fields are required!");
    }

    // Check in the admins table first
    $sql = "SELECT admin_id, password, 'brgy' AS role FROM admins WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        // Admin found
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Check in the users table
        $sql = "SELECT user_id, password, 'user' AS role FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            // User found
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Check in the BHW table
            $sql = "SELECT bhw_id, password, 'bhw' AS role FROM BHW WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                // BHW found
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                redirectWithError("<script>alert('Invalid Username or Password.');</script>");
            }
        }
    }

    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Password is correct, proceed with login
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
            case 'brgy':
                header("Location: ../Admin/index.php");
                break;
            case 'bhw':
                header("Location: ../BHW/BHW-Dashboard.php");
                break;
            default:
                header("Location: user_dashboard.php");
                break;
        }
        exit();
    } else {
        redirectWithError("<script>alert('Invalid Username or Password!.');</script>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login - SeniorsFirst</title>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="../Images/SeniorsFirstLogo.png" alt="SeniorsFirst Logo">
        </div>
        <div class="login-form">
            <h2>Log in</h2>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']); // Clear the error message
            }
            ?>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <div>
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">Remember Me</label>
                    <a href="#" style="float: right;">Forgot Password?</a>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="signup-link">
                <p>Don't have an Account? <a href="../users/signup.php">Sign up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
