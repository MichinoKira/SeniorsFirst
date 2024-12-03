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

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/profile.css">
    
    <title>User Profile</title>
    
</head>

<body>


    <div class="container mt-4 profile-container">
        <div class="text-left mb-3">
                <a href="user_dashboard.php" class="btn btn-link back-button" alt="Profile Image">
                <i class="fas fa-arrow-left"></i>
                </a>    
            </div>

            <div class="text-center">
                <h1 class="profile-title">PROFILE</h1>

                <div class="profile-image">
                    <img id="profile-img" alt="Profile Image">
                    <div class="camera-icon" id="camera-icon">
                        <i class="fa fa-camera"></i>
                        <input type="file" id="file-input" accept="image/*" style="display: none;">
                    </div>
                </div>
            </div>

            <?php if ($updated): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Profile updated successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

        <?php if ($isEdit): ?>
            <form id="profile-form" method="POST" action="user_profile.php" enctype="multipart/form-data">
            <div class="form-group" id="name">
                <label>First Name</label>
                <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo htmlspecialchars($profile['firstname'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="middlename">
                <label>Middle Name</label>
                <input type="text" id="middlename" name="middlename" class="form-control" value="<?php echo htmlspecialchars($profile['middlename'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="lastname">
                <label>Last Name</label>
                <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo htmlspecialchars($profile['lastname'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="extension">
                <label>Extension</label>
                <input type="text" id="extension" name="extension" class="form-control" value="<?php echo htmlspecialchars($profile['extension'] ?? ''); ?>">
            </div>
            <div class="form-group" id="email">
                <label>Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" class="form-control" value="<?php echo htmlspecialchars($profile['dob'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group" id="gender">
                <label>Gender</label>
                <select id="gender" name="gender" required>
                    <option value="" <?php echo empty($profile['gender']) ? 'selected' : ''; ?>>Select Status</option>
                    <option value="Male" <?php echo ($profile['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($profile['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="form-group" id="region">
                <label>Region</label>
                <input type="varchar" id="region" name="region" class="form-control" value="<?php echo htmlspecialchars($profile['region'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="province">
                <label>Province</label>
                <input type="text" id="province" name="province" class="form-control" value="<?php echo htmlspecialchars($profile['province'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="city">
                <label>City / Municipality</label>
                <input type="text" id="city" name="city" class="form-control" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="brgy">
                <label>Barangay</label>
                <input type="varchar" id="brgy" name="brgy" class="form-control" value="<?php echo htmlspecialchars($profile['brgy'] ?? ''); ?>" required>
            </div>

            <div class="form-group" id="zone">
                <label>Zone</label>
                <input type="varchar" id="purok_name" name="purok_name" class="form-control" value="<?php echo htmlspecialchars($profile['purok_name'] ?? ''); ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="edit-button">Save Profile</button>
            </div>
            
        </form>
            </div>
            
            
        <?php else: ?>
            <div class="form-group" id="name">
                <label>Name</label>
                <input type="text" id="name" class="form-control" value="<?php echo htmlspecialchars(($profile['firstname'] ?? '') . ' ' . ($profile['middlename'] ?? '') . ' ' . ($profile['lastname'] ?? '') . ' ' . ($profile['extension'] ?? '')); ?>" readonly>
            </div>

            <div class="form-group" id="email">
                <label>Email</label>
                <input type="text" id="email" class="form-control" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group" id="age">
                <label>Age</label>
                <input type="text" id="age" class="form-control" value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group" id="dob">
                <label>Date of Birth</label>
                <input type="text" id="dob" class="form-control" value="<?php echo htmlspecialchars($profile['dob'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group" id="gender">
                <label>Gender</label>
                <input type="text" id="gender" class="form-control" value="<?php echo htmlspecialchars($profile['gender'] ?? ''); ?>" readonly>
            </div>

            <div class="form-group" id="address">
                <label>Email</label>
                <input type="text" id="addtess" class="form-control" value="<?php echo htmlspecialchars(($profile['purok_name'] ?? '') . ' ' . ($profile['brgy'] ?? '') . ' ' . ($profile['city'] ?? '') . ' ' . ($profile['province'] ?? '')); ?>" readonly>
            </div>

        <a href="../users/user_profile.php?edit=true" class="btn btn-success btn-block">Edit Profile</a>

        <?php endif; ?>
  
</body>
<script>
        // Function to calculate the age based on the date of birth
        function calculateAge(dob) {
            const today = new Date();
            const birthDate = new Date(dob);  // Convert dob to Date object

            let age = today.getFullYear() - birthDate.getFullYear();
            const month = today.getMonth();
            const day = today.getDate();

            // Adjust age if the birthday hasn't occurred yet this year
            if (month < birthDate.getMonth() || (month === birthDate.getMonth() && day < birthDate.getDate())) {
                age--;
            }

            return age;
        }

        // Function to automatically fill in the age field when DOB is entered
        function autoCalculateAge() {
            const dob = document.getElementById('dob').value;  // Get the DOB value
            console.log("DOB Selected: ", dob);  // Log the value of dob

            if (dob) {
                const calculatedAge = calculateAge(dob);
                console.log("Calculated Age: ", calculatedAge);  // Log the calculated age

                // Update the age field with the calculated age
                const ageField = document.getElementById('age');
                if (ageField) {
                    ageField.value = calculatedAge;  // Set the calculated age to the age field
                    console.log("Age Field Updated: ", ageField.value);  // Log the updated value
                }
            } else {
                // If DOB is empty, clear the age field
                const ageField = document.getElementById('age');
                if (ageField) {
                    ageField.value = '';  // Clear the age field if DOB is empty
                }
            }
        }

        // Ensure the DOM is fully loaded before adding the event listener
        document.addEventListener('DOMContentLoaded', function() {
            const dobField = document.getElementById('dob');
            if (dobField) {
                dobField.addEventListener('input', autoCalculateAge);  // Attach event listener to DOB field
            }
        });
    
        // Ensure DOM is loaded before attaching event listeners
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file-input');
        const profileImg = document.getElementById('profile-img');
        const cameraIcon = document.getElementById('camera-icon');

        // Trigger file input click when camera icon is clicked
        cameraIcon.addEventListener('click', () => {
            fileInput.click();
        });

        // Preview the selected image
        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0]; // Get the selected file
            if (file) {
                const reader = new FileReader(); // Create FileReader to read the file
                reader.onload = function (e) {
                    profileImg.src = e.target.result; // Set the image src to the selected file's data URL
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        });
    });
    </script>


<script src="https://kit.fontawesome.com/f9f0cbfe40.js" crossorigin="anonymous"></script>
</html>