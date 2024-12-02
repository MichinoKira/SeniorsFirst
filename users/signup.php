<?php
// signup.php
session_start();


require '../db/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $username = trim($_POST["username"]);
    $phone_no = trim($_POST["phone_no"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($firstname) || empty($lastname) || empty($username) || empty($phone_no) || empty($password) || empty($confirm_password)) {
        echo "All fields are required!";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } elseif (!preg_match('/^[0-9]{11}$/', $phone_no)) { // Validates 10-digit phone numbers
        echo "Invalid phone number!";
    } else {
        try {
            // Check if the username is already taken
            $sql = "SELECT user_id FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Username is already taken!";
            } else {
                // Hash the password with bcrypt
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert the new user into the database
                $sql = "INSERT INTO users (firstname, lastname, username, phone_no, password) VALUES (:firstname, :lastname, :username, :phone_no, :password)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':phone_no', $phone_no, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    header("Location: login.php");
                    exit();
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeniorsFirst - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="signup.css">
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
     style="background-image: url('img/18.jpg'); background-size: cover; background-position: center;">
    <div class="card p-4 shadow-lg login-card">
        <h3 class="text-center fw-bold mb-3">Sign Up</h3>

        <form id="signupForm" method="POST" action="signup.php">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="First Name" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="username" name="username" class="form-control" id="username" placeholder="Username" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone No</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-telephone"></i>
                    </span>
                    <input type="tel" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number"  required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">Create an Account</button>
            <p class="mt-3 text-center">
                Already have an account? <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</div>

<script>
    document.getElementById('signupForm').addEventListener('submit', function (e) {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>