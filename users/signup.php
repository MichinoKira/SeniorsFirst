<?php
// register.php

require '../db/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $phone_no = trim($_POST["phone_no"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($username) || empty($phone_no) || empty($password) || empty($confirm_password)) {
        echo "All fields are required!";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
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
            $sql = "INSERT INTO users (username, phone_no, password, confirm_password) VALUES (:username, :phone_no, :password, :confirm_password)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':phone_no', $phone_no, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':confirm_password', $hashed_password, PDO::PARAM_STR);


            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup.css">
    <title>Sign Up - SeniorsFirst</title>
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <img src="./Images/SeniorsFirstLogo.png" alt="SeniorsFirst Logo">
        </div>
        <div class="signup-form">
            <h2>Sign up</h2>
            <form action="signup.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="tel" name="phone_no" placeholder="Phone No" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Create an Account</button>
            </form>
            <div class="login-link">
                <p>Already have an Account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
