<?php

// Start the session
session_start();

// Include the database configuration file
require_once '../db/db_config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
            'gender' => '',
            'region' => '',
            'province' => '',
            'city' => '',
            'brgy' => ''
        ];
    }

    $infoQuery = "SELECT * FROM info_sec WHERE parent_id = ?";
    $infoStmt = $pdo->prepare($infoQuery);
    $infoStmt->execute([$user_id]);

    // Check if any data exists
    if ($infoStmt->rowCount() > 0) {
        $info = $infoStmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Default values if no data found
        $info = [
            'month' => '',
            'day' => '',
            'year' => '',
            'birthPlace' => '',
            'status' => '',
            'religion' => '',
            'ethnicOrigin' => '',
            'oscaID' => ''
        ];
    }

} else {
    // Handle the case where the user does not exist
    die("User not found.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $extension = $_POST['extension'];
    $region = $_POST['region'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $brgy = $_POST['brgy'];
    $month = $_POST['month'];
    $day = $_POST['day'];
    $year = $_POST['year'];
    $birthPlace = $_POST['birthPlace'];
    $status = $_POST['status'];
    $religion = $_POST['religion'];
    $ethnicOrigin = $_POST['ethnicOrigin'];
    $oscaID = $_POST['oscaID'];

    $existsQuery = "SELECT COUNT(*) FROM info_sec WHERE parent_id = ?";
    $stmt = $pdo->prepare($existsQuery);
    $stmt->execute([$user_id]);
    $recordExists = $stmt->fetchColumn();

if ($recordExists) {
    // Update existing record
    $updateQuery = "
        UPDATE info_sec SET 
            firstname = ?, middlename = ?, lastname = ?, extension = ?, 
            region = ?, province = ?, city = ?, brgy = ?, 
            month = ?, day = ?, year = ?, birthPlace = ?, status = ?, 
            religion = ?, ethnicOrigin = ?, oscaID = ?
        WHERE parent_id = ?"; // Use parent_id here to identify the record

    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([
        $firstname, $middlename, $lastname, $extension,
        $region, $province, $city, $brgy,
        $month, $day, $year, $birthPlace, $status,
        $religion, $ethnicOrigin, $oscaID,
        $user_id // Corrected to use $user_id for the parent_id in WHERE
    ]);
} else {
    // Insert new record
    $insertQuery = "
        INSERT INTO info_sec 
            (parent_id, firstname, middlename, lastname, extension, 
            region, province, city, brgy, month, day, year, birthPlace, 
            status, religion, ethnicOrigin, oscaID)
        VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute([
        $user_id, $firstname, $middlename, $lastname, $extension,
        $region, $province, $city, $brgy, $month, $day, $year, $birthPlace,
        $status, $religion, $ethnicOrigin, $oscaID
    ]);
}

        // Redirect to family_sec.php after successful operation
        header("Location: family_sec.php");
        exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SeniorsFirst</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="form.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid my-custom-container mt-4">
      <div class="row">
        <div class="col-md-12 custom-header text-center">
          <p class="fs-6">Republic of the Philippines</p>
          <p class="fs-6">Office of the President of the Republic of the Philippines</p>
          <p class="fs-2">NATIONAL COMMISSION OF SENIOR CITIZENS<p>
        </div>
        </div>
        <div class="row blue-banner">
          <div class="col-md-12">
            <img src="Images/logo-removebg_upscayl_1x_ultrasharp.png" alt="">
              <h2 class="font-weight-bold custom-name-form">ONLINE SENIOR CITIZEN DATA FORM</h2>
          </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12 custom-new-application">
            <p class="text-danger custom-danger">New Application</p>
            <p>
                Please fill up completely and correctly the required information before each item below.  For items that are
                not associated to you, leave it blank.  Required items are also marked with an asterisk (*) so please fill it up correctly.
                Your honest response will help the National Commission of Senior Citizens (NCSC) come up with a good
                information system of the senior citizens in the country as the basis of designing its programs and activities that will help improve the lives of Filipino older persons.</p>
        </div>
    </div>
    <div class="mt-4">
      <p class="bg-primary text-white p-2">I. IDENTIFYING INFORMATION</p>
      <p class="text-danger">NOTICE: Do not include special characters like this *(#@!$%^&) in your name entry. This will create an issue in the record during verification.
         Extensions like SR. or JR., etc. must be entered separately by checking on the box provided below.</p>
    </div>
    <div class="before-form">
      <p class="fs-2"><b>Name</b><scan>- Enter your name correctly</scan>
      </p>
    </div>
      
  
    <form method="POST" action="info_sec.php" enctype="multipart/form-data">
      <div class="form-row">
          <div class="form-group col-md-2">
              <label for="lastname">Lastname (Apelyido) *</label>
              <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($profile['lastname'] ?? ''); ?>" required>
          </div>
          <div class="form-group col-md-2">
              <label for="firstname">Firstname (Pangalan) *</label>
              <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($profile['firstname'] ?? ''); ?>" required>
          </div>
          <div class="form-group col-md-3">
              <label for="middlename">Middlename (Gitnang Pangalan) *</label>
              <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlspecialchars($profile['middlename'] ?? ''); ?>" required>
          </div>
          <div class="form-group col-md-2">
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="extensionCheckbox">
                  <label class="form-check-label" for="extensionCheckbox"  style="font-size: 10px;">
                      Check if the registrant has a name extension
                  </label>
              </div>
          </div>
          <div class="form-group col-md-2">
              <label for="extension">Extension</label>
      <input type="text" class="form-control" id="extension" name="extension" value="<?php echo htmlspecialchars($profile['extension'] ?? ''); ?>">
          </div>
      <div class="row mb-3">
        <div class="col-md-12 custom-text-danger">
            <p class="text-danger">How do you type Ñ in your phone or laptop? <a href="#">Click here!</a></p>
        </div>
    </div>
    <div class="col-md-12 mt-4 mb-3 custom-address-text">
    <h6><b>Address</b><scan>- Select region first, and then province, then city, and finally your barangay</scan></h6>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="region">Region *</label>
            <input type="text" class="form-control" id="regions" name="region" value="<?php echo htmlspecialchars($profile['region'] ?? ''); ?>"  required>
        </div>
        <div class="form-group col-md-3">
            <label for="province">Province *</label>
            <input type="text" class="form-control" id="provinces" name="province" value="<?php echo htmlspecialchars($profile['province'] ?? ''); ?>" required>
        </div>
        <div class="form-group col-md-3">
            <label for="city">City *</label>
            <input type="text" class="form-control" id="cities" name="city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>" required>
        </div>
        <div class="form-group col-md-3">
            <label for="barangay">Barangay *</label>
            <input type="text" class="form-control" id="brgy" name="brgy" value="<?php echo htmlspecialchars($profile['brgy'] ?? ''); ?>"  required>
        </div>
        <div class="col-md-12 mt-4 mb-3 custom-birthdate-text">
            <h6><b>Birth Date</b> <scan>- Indicate your birth date correctly</scan></h6>
            
            </div>
        <div class="form-group col-md-2">
            <label for="Month">Month *</label>
            <input type="number" class="form-control" id="month" name="month" value="<?php echo htmlspecialchars($info['month'] ?? ''); ?>" required min="1" max="12">
        </div>
        <div class="form-group col-md-2">
          <label for="birthDay">Day *</label>
          <input type="number" class="form-control" id="day" name="day" value="<?php echo htmlspecialchars($info['day'] ?? ''); ?>" required min="1" max="31">
      </div>
      <div class="form-group col-md-2">
          <label for="birthYear">Year *</label>
          <input type="number" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($info['year'] ?? ''); ?>" required>
      </div>
  </div>

 
  <div class="row mb-3">
      <div class="col-md-4">
          <label for="birthPlace" class="form-label">Birth Place</label>
          <input type="text" id="birthPlace" name="birthPlace" class="form-control" value="<?php echo htmlspecialchars($info['birthPlace'] ?? ''); ?>" required>
      </div>
        <div class=" col-md-2">
            <label for="status">Marital Status*</label>
            <select class="form-control" id="status" name="status" required>
            <option value="" <?php echo empty($info['status']) ? 'selected' : ''; ?>>Select Status</option>
            <option value="Single" <?php echo ($info['status'] === 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo ($info['status'] === 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Divorced" <?php echo ($info['status'] === 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
            <option value="Separated" <?php echo ($info['status'] === 'Separated') ? 'selected' : ''; ?>>Separated</option>
            <option value="Widowed" <?php echo ($info['status'] === 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
            </select>
          </div>
          <div class="col-md-2">
              <label for="religion" class="form-label">Religion</label>
              <input type="text" id="religion" name="religion" class="form-control" value="<?php echo htmlspecialchars($info['religion'] ?? ''); ?>" required>
          </div>
          <div class=" col-md-2">
            <label for="ethnicOrigin">Ethnic Origin</label>
            <input type="text" id="ethnicOrigin" name="ethnicOrigin" class="form-control" value="<?php echo htmlspecialchars($info['ethnicOrigin'] ?? ''); ?>" required>
          </div>
          <div class=" col-md-2">
            <label for="OSCA">Osca Id</label>
            <input type="text" id="oscaID" name="oscaID" class="form-control" value="<?php echo htmlspecialchars($info['oscaID'] ?? ''); ?>" required>
          </div>
      </div>

      <button type="submit" class="btn-next mt-3">Next</button>
   
</form>

<script>

    

</script>
    <script src="js/form.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>