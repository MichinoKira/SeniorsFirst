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
            'extension' => '',
            'email' => '',
            'age' => '',
            'gender' => '',
            'region' => '',
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


  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture the form data
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
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
    
    // Database insertion code goes here
    // Example: save to the database using PDO or MySQLi

    // Redirect to a success page after submission
    header("Location: success_page.php");
    exit();
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge'>
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
      <p class="fs-2"><b>1. Name</b><scan>- Enter your name correctly</scan>
      </p>
    </div>
      
  
    <form method="POST" action="applicationform.php" enctype="multipart/form-data">
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
          <div class="form-group col-md-1">
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
    <h6><b>2. Address</b><scan>- Select region first, and then province, then city, and finally your barangay</scan></h6>
    
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
            <h6><b>3. Bith Date</b> <scan>- Indicate your birth date correctly</scan></h6>
            
            </div>
        <div class="form-group col-md-2">
            <label for="Month">Month *</label>
            <input type="number" class="form-control" id="month" name="month" required min="1" max="12">
        </div>
        <div class="form-group col-md-2">
          <label for="birthDay">Day *</label>
          <input type="number" class="form-control" id="day" name="day" required min="1" max="31">
      </div>
      <div class="form-group col-md-2">
          <label for="birthYear">Year *</label>
          <input type="number" class="form-control" id="year" name="year" required>
      </div>
      </div>
  </div>

 
  <div class="row mb-3">
      <div class="col-md-6">
          <label for="birthPlace" class="form-label">Birth Place</label>
          <input type="text" id="birthPlace" name="birthPlace" class="form-control">
      </div>
        <div class=" col-md-2">
            <label for="status">Marital Status*</label>
            <select class="form-control" id="status" name="status" required>
                <option>Select Status</option>
                <!-- options here -->
            </select>
          </div>
          <div class="col-md-2">
              <label for="religion" class="form-label">Religion</label>
              <input type="text" id="religion" name="religion" class="form-control">
          </div>
          <div class=" col-md-2">
            <label for="ethnicOrigin">Ethnic Origin</label>
            <input type="text" id="ethnicOrigin" name="ethnicOrigin" class="form-control">
          </div>
      </div>

        <!-- Index2 -->
    <div class="mt-4">
        <p class="bg-primary text-white p-2">II. FAMILY COMPOSITION</p>
      </div>
      <div class="before-form">
        <p class="fs-2"><b>
            21.  Name of your spouse</b>
        </p>
      </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="spouse_lastname">Lastname (Apelyido) *</label>
                <input type="text" class="form-control" id="spouse_lastname" required>
            </div>
            <div class="form-group col-md-3">
                <label for="firstname">Firstname (Pangalan) *</label>
                <input type="text" class="form-control" id="spouse_firstname" required>
            </div>
            <div class="form-group col-md-3">
                <label for="middlename">Middlename (Gitnang Pangalan) *</label>
                <input type="text" class="form-control" id="spouse_middlename" required>
            </div>
            <div class="form-group col-md-2">
                <label for="extension">Extension</label>
        <input type="text" class="form-control" id="spouse_extension">
            </div>

            <div class="FATHER-TEXT">
                <p class="fs-2"><b>
                    21.  Name of your Father</b>
                </p>
              </div>
        
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="lastname">Lastname (Apelyido) *</label>
                    <input type="text" class="form-control" id="lastname" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="firstname">Firstname (Pangalan) *</label>
                    <input type="text" class="form-control" id="firstname" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="middlename">Middlename (Gitnang Pangalan) *</label>
                    <input type="text" class="form-control" id="middlename" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="extension">Extension</label>
            <input type="text" class="form-control" id="extension">
                </div>

                <div class="mother-TEXT">
                    <p class="fs-2"><b>
                        21.  Name of your Mother</b>
                    </p>
                  </div>
            
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="lastname">Lastname (Apelyido) *</label>
                        <input type="text" class="form-control" id="lastname" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="firstname">Firstname (Pangalan) *</label>
                        <input type="text" class="form-control" id="firstname" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="middlename">Middlename (Gitnang Pangalan) *</label>
                        <input type="text" class="form-control" id="middlename" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="extension">Extension</label>
                <input type="text" class="form-control" id="extension">
                    </div>    
                    </div>

    <!-- Index4 -->
     <div class="container">
  <!-- Education / HR Profile Section -->
  <div class="row">
    <div class="col-12 section-header">
      <h4>IV. EDUCATION / HR PROFILE</h4>
    </div>
    <div class="col-12">
      <label>27. Highest Educational Attainment</label><br>
      <input type="checkbox" name="education" value="elementary_level"> 1. Elementary Level<br>
      <input type="checkbox" name="education" value="elementary_grad"> 2. Elementary Graduate<br>
      <input type="checkbox" name="education" value="highschool_level"> 3. High School Level<br>
      <input type="checkbox" name="education" value="highschool_grad"> 4. High School Graduate<br>
      <input type="checkbox" name="education" value="college_level"> 5. College Level<br>
      <input type="checkbox" name="education" value="college_grad"> 6. College Graduate<br>
      <input type="checkbox" name="education" value="postgrad"> 7. Post Graduate<br>
      <input type="checkbox" name="education" value="vocational"> 8. Vocational<br>
      <input type="checkbox" name="education" value="not_attended"> 9. Not Attended School<br>
    </div>
  </div>

  <!-- Economic Profile Section -->
  <div class="row mt-4">
    <div class="col-12 section-header">
      <h4>V. ECONOMIC PROFILE</h4>
    </div>
    <div class="col-md-6">
      <label>32. Source of Income and Assistance (Check all applicable)</label><br>
      <input type="checkbox" name="income" value="salary"> 1. Own earnings, salary / wages<br>
      <input type="checkbox" name="income" value="pension" id="pensionCheckbox"> 2. Own Pension
      <div id="pensionOptions" style="display: none; margin-left: 20px;">
        <input type="radio" name="pension_type" value="sss"> SSS Pension<br>
        <input type="radio" name="pension_type" value="gsis"> GSIS Pension<br>
        <input type="radio" name="pension_type" value="private"> Private Pension<br>
      </div>
      <input type="checkbox" name="income" value="dependents"> 3. Dependent on children / relatives<br>
      <input type="checkbox" name="income" value="spouse_salary"> 4. Spouse's salary<br>
      <input type="checkbox" name="income" value="spouse_pension"> 5. Spouse's Pension<br>
      <input type="checkbox" name="income" value="rentals"> 6. Rentals / sharecrops<br>
      <input type="checkbox" name="income" value="savings"> 7. Savings<br>
      <input type="checkbox" name="income" value="livestock"> 8. Livestock / orchard / farm<br>
      <input type="checkbox" name="income" value="fishing"> 9. Fishing<br>
      <input type="text" class="form-control mt-2" placeholder="Other, specify">
    </div>

    <!-- Monthly Income Section -->
    <div class="col-md-6">
      <label>31. Monthly Income (In Philippine Peso)</label><br>
      <input type="checkbox" name="income_range" value="above_60000"> 1. 60,000 and above<br>
      <input type="checkbox" name="income_range" value="50000_60000"> 2. 50,000 to 60,000<br>
      <input type="checkbox" name="income_range" value="40000_50000"> 3. 40,000 to 50,000<br>
      <input type="checkbox" name="income_range" value="30000_40000"> 4. 30,000 to 40,000<br>
      <input type="checkbox" name="income_range" value="20000_30000"> 5. 20,000 to 30,000<br>
      <input type="checkbox" name="income_range" value="10000_20000"> 6. 10,000 to 20,000<br>
      <input type="checkbox" name="income_range" value="5000_10000"> 7. 5,000 to 10,000<br>
      <input type="checkbox" name="income_range" value="1000_5000"> 8. 1,000 to 5,000<br>
      <input type="checkbox" name="income_range" value="below_1000"> 9. Below 1,000<br>
    </div>
  </div>
</div>

   
</form>
    </div>

    <div>
    <button type="submit" class="btn btn-primary mt-4">Submit Application</button>
    </div>

<script>
            document.querySelector("form").addEventListener("submit", function(event) {
                let isValid = true;

                // Check if required fields are filled
                const requiredFields = document.querySelectorAll("[required]");
                requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add("is-invalid");
                } else {
                    field.classList.remove("is-invalid");
                }
                });

                // If not valid, prevent form submission
                if (!isValid) {
                event.preventDefault();
                alert("Please fill all required fields.");
                }
            });


    // Assume `regions` is an array of region objects in regions.js
window.onload = function() {
  loadRegions();
};

function loadRegions() {
  const regionSelect = document.getElementById('regions');
  
  regions.forEach(region => {
    const option = document.createElement('option');
    option.value = region.key; // Use unique code for region selection
    option.textContent = region.name;
    regionSelect.appendChild(option);
  });
}

function loadProvinces() {
  const regionCode = document.getElementById('regions').value;
  const provinceSelect = document.getElementById('provinces');
  provinceSelect.innerHTML = '<option value="">Select Province</option>'; // Reset

  provinces
    .filter(province => province.regionCode === regionCode)
    .forEach(province => {
      const option = document.createElement('option');
      option.value = province.key; // Use unique code for province selection
      option.textContent = province.name;
      provinceSelect.appendChild(option);
    });
}


function loadCities() {
  const provinceCode = document.getElementById('provinces').value;
  const citySelect = document.getElementById('cities');
  citySelect.innerHTML = '<option value="">Select City</option>'; // Reset

  cities
    .filter(city => city.provinceCode === provinceCode)
    .forEach(city => {
      const option = document.createElement('option');
      option.value = city.key; // Use unique code for city selection
      option.textContent = city.name;
      citySelect.appendChild(option);
    });
}




</script>

  <script src="../philippines/regions.js"></script>
  <script src="../philippines/provinces.js"></script>
  <script src="../philippines/cities.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>