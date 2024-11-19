<?php
// Start the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database configuration file
require_once '../db/db_config.php';

// Fetch user data from the database based on the logged-in user
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);

// Check if user exists
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['user_id']; // Fetch the user_id from the users table

    // Fetch profile data using the user_id (as profile_id)
    $profileQuery = "SELECT * FROM profile WHERE profile_id = ?";
    $profileStmt = $pdo->prepare($profileQuery);
    $profileStmt->execute([$user_id]);

    // Check if profile exists
    if ($profileStmt->rowCount() > 0) {
        $profile = $profileStmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Initialize profile array if no profile exists
        $profile = [
            'firstname' => '',
            'middlename' => '',
            'lastname' => '',
            'email' => '',
            'age' => '',
            'dob' => '',
            'gender' => '',
            'province' => '',
            'city' => '',
            'brgy' => '',
            'zone' => ''
        ];
    }
} else {
    // Handle the case where the user does not exist
    die("User not found.");
}

// Function to check if profile is complete
function isProfileComplete($profile) {
    // List of required fields
    $requiredFields = ['firstname', 'lastname', 'email', 'dob', 'gender', 'province', 'city', 'brgy', 'zone'];

    // Check each required field
    foreach ($requiredFields as $field) {
        if (empty($profile[$field])) {
            return false;
        }
    }
    return true;
}

// Check if profile is complete
$profileComplete = isProfileComplete($profile);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/user_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Welcome - SeniorsFirst</title>
</head>
<body>
    <div id="main">
        <button class="nav-btn" onclick="openDrawer()"><i class="fas fa-bars"></i></button>
        <div class="container">
        <div class="drawer" id="drawer">
        <a href="javascript:void(0)" class="closebtn" onclick="closeDrawer()">&times;</a>
        <a href="profile.php">Profile</a>
        <a href="changepassword.php">Change Password</a>
        <a href="logout.php">Logout</a>
    </div>
            <div class="header">
                <img src="../images/SeniorsFirstLogo.png" alt="SeniorsFirst Logo" class="logo">
                <h1>Hello, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            </div>
            <div class="card">
            <div class="welcome-text">
                <p>Republic of the Philippines</p>
                <p>Province of Negros Occidental</p>
                <p>MUNICIPALITY OF HINOBA-AN<br>OFFICE OF THE SENIOR CITIZEN AFFAIRS</p>
            </div>
                <h3>Name:</h3>
                <p><?php echo htmlspecialchars(($profile['firstname'] ?? '') . ' ' . ($profile['middlename'] ?? '') . ' ' . ($profile['lastname'] ?? '')); ?></p>
                <h3>Address:</h3>
                <p><?php echo htmlspecialchars(($profile['province'] ?? '') . ' ' . ($profile['city'] ?? '') . ' ' . ($profile['brgy'] ?? '') . ' ' . ($profile['zone'] ?? '')); ?></p>
                <img src="../qrCodes<?php echo $user_id; ?>.png" alt="QR Code with Logo">
                <p>Date of Birth: <?php echo htmlspecialchars($profile['dob']); ?> &nbsp; 
                Sex: <?php echo htmlspecialchars($profile['gender']); ?> &nbsp; 
                Age: <?php echo htmlspecialchars($profile['age']); ?></p>
                <p style="color: red;">THIS CARD IS NON-TRANSFERABLE AND VALID ANYWHERE IN THE COUNTRY</p>
            </div>
            <div class="status-container">
                <h4>Application Status: <span style="font-weight: bold;">In Progress</span></h4>
            </div>
            <div class="progress-container">
                <h4>Application Progress</h4>
                <div class="progress-item">
                    <p>I. Identifying Information:</p>
                    <p class="completed">Completed</p>
                </div>
                <div class="progress-item">
                    <p>II. Family Composition:</p>
                    <p class="status">In Progress</p>
                </div>
                <div class="progress-item">
                    <p>IV. Education / HR Profile:</p>
                    <p class="status">In Progress</p>
                </div>
                <div class="progress-item">
                    <p>V. Economic Profile:</p>
                    <p class="status">In Progress</p>
                </div>
            </div>
            <?php if ($profileComplete): ?>
                <a href="../ApplicationForm/info_sec.php" class="submit-btn">Submit Application</a>
            <?php else: ?>
                <p class="warning">Please complete your profile before submitting the application.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    function openDrawer() {
        document.getElementById("drawer").style.width = "200px";
        document.getElementById("main").style.marginLeft = "200";
    }

    function closeDrawer() {
        document.getElementById("drawer").style.width = "0";
        document.getElementById("main").style.marginLeft = "00";
    }
    
    </script>
</body>
</html>