<?php
// Start the session
session_start();

// Include the database configuration file
require_once '../db/db_config.php';

// Fetch user data from the database based on the logged-in user
$username = $_SESSION['username'];
$query = "SELECT * FROM bhw WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);

// Check if user exists
if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $bhw_id = $user['bhw_id']; // Fetch the user_id from the users table

    // Fetch profile data using the user_id (as profile_id)
    $profileQuery = "SELECT * FROM bhw_profile WHERE bhw_iD = ?";
    $profileStmt = $pdo->prepare($profileQuery);
    $profileStmt->execute([$bhw_id]);

// Check if profile exists
if ($profileStmt->rowCount() > 0) {
    $profile = $profileStmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Initialize profile array to prevent undefined index errors
    $profile = [
        'name' => '',
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $brgy = $_POST['brgy'] ?? '';
    $zone = $_POST['zone'] ?? '';
    
    // Check if the profile already exists
    if ($profileStmt->rowCount() > 0) {
        // Update the existing profile record
        $updateQuery = "UPDATE bhw_profile SET name = ?, email = ?, age = ?, dob = ?, gender = ?, province = ?, city = ?, brgy = ?, zone = ? WHERE bhw_ID = ?";
        $profileStmt = $pdo->prepare($updateQuery);
        $profileStmt->execute([$name, $email, $age, $dob, $gender, $province, $city, $brgy, $zone, $bhw_id]);
    } else {
        // Insert a new profile record
        $insertQuery = "INSERT INTO bhw_profile (parent_id, name, email, age, dob, gender, province, city, brgy, zone) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $profileStmt = $pdo->prepare($insertQuery);
        $profileStmt->execute([$bhw_id, $name, $email, $age, $dob, $gender, $province, $city, $brgy, $zone]);
    }

    // Redirect to avoid form resubmission on refresh
    header("Location: BHW_profile.php?updated=true");
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
            <div class="back-button" onclick="window.location.href='BHW-Dashboard.php';">&#x2190;</div>
            <h2>PROFILE</h2>
            <div class="profile-icon">
                <img  alt="Profile Image" id="profileImage">
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
            <div class="back-button" onclick="window.location.href='BHW_profile.php';">&#x2190;</div>
            <form class="profile-form" method="POST" action="BHW_profile.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($profile['name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>"  required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($profile['dob'] ?? ''); ?>"  required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>"  required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="Male" <?php if (($profile['gender'] ?? '') == 'male') echo 'selected'; ?> >Male</option>
                        <option value="Female" <?php if (($profile['gender'] ?? '') == 'female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Province</label>
                    <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($profile['province'] ?? ''); ?>"  required>
                </div>
                <div class="form-group">
                    <label for="address">City?Municipality</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>"  required>
                </div>
                <div class="form-group">
                    <label for="address">Barangay</label>
                    <input type="text" id="brgy" name="brgy" value="<?php echo htmlspecialchars($profile['brgy'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Zone/Purok</label>
                    <input type="text" id="zone" name="zone" value="<?php echo htmlspecialchars($profile['zone'] ?? ''); ?>" required>
                </div>
                <button type="submit" class="edit-button">Save Profile</button>
            </form>
        <?php else: ?>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($profile['name'] ?? ''); ?> </p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email'] ?? ''); ?> </p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($profile['age'] ?? ''); ?> </p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($profile['dob'] ?? ''); ?> </p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($profile['gender'] ?? ''); ?> </p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars(($profile['zone'] ?? ''). ' ' . ($profile['brgy'] ?? ''). ' ' . ($profile['city'] ?? '') . ' ' . ($profile['province'] ?? '')); ?></p>
        <a href="../BHW/BHW_profile.php?edit=true" class="edit-button">Edit Profile</a>
        <?php endif; ?>
    </div>
</body>
</html>