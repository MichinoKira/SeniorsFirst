<?php
// Start the session
session_start();

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
    // Initialize profile array to prevent undefined index errors
    $profile = [
        'firstname' => '',
        'middlename' => '',
        'lastname' => '',
        'extension' => '',
        'email' => '',
        'age' => '',
        'dob' => '',
        'gender' => '',
        'region' => '',
        'province' => '',
        'city' => '',
        'brgy' => '',
        'purok_name' => ''
    ];
}
} else {
// Handle the case where the user does not exist
die("User not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    var_dump($_POST); // Check what is being submitted
    // Retrieve form data
    $firstname = $_POST['firstname'] ?? '';
    $middlename = $_POST['middlename'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $extension = $_POST['extension'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $brgy = $_POST['brgy'] ?? '';
    $purok_name = $_POST['purok_name'] ?? '';
    
    // Check if the profile already exists
    if ($profileStmt->rowCount() > 0) {
        // Update the existing profile record
        $updateQuery = "UPDATE user_profile SET firstname = ?, middlename = ?, lastname = ?, extension = ?, email = ?, age = ?, dob = ?, gender = ?, region = ?, province = ?, city = ?, brgy = ?, purok_name = ? WHERE profile_id = ?";
        $profileStmt = $pdo->prepare($updateQuery);
        $profileStmt->execute([$firstname, $middlename, $lastname, $extension, $email, $age, $dob, $gender, $region, $province, $city, $brgy, $purok_name, $user_id]);
    } else {
        // Insert a new profile record
        $insertQuery = "INSERT INTO user_profile (parent_id, firstname, middlename, lastname, extension, email, age, dob, gender, region, province, city, brgy, purok_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $profileStmt = $pdo->prepare($insertQuery);
        $profileStmt->execute([$user_id, $firstname, $middlename, $lastname, $extension, $email, $age, $dob, $gender, $region, $province, $city, $brgy, $purok_name]);
    }

    // Redirect to avoid form resubmission on refresh
    header("Location: user_profile.php?updated=true");
    exit;
}

$isEdit = isset($_GET['edit']);
$updated = isset($_GET['updated']) && $_GET['updated'] === 'true';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profile.css">
    <script src="https://kit.fontawesome.com/f9f0cbfe40.js" crossorigin="anonymous"></script>
    <title>User Profile</title>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="back-button" onclick="window.location.href='user_dashboard.php';">&#x2190;</div>
            <h2>PROFILE</h2>
            <div class="profile-icon">
                <img src="<?php echo !empty($user['profile_image']) ? htmlspecialchars($user['profile_image']) : 'uploads/default.png'; ?>" alt="Profile Image" id="profileImage">
                <label for="profile_image" class="camera-icon">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" style="display: none;" onchange="previewImage(event)">
            </div>
        </div>

        <?php if ($updated): ?>
            <p class="update-message">Profile updated successfully!</p>
        <?php endif; ?>

        <?php if ($isEdit): ?>
            <div class="back-button" onclick="window.location.href='user_profile.php';">&#x2190;</div>
            <form class="profile-form" method="POST" action="user_profile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($profile['firstname'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Middle Name</label>
                    <input type="text" id="middlename" name="middlename" value="<?php echo htmlspecialchars($profile['middlename'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Last Name</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($profile['lastname'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="name">Extension</label>
                    <input type="text" id="extension" name="extension" value="<?php echo htmlspecialchars($profile['extension'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($profile['dob'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                    <option value="" <?php echo empty($profile['gender']) ? 'selected' : ''; ?>>Select Status</option>
                    <option value="Male" <?php echo ($profile['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($profile['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Region</label>
                    <input type="text" id="region" name="region" value="<?php echo htmlspecialchars($profile['region'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Province</label>
                    <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($profile['province'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">City</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Barangay</label>
                    <input type="text" id="brgy" name="brgy" value="<?php echo htmlspecialchars($profile['brgy'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Zone/Purok</label>
                    <input type="text" id="purok_name" name="purok_name" value="<?php echo htmlspecialchars($profile['purok_name'] ?? ''); ?>" required>
                </div>
                <button type="submit" class="edit-button">Save Profile</button>
            </form>
        <?php else: ?>
        <p><strong>Name:</strong> <?php echo htmlspecialchars(($profile['firstname'] ?? '') . ' ' . ($profile['middlename'] ?? '') . ' ' . ($profile['lastname'] ?? ''). ' ' . ($profile['extension'] ?? '')); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email'] ?? ''); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($profile['age'] ?? ''); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($profile['dob'] ?? ''); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($profile['gender'] ?? ''); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars(($profile['province'] ?? '') . ' ' . ($profile['city'] ?? '') . ' ' . ($profile['brgy'] ?? '') . ' ' . ($profile['purok_name'] ?? '')); ?></p>
        <a href="../users/user_profile.php?edit=true" class="edit-button">Edit Profile</a>
        <?php endif; ?>
    </div>
</body>
</html>