<?php
// login.php
session_start(); // Start session at the top

require '../db/db_config.php';


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
    <title>SeniorsFirst - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="img/logo.png" alt="SeniorsFirst Logo" class="logo">
        </div>

        <div class="header-title">
            <h1>SeniorsFirst</h1>
        </div>
    </header>
    
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center" 
         style="background-image: url('img/18.jpg');">
        <div class="card p-4 shadow-lg login-card">
            <h3 class="text-center fw-bold mb-3">LOG IN</h3>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']); // Clear the error message
            }
            ?>
            <form id="loginForm" class="loginForm" method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Log In</button>
                <p class="mt-3 text-center">
                    Don't have an account? <a href="signup.php">Sign up</a>
                </p>
            </form>
        </div>
    </div>

    <footer class="footer mt-5">
        <div class="container text-center py-3">
            <p class="mb-0">&copy; 2024 SeniorsFirst. All rights reserved.</p>
            <p>
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms of Service</a> | 
                <a href="contact.php">Contact Us</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS and Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <!-- Custom JS -->
    <script src="/js/main.js"></script>
</body>
</html>