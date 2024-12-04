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
    $profileQuery = "SELECT * FROM user_profile WHERE profile_id = ?";
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

// Get the profile ID (from session or fetched data)
$parent_id = $user_id;
// Section completion statuses
$infoSecComplete = isInfoSecComplete($pdo, $parent_id);
$familySecComplete = isFamilySecComplete($pdo, $parent_id);
$eduSecComplete = isEduSecComplete($pdo, $parent_id);
$ecoSecComplete = isEcoSecComplete($pdo, $parent_id);

function isInfoSecComplete($pdo, $parent_id) {
    $query = "SELECT firstname, lastname, oscaID FROM info_sec WHERE parent_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parent_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check required fields
    return !empty($row['firstname']) && !empty($row['lastname']) && !empty($row['oscaID']);
}

function isFamilySecComplete($pdo, $parent_id) {
    $query = "SELECT spouse_lastname, spouse_firstname, spouse_middlename,
                     father_lastname, father_firstname, father_middlename,
                     mother_lastname, mother_firstname, mother_middlename  
            FROM family_sec WHERE parent_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parent_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check required fields
    return !empty($row['spouse_lastname']) && !empty($row['spouse_firstname']) && !empty($row['spouse_middlename'])
        && !empty($row['father_lastname']) && !empty($row['father_firstname']) && !empty($row['father_middlename'])
        && !empty($row['mother_lastname']) && !empty($row['mother_firstname']) && !empty($row['mother_middlename']); 
}

function isEduSecComplete($pdo, $parent_id) {
    $query = "SELECT education FROM edu_sec WHERE parent_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parent_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check required fields
    return !empty($row['education']);
}

function isEcoSecComplete($pdo, $parent_id) {
    $query = "SELECT income_sources, income_range FROM eco_sec WHERE parent_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$parent_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check required fields
    return !empty($row['income_sources']) && !empty($row['income_range']);
}

// Fetch the application status from the database
$statusQuery = "SELECT approval_status FROM user_profile WHERE parent_id = ?";
$statusStmt = $pdo->prepare($statusQuery);
$statusStmt->execute([$parent_id]);
$statusRow = $statusStmt->fetch(PDO::FETCH_ASSOC);

// Default status if no record exists
$applicationStatus = $statusRow['approval_status'] ?? 'Pending';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Welcome - SeniorsFirst</title>
    <link rel="stylesheet" href="user_dashboard.css">
</head>
<body>
    <div id="main">
        <div class="container">
            <div class="header">
                <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,288L60,261.3C120,235,240,181,360,165.3C480,149,600,171,720,181.3C840,192,960,192,1080,192C1200,192,1320,192,1380,192L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>
                <!-- Updated position for nav-btn (hamburger) -->
                <button class="nav-btn" onclick="toggleDropdown()"><i class="fas fa-bars"></i></button>

                <!-- Logo Header Section -->
                <div class="logo-header">
                    <img src="../users/img/logo.png" alt="SeniorsFirst Logo" class="logo">
                </div>
                <div class="Text1"><p>Hello, <?php echo htmlspecialchars($user['firstname']); ?>!</div>
            </div>
    
                
            <!-- Dropdown Menu -->
            <div class="dropdown" id="dropdownMenu">
                <a href="user_profile.php">Profile</a>
                <a href="changepassword.php">Change Password</a>
                <a href="logout.php">Logout</a>
            </div>

            <div class="card">
                <div class="welcome-text">
                    <p>Republic of the Philippines</p>
                    <p>Province of Negros Occidental</p>
                    <p>MUNICIPALITY OF HINOBA-AN<br>OFFICE OF THE SENIOR CITIZEN AFFAIRS</p>
                </div>
                <h3>Name:</h3><p><?php echo htmlspecialchars(($profile['firstname'] ?? '') . ' ' . ($profile['middlename'] ?? '') . ' ' . ($profile['lastname'] ?? '')); ?></p>
                <h3>Address:</h3><p><?php echo htmlspecialchars(($profile['province'] ?? '') . ' ' . ($profile['city'] ?? '') . ' ' . ($profile['brgy'] ?? '') . ' ' . ($profile['zone'] ?? '')); ?></p>
                <img src="../qrCodes<?php echo $user_id; ?>.png" alt="QR Code with Logo">
                <p>Date of Birth: <?php echo htmlspecialchars($profile['dob']); ?> &nbsp; 
                Sex: <?php echo htmlspecialchars($profile['gender']); ?> &nbsp; 
                Age: <?php echo htmlspecialchars($profile['age']); ?></p>
                <p style="color: red;">THIS CARD IS NON-TRANSFERABLE AND VALID ANYWHERE IN THE COUNTRY</p>
            </div>

            <div class="status-container">
                <!-- Application Status Display -->
                <?php if ($applicationStatus === 'Approved'): ?>
                    <p class="status-message" style="color: green;">Your application has been approved.</p>
                <?php elseif ($applicationStatus === 'Denied'): ?>
                    <p class="status-message" style="color: red;">Your application has been denied. Please submit again.</p>
                <?php else: ?>
                    <h4>Application Status: <span style="font-weight: bold; color: blue;">In Progress</span></h4>
                <?php endif; ?>
            </div>

            <div class="progress-container">
                <h4>Application Progress</h4>
                <div class="progress-item">
                    <p>I. Identifying Information:</p>
                    <p class="<?php echo $infoSecComplete ? 'completed' : 'incomplete'; ?>" style="color:<?php echo $familySecComplete ? 'green' : 'red'; ?>">
                        <?php echo $infoSecComplete ? 'Complete' : 'Incomplete'; ?>
                </div>

                <div class="progress-item">
                    <p>II. Family Composition:</p>
                    <p class="<?php echo $familySecComplete ? 'completed' : 'incomplete'; ?>" style="color:<?php echo $familySecComplete ? 'green' : 'red'; ?>">
                        <?php echo $familySecComplete ? 'Complete' : 'Incomplete'; ?>
                </div>

                <div class="progress-item">
                    <p>IV. Education / HR Profile:</p>
                    <p class="<?php echo $eduSecComplete ? 'completed' : 'incomplete'; ?>" style="color:<?php echo $familySecComplete ? 'green' : 'red'; ?>">
                        <?php echo $eduSecComplete ? 'Complete' : 'Incomplete'; ?>
                </div>

                <div class="progress-item">
                    <p>V. Economic Profile:</p>
                    <p class="<?php echo $ecoSecComplete ? 'completed' : 'incomplete'; ?>" style="color:<?php echo $familySecComplete ? 'green' : 'red'; ?>">
                        <?php echo $ecoSecComplete ? 'Complete' : 'Incomplete'; ?>
                </div>
            </div>

            <div class="button-container">
                <!-- Submit Application Button -->
                <?php if ($applicationStatus === 'Denied' || $applicationStatus === 'Pending'): ?>
                    <a href="../ApplicationForm/info_sec.php" class="submit-btn">Submit Application</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownMenu");
        // Toggle dropdown visibility by changing display
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        } else {
            dropdown.style.display = "block";
        }
    }
    </script>
</body>
</html>