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
    $profileQuery = "SELECT * FROM profile WHERE profile_id = ?";
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

if ($stmt->rowCount() > 0) {
    $users = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['user_id']; // Fetch the user_id from the users table

    // Fetch profile data using the user_id (as profile_id)
    $infoQuery = "SELECT * FROM information_sec WHERE info_id = ?";
    $infoStmt = $pdo->prepare($infoQuery);
    $infoStmt->execute([$user_id]);

// Check if profile exists
if ($infoStmt->rowCount() > 0) {
    $info = $infoStmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Initialize profile array to prevent undefined index errors
    $info = [
        'extension' => '',
        'region' => '',
        'city' => '',
        'residence' => '',
        'month' => '',
        'day' => '',
        'year' => '',
        'birthPlace' => '',
        'status' => '',
        'gender' => '',
        'religion' => '',
        'contactNumber' => '',
        'fbMessenger' => '',
        'ethnicOrigin' => '',
        'language' => '',
        'oscaID' => '',
        'sss' => '',
        'tin' => '',
        'philHealth' => '',
        'sc_num' => '',
        'other_gov_id' => '',
        'employment' => '',
        'pension' => '',
        'travel' => ''
    ];
}
} else {
// Handle the case where the user does not exist
die("User not found.");
}
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SeniorsFirst</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../form_css/form.css" rel="stylesheet">
  </head>
  <body>
    <div class="container-fluid my-custom-container mt-4">
    <div class="back-button" onclick="window.location.href='../users/user_dashboard.php';">&#x2190;</div>
      <div class="row">
        <div class="col-md-12 custom-header text-center">
          <p class="fs-6">Republic of the Philippines</p>
          <p class="fs-6">Office of the President of the Republic of the Philippines</p>
          <p class="fs-2">NATIONAL COMMISSION OF SENIOR CITIZENS<p>
        </div>
        </div>
        <div class="row blue-banner">
          <div class="col-md-12">
            <img src="../Images/logo-removebg_upscayl_1x_ultrasharp.png" alt="">
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
      <p class="fs-2"><b>1. Name</b><scan>- Enter your name correctly</scan>
      </p>
    </div>
      
  
    <form  method="POST" action="form1.php" enctype="multipart/form-data">
      <div class="form-row">
          <div class="form-group col-md-3">
              <label for="lastname">Lastname (Apelyido) *</label>
              <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($profile['lastname'] ?? ''); ?>" required>
          </div>
          <div class="form-group col-md-3">
              <label for="firstname">Firstname (Pangalan) *</label>
              <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($profile['firstname'] ?? ''); ?>" required>
          </div>
          <div class="form-group col-md-3">
              <label for="middlename">Middlename (Gitnang Pangalan) *</label>
              <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlspecialchars($profile['middlename'] ?? ''); ?>" required>
          </div>
          <div class="form-group col-md-2">
              <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="extensionCheckbox" name="extension">
                  <label class="form-check-label" for="extensionCheckbox"  style="font-size: 12px;">
                      Check if the registrant has a name extension
                  </label>
              </div>
          </div>
          <div class="form-group col-md-1">
              <label for="extension">Extension</label>
      <input type="text" class="form-control" id="extension" name="extension" value="<?php echo htmlspecialchars($info['extension'] ?? ''); ?>">
          </div>
      <div class="row mb-3">
        <div class="col-md-12 custom-text-danger">
            <p class="text-danger">How do you type Ñ in your phone or laptop? <a href="#">Click here!</a></p>
        </div>
    </div>
    <div class="col-md-12 mt-4 mb-3 custom-address-text">
    <h6><b>2. Address</b><scan>- Select region first, and then province, then city, and finally your barangay</scan></h6>
    
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="region">Region *</label>
            <select class="form-control" id="region" name="region" value="<?php echo htmlspecialchars($info['region'] ?? ''); ?>" required>
                <option value="" disabled selected>Select Region</option>
                <option>BARMM</option>
                <option>CAR</option>
                <option>NCR</option>
                <option>Region I</option>
                <option>Region II</option>
                <option>Region III</option>
                <option>Region IV</option>
                <option>Region V</option>
                <option value="region" <?php echo ($info['region'] == 'Region VI') ? 'selected' : ''; ?>>Region VI</option>
                <option>Region VII</option>
                <option>Region VIII</option>
                <option>Region IX</option>
                <option>Region X</option>
                <option>Region XI</option>
                <option>Region XII</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="province">Province *</label>
            <select class="form-control" id="province" name="province" value="<?php echo htmlspecialchars($profile['province'] ?? ''); ?>" required>
                <option value="" disabled selected>Select Province</option>
                <option value="Negros Occidental" <?php echo ($profile['province'] == 'Negros Occidental') ? 'selected' : ''; ?>>Negros Occidental</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="city">City *</label>
            <select class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>" required>
                <option value="" disabled selected>Select City</option>
                <option value="Hinoba-an" <?php echo ($profile['city'] == 'Hinoba-an') ? 'selected' : ''; ?>>Hinoba-an</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="barangay">Barangay *</label>
            <select class="form-control" id="brgy" name="brgy" value="<?php echo htmlspecialchars($profile['brgy'] ?? ''); ?>" required>
                <option value="Bacuyangan"<?php if (($profile['brgy'] ?? '') == 'Bacuyangan') echo 'selected'; ?>>Bacuyangan</option>
            </select>
        </div>
        <div class="col-md-12 mt-4 mb-3 custom-residence">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="residence" class="form-label">Residence (House No./Block/Lot)</label>
                <input type="text" id="residence" name="residence" class="form-control" value="<?php echo htmlspecialchars($info['residence'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="zone" class="form-label">Street (Zone/Purok/Sitio) - Not required</label>
                <input type="text" id="zone" name="zone" class="form-control" value="<?php echo htmlspecialchars($profile['zone'] ?? ''); ?>">
            </div>
        </div>
        </div>
        <div class="col-md-12 mt-4 mb-3 custom-birthdate-text">
            <h6><b>3. Bith Date</b> <scan>- Indicate your birth date correctly</scan></h6>
            
            </div>
        <div class="form-group col-md-2">
            <label for="Month">Month *</label>
            <input type="number" class="form-control" id="month" name="month" required min="1" max="12" value="<?php echo htmlspecialchars($info['month'] ?? ''); ?>" required>
        </div>
        <div class="form-group col-md-2">
          <label for="birthDay">Day *</label>
          <input type="number" class="form-control" id="day" name="day" required min="1" max="31" value="<?php echo htmlspecialchars($info['day'] ?? ''); ?>" required>
      </div>
      <div class="form-group col-md-2">
          <label for="birthYear">Year *</label>
          <input type="number" class="form-control" id="year" name="year" required min="1900" max="2024" value="<?php echo htmlspecialchars($info['year'] ?? ''); ?>" required>
      </div>
      </div>
  </div>

 
  <div class="row mb-3">
      <div class="col-md-6">
          <label for="birthPlace" class="form-label">4.Birth Place</label>
          <input type="text" id="birthPlace" class="form-control" name="birthPlace" value="<?php echo htmlspecialchars($info['birthPlace'] ?? ''); ?>">
      </div>
        <div class=" col-md-2">
            <label for="status">5.Marital Status*</label>
            <select class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($info['status'] ?? ''); ?>" required>
                <option value="" disabled selected>Select Status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
                <option value="Seperated">Separated</option>
                
            </select>
          </div>
          <div class="col-md-2">
            <label for="religion" class="form-label">6.Religion</label>
            <select id="religion" class="form-control" name="religion" value="<?php echo htmlspecialchars($info['religion'] ?? ''); ?>" required>
              <!-- add options here -->
              <option value="" disabled selected>Select a religion</option>
              <option value="Christian">Christian</option>
              <option value="Islam">Islam</option>
              <option value="Roman Catholic">Roman Catholic</option>
              <option value="INC">Iglesia ni Cristo</option>
            </select>
          </div>
          <div class=" col-md-2">
            <label for="gender">7.Sex at Birth*</label>
            <select class="form-control" id="gender" name="gender"  required>
                <option value="male"<?php if (($profile['gender'] ?? '') == 'male') echo 'selected'; ?>>Male</option>
                <option value="female"<?php if (($profile['gender'] ?? '') == 'male') echo 'selected'; ?>>Female</option>
            </select>
          </div>
      </div>
  <div class="row mb-3">
      <div class="col-md-3">
          <label for="contactNumber" class="form-label">8.Contact Number<span class="mandatory">*</span></label>
          <input type="tel" id="contactNumber" name="contactNumber" class="form-control" value="<?php echo htmlspecialchars($info['contactNumber'] ?? ''); ?>" required>
      </div>
      <div class="col-md-3">
          <label for="email" class="form-label">9a.Email Address<span class="mandatory">*</span></label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Put NONE if no email" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>">
      </div>
      <div class="col-md-3">
          <label for="fbMessenger" class="form-label">9b.FB Messenger Name</label>
          <input type="text" id="fbMessenger" name="fbMessenger" class="form-control" value="<?php echo htmlspecialchars($info['fbMessenger'] ?? ''); ?>">
      </div>
      <div class="col-md-3">
          <label for="ethnicOrigin" class="form-label">10.Ethnic Origin</label>
          <input type="text" id="ethnicOrigin" name="ethnicOrigin" class="form-control" value="<?php echo htmlspecialchars($info['ethnicOrigin'] ?? ''); ?>">
      </div>
  </div>
  <!-- Additional Fields -->
  <div class="row mb-3 custom-five-input-layout">
      <div class="col-md-4">
          <label for="language" class="form-label">11.Language Spoken</label>
          <input type="text" id="language" name="language" class="form-control" value="<?php echo htmlspecialchars($info['language'] ?? ''); ?>">
      </div>
      <div class="col-md-2">
          <label for="oscaId" class="form-label">12.OSCA ID No.</label>
          <input type="text" id="oscaId" name="oscaId" class="form-control" value="<?php echo htmlspecialchars($info['oscaID'] ?? ''); ?>">
      </div>
      <div class="col-md-2">
          <label for="sss" class="form-label">13.GSIS/SSS No.</label>
          <input type="text" id="sss" name="sss" class="form-control" value="<?php echo htmlspecialchars($info['sss'] ?? ''); ?>">
      </div>
      <div class="col-md-2">
        <label for="tin" class="form-label"> 14. TIN</label>
        <input type="text" id="tin" name="tin" class="form-control" value="<?php echo htmlspecialchars($info['tin'] ?? ''); ?>">
    </div>  
    <div class="col-md-2">
        <label for="PhilHealth" class="form-label">15. PhilHealth No.</label>
        <input type="text" id="hilHealth" name="philHealth" class="form-control" value="<?php echo htmlspecialchars($info['philHealth'] ?? ''); ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-3">
          <label for="sc_num" class="form-label">16. SC Association ID No.</label>
          <input type="text" id="sc_num" name="sc_num" class="form-control" value="<?php echo htmlspecialchars($info['sc_num'] ?? ''); ?>">
      </div>
      <div class="col-md-2">
          <label for="other_gov_id" class="form-label"> 17. Other Gov't ID No.</label>
          <input type="text" id="other_gove_id" name="other_gov_id" class="form-control" value="<?php echo htmlspecialchars($info['other_gov_id'] ?? ''); ?>">
      </div>
      <div class="col-md-3">
        <label for="employment" class="form-label">18. Employment / Business</label>
        <input type="text" id="employment" name="employment" class="form-control" value="<?php echo htmlspecialchars($info['employment'] ?? ''); ?>">
    </div>
    <div class="col-md-2">
        <label for="pension" class="form-label">19. Has Pension</label>
        <input type="text" id="pension" name="pension" class="form-control" value="<?php echo htmlspecialchars($info['pension'] ?? ''); ?>">
    </div>
      <div class="col-md-2">
          <label for="travel" class="form-label"> 20. Capability to Travel</label>
          <input type="text" id="travel" name="travel" class="form-control" value="<?php echo htmlspecialchars($info['travel'] ?? ''); ?>">
      </div>
  </div>
</form>

	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>