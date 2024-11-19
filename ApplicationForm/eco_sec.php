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
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Get the parent_id (user_id)
$parent_id = $user['user_id'];

// Handle form submission for storing or updating data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate form data
  $own_pension_type = isset($_POST['own_pension_type']) ? htmlspecialchars($_POST['own_pension_type']) : '';
  $income_sources = isset($_POST['income']) ? implode(", ", $_POST['income']) : '';
  $income_range = isset($_POST['income_range']) ? implode(", ", $_POST['income_range']) : '';
  $other_income = isset($_POST['other_income']) ? htmlspecialchars($_POST['other_income']) : '';
  $sss_type = isset($_POST['sss_type']) ? htmlspecialchars($_POST['sss_type']) : '';

  // Check if data already exists for the user
  $query = "SELECT * FROM eco_sec WHERE parent_id = :parent_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':parent_id', $parent_id);
  $stmt->execute();

  if ($stmt->rowCount() == 0) {  // No existing record for this user
      // Insert new economic profile data into the eco_sec table
      $query = "INSERT INTO eco_sec (parent_id, income_sources, income_range, other_income, sss_type, own_pension_type) 
                VALUES (:parent_id, :income_sources, :income_range, :other_income, :sss_type, :own_pension_type)";

      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':parent_id', $parent_id);
      $stmt->bindParam(':income_sources', $income_sources);
      $stmt->bindParam(':income_range', $income_range);
      $stmt->bindParam(':other_income', $other_income);
      $stmt->bindParam(':sss_type', $sss_type);
      $stmt->bindParam(':own_pension_type', $own_pension_type);

      if ($stmt->execute()) {
          header("Location: ../users/user_dashboard.php");
          exit(); // Ensure no further code is executed after redirect
      } else {
          echo "Error saving economic profile.";
      }
  } else {  // Data exists, so update it
      // Update the existing economic profile data
      $query = "UPDATE eco_sec SET income_sources = :income_sources, income_range = :income_range, 
                other_income = :other_income, sss_type = :sss_type, own_pension_type = :own_pension_type 
                WHERE parent_id = :parent_id";
      
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':income_sources', $income_sources);
      $stmt->bindParam(':income_range', $income_range);
      $stmt->bindParam(':other_income', $other_income);
      $stmt->bindParam(':sss_type', $sss_type);
      $stmt->bindParam(':own_pension_type', $own_pension_type);
      $stmt->bindParam(':parent_id', $parent_id);
      
      if ($stmt->execute()) {
        header("Location: ../users/user_dashboard.php");
        exit(); // Ensure no further code is executed after redirect
      } else {
          echo "Error updating economic profile.";
      }
  }
}

// Fetch the existing economic profile data for display and editing
$query = "SELECT * FROM eco_sec WHERE parent_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$parent_id]);
$eco_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if there's existing data, if not, initialize variables to empty strings
$income_sources = isset($eco_data['income_sources']) ? explode(", ", $eco_data['income_sources']) : [];
$income_range = isset($eco_data['income_range']) ? explode(", ", $eco_data['income_range']) : [];
$other_income = isset($eco_data['other_income']) ? $eco_data['other_income'] : '';

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
  <div>
    <div class="container-fluid my-custom-container mt-4">
      <div class="row">
        <div class="col-md-12 custom-header text-center">
          <p class="fs-6">Republic of the Philippines</p>
          <p class="fs-6">Office of the President of the Republic of the Philippines</p>
          <p class="fs-2">NATIONAL COMMISSION OF SENIOR CITIZENS</p>
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
    <!-- Economic Profile Form -->
    <form method="POST" action="eco_sec.php" enctype="multipart/form-data">
            <div class="ed">
                <div class="eco row mt-4">
                    <div class="col-12 section-header">
                        <h5>V. ECONOMIC PROFILE</h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-start w-100">
                        <!-- Source of Income Section -->
                        <div class="col-md-6">
                            <label>32. Source of Income and Assistance (Check all applicable)</label><br>
                            <input type="checkbox" name="income[]" value="salary" <?php echo in_array('salary', $income_sources) ? 'checked' : ''; ?>> 1. Own earnings, salary / wages<br>
                            <input type="checkbox" name="income[]" value="pension" id="pensionCheckbox" <?php echo in_array('pension', $income_sources) ? 'checked' : ''; ?>> 2. Own Pension
                            <div id="pensionOptions" style="display: <?php echo in_array('pension', $income_sources) ? 'block' : 'none'; ?>; margin-left: 20px;">
                            <input type="radio" name="pension_type" value="sss" id="sssRadio" <?php echo in_array('sss', $income_range) ? 'checked' : ''; ?>> SSS Pension<br>
                            <div id="sssOptions" style="display: <?php echo (isset($eco_data['sss_type']) && $eco_data['sss_type']) ? 'block' : 'none'; ?>; margin-left: 20px;">
                                <label for="sssType">Choose SSS Type:</label>
                                <select id="sssType" name="sss_type" class="form-select">
                                    <option value="">Select Pension Type</option>
                                    <option value="retirement" <?php echo isset($eco_data['sss_type']) && $eco_data['sss_type'] == 'retirement' ? 'selected' : ''; ?>>Retirement Pension</option>
                                    <option value="disability" <?php echo isset($eco_data['sss_type']) && $eco_data['sss_type'] == 'disability' ? 'selected' : ''; ?>>Disability Pension</option>
                                    <option value="survivor" <?php echo isset($eco_data['sss_type']) && $eco_data['sss_type'] == 'survivor' ? 'selected' : ''; ?>>Survivor Pension</option>
                                </select>
                                </div>
                                <input type="radio" name="own_pension_type" value="province" 
                                      <?php echo isset($eco_data['own_pension_type']) && $eco_data['own_pension_type'] == 'province' ? 'checked' : ''; ?>> Province Fund<br>
                                <input type="radio" name="own_pension_type" value="national" 
                                      <?php echo isset($eco_data['own_pension_type']) && $eco_data['own_pension_type'] == 'national' ? 'checked' : ''; ?>> National Fund<br>
                            </div>
                            <input type="checkbox" name="income[]" value="dependents" <?php echo in_array('dependents', $income_sources) ? 'checked' : ''; ?>> 3. Dependent on children / relatives<br>
                            <input type="checkbox" name="income[]" value="spouse_salary" <?php echo in_array('spouse_salary', $income_sources) ? 'checked' : ''; ?>> 4. Spouse's salary<br>
                            <input type="checkbox" name="income[]" value="spouse_pension" <?php echo in_array('spouse_pension', $income_sources) ? 'checked' : ''; ?>> 5. Spouse's Pension<br>
                            <input type="checkbox" name="income[]" value="rentals" <?php echo in_array('rentals', $income_sources) ? 'checked' : ''; ?>> 6. Rentals / sharecrops<br>
                            <input type="checkbox" name="income[]" value="savings" <?php echo in_array('savings', $income_sources) ? 'checked' : ''; ?>> 7. Savings<br>
                            <input type="checkbox" name="income[]" value="livestock" <?php echo in_array('livestock', $income_sources) ? 'checked' : ''; ?>> 8. Livestock / orchard / farm<br>
                            <input type="checkbox" name="income[]" value="fishing" <?php echo in_array('fishing', $income_sources) ? 'checked' : ''; ?>> 9. Fishing<br>
                            <input type="text" class="form-control mt-2" placeholder="Other, specify" name="other_income" value="<?php echo htmlspecialchars($other_income); ?>">
                        </div>

                        <!-- Monthly Income Section -->
                        <div class="col-md-6">
                            <label>31. Monthly Income (In Philippine Peso)</label><br>
                            <input type="checkbox" name="income_range[]" value="above_60000" <?php echo in_array('above_60000', $income_range) ? 'checked' : ''; ?>> 1. 60,000 and above<br>
                            <input type="checkbox" name="income_range[]" value="50000_60000" <?php echo in_array('50000_60000', $income_range) ? 'checked' : ''; ?>> 2. 50,000 to 60,000<br>
                            <input type="checkbox" name="income_range[]" value="40000_50000" <?php echo in_array('40000_50000', $income_range) ? 'checked' : ''; ?>> 3. 40,000 to 50,000<br>
                            <input type="checkbox" name="income_range[]" value="30000_40000" <?php echo in_array('30000_40000', $income_range) ? 'checked' : ''; ?>> 4. 30,000 to 40,000<br>
                            <input type="checkbox" name="income_range[]" value="20000_30000" <?php echo in_array('20000_30000', $income_range) ? 'checked' : ''; ?>> 5. 20,000 to 30,000<br>
                            <input type="checkbox" name="income_range[]" value="10000_20000" <?php echo in_array('10000_20000', $income_range) ? 'checked' : ''; ?>> 6. 10,000 to 20,000<br>
                            <input type="checkbox" name="income_range[]" value="5000_10000" <?php echo in_array('5000_10000', $income_range) ? 'checked' : ''; ?>> 7. 5,000 to 10,000<br>
                            <input type="checkbox" name="income_range[]" value="below_5000" <?php echo in_array('below_5000', $income_range) ? 'checked' : ''; ?>> 8. Below 5,000<br>
                        </div>
                    </div>

                    <!-- Save Changes Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </div>
            </div>
        </form>

<script>

</script>

  <script src="js/form.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>