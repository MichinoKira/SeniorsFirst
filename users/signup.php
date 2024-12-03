<?php
// signup.php
session_start();

require '../db/db_config.php';

// Initialize error messages array
$errors = [];

function checkExistingUser($firstname, $lastname, $username, $phone_no, $pdo) {
    $sql = "SELECT user_id FROM users WHERE username = :username OR phone_no = :phone_no OR firstname = :firstname OR lastname = :lastname";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':phone_no', $phone_no, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $username = trim($_POST["username"]);
    $phone_no = trim($_POST["phone_no"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate each input
    if (empty($firstname)) {
        $errors['firstname'] = 'First Name is required!';
    }

    if (empty($lastname)) {
        $errors['lastname'] = 'Last Name is required!';
    }

    if (empty($username)) {
        $errors['username'] = 'Username is required!';
    }

    if (empty($phone_no)) {
        $errors['phone_no'] = 'Phone Number is required!';
    } elseif (!preg_match('/^[0-9]{11}$/', $phone_no)) {
        $errors['phone_no'] = 'Invalid phone number!';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required!';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your password!';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match!';
    }

    // Proceed to check for existing user only if no validation errors
    if (empty($errors)) {
        if (checkExistingUser($firstname, $lastname, $username, $phone_no, $pdo)) {
            // Separate the existing user checks
            if (checkExistingUser($username, '', '', '', $pdo)) {
                $errors['username'] = 'Username is already taken!';
            }
            if (checkExistingUser('', '', $phone_no, '', $pdo)) {
                $errors['phone_no'] = 'Phone number is already taken!';
            }
            if (checkExistingUser($firstname, '', '', '', $pdo)) {
                $errors['firstname'] = 'First name is already taken!';
            }
            if (checkExistingUser('', $lastname, '', '', $pdo)) {
                $errors['lastname'] = 'Last name is already taken!';
            }
        }
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (firstname, lastname, username, phone_no, password) VALUES (:firstname, :lastname, :username, :phone_no, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone_no', $phone_no, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['message'] = ['type' => 'success', 'content' => 'Account created successfully! Please login.'];
            header("Location: login.php");
            exit();
        } else {
            $errors['database'] = 'Something went wrong. Please try again later.';
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

            <!-- Display Field-Specific Notifications -->
        <?php if (isset($errors['username'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errors['username']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['phone_no'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errors['phone_no']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['firstname'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errors['firstname']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($errors['lastname'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errors['lastname']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

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
                <?php if (isset($errors['firstname'])): ?>
                    <div class="text-danger"><?php echo $errors['firstname']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name" required>
                </div>
                <?php if (isset($errors['lastname'])): ?>
                    <div class="text-danger"><?php echo $errors['lastname']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="username" name="username" class="form-control" id="username" placeholder="Username" required>
                </div>
                <?php if (isset($errors['username'])): ?>
                    <div class="text-danger"><?php echo $errors['username']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone No</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-telephone"></i>
                    </span>
                    <input type="tel" name="phone_no" class="form-control" id="phone_no" placeholder="Phone Number"  required>
                </div>
                <?php if (isset($errors['phone_no'])): ?>
                    <div class="text-danger"><?php echo $errors['phone_no']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                </div>
                <?php if (isset($errors['password'])): ?>
                    <div class="text-danger"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" required>
                </div>
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="text-danger"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-success w-100">Create an Account</button>
            <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>