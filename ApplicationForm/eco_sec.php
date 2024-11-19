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
  // Handle case where the user doesn't exist
  die("User not found.");
}

// Get parent_id (user id)
$parent_id = $user['user_id'];

// Query to check if economic data exists for this user
$query = "SELECT * FROM eco_sec WHERE parent_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$parent_id]);
$eco_data = $stmt->fetch(PDO::FETCH_ASSOC);

// If no data found, set eco_data to an empty array
if (!$eco_data) {
  $eco_data = [
      'source_of_income' => '',
      'monthly_income_range' => '',
      'other_income_source' => '',
      'monthly_income' => '',
      'other_business' => '',
      'sss_type' => '',
      'pension_fund' => ''
  ];
}

// Handle form submission (either insert or update)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect selected income sources and monthly income range
    $income_sources = isset($_POST['income']) ? implode(", ", $_POST['income']) : null;
    $monthly_income_range = isset($_POST['income_range']) ? implode(", ", $_POST['income_range']) : null;
    $other_income_source = !empty($_POST['other_income']) ? htmlspecialchars($_POST['other_income'], ENT_QUOTES) : null;
    $monthly_income = isset($_POST['monthly_income']) ? $_POST['monthly_income'] : null;
    $other_business = !empty($_POST['other_business']) ? htmlspecialchars($_POST['other_business'], ENT_QUOTES) : null;
    $sss_type = isset($_POST['sss_type']) ? $_POST['sss_type'] : null;
    $pension_fund = isset($_POST['pension_fund']) ? $_POST['pension_fund'] : ''; // Set default to an empty string if not set


    if ($eco_data) {
        // Update existing data
        $query = "UPDATE eco_sec 
                  SET source_of_income = ?, monthly_income_range = ?, other_income_source = ?, monthly_income = ?, other_business = ?, sss_type = ?, pension_fund = ? 
                  WHERE parent_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$income_sources, $monthly_income_range, $other_income_source, $monthly_income, $other_business, $sss_type, $pension_fund, $parent_id]);
    } else {
        // Insert new data
        $query = "INSERT INTO eco_sec (parent_id, source_of_income, monthly_income_range, other_income_source, monthly_income, other_business, sss_type, pension_fund) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$parent_id, $income_sources, $monthly_income_range, $other_income_source, $monthly_income, $other_business, $sss_type, $pension_fund]);
    }

    // Redirect to the next section
    header("Location: ../users/user_dashboard.php"); // Update with the correct next page
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
                <input type="checkbox" name="income[]" value="salary" <?php echo (strpos($eco_data['source_of_income'], 'salary') !== false) ? 'checked' : ''; ?>> 1. Own earnings, salary / wages <br>
                <input type="checkbox" name="income[]" value="pension" id="pensionCheckbox" <?php echo (strpos($eco_data['source_of_income'], 'pension') !== false) ? 'checked' : ''; ?>> 2. Own Pension
                <div id="pensionOptions" style="margin-left: 20px; <?php echo (strpos($eco_data['source_of_income'], 'pension') !== false) ? 'display:block;' : 'display:none;'; ?>">
                    <!-- SSS Options -->
                    <label for="sss_type">SSS Pension Type:</label>
                    <select id="sssType" name="sss_type" class="form-select">
                        <option value=""> Select Type </option>
                        <option value="retirement" <?php echo ($eco_data['sss_type'] == 'retirement') ? 'selected' : ''; ?>>Retirement Pension</option>
                        <option value="disability" <?php echo ($eco_data['sss_type'] == 'disability') ? 'selected' : ''; ?>>Disability Pension</option>
                        <option value="survivor" <?php echo ($eco_data['sss_type'] == 'survivor') ? 'selected' : ''; ?>>Survivor Pension</option>
                    </select> <br>
                    <input type="radio" name="pension_fund" value="pagibig" <?php echo ($eco_data['pension_fund'] == 'pagibig') ? 'checked' : ''; ?>> PagIbig Pension <br>
                    <input type="radio" name="pension_fund" value="gsis" <?php echo ($eco_data['pension_fund'] == 'gsis') ? 'checked' : ''; ?>> GSIS Pension <br>
                    <input type="radio" name="pension_fund" value="province" <?php echo ($eco_data['pension_fund'] == 'province') ? 'checked' : ''; ?>> Provincial Fund <br>
                    <input type="radio" name="pension_fund" value="national" <?php echo ($eco_data['pension_fund'] == 'national') ? 'checked' : ''; ?>> National Fund <br>
                </div>
                <br>
                <input type="checkbox" name="income[]" value="dependents" <?php echo (strpos($eco_data['source_of_income'], 'dependents') !== false) ? 'checked' : ''; ?>> 3. Dependent on children / relatives<br>
                <input type="checkbox" name="income[]" value="spouse_salary" <?php echo (strpos($eco_data['source_of_income'], 'spouse_salary') !== false) ? 'checked' : ''; ?>> 4. Spouse's salary<br>
                <input type="checkbox" name="income[]" value="spouse_pension" <?php echo (strpos($eco_data['source_of_income'], 'spouse_pension') !== false) ? 'checked' : ''; ?>> 5. Spouse's Pension<br>
                <input type="checkbox" name="income[]" value="rentals" <?php echo (strpos($eco_data['source_of_income'], 'rentals') !== false) ? 'checked' : ''; ?>> 6. Rentals / Sharecrops<br>
                <input type="checkbox" name="income[]" value="savings" <?php echo (strpos($eco_data['source_of_income'], 'savings') !== false) ? 'checked' : ''; ?>> 7. Savings<br>
                <input type="checkbox" name="income[]" value="livestock" <?php echo (strpos($eco_data['source_of_income'], 'livestock') !== false) ? 'checked' : ''; ?>> 8. Livestock / orchard / farm<br>
                <input type="checkbox" name="income[]" value="fishin" <?php echo (strpos($eco_data['source_of_income'], 'fishing') !== false) ? 'checked' : ''; ?>> 9. Fishing<br>
                <!-- Other Business field -->
                <div>
                    <input type="text" class="form-control mt-2" name="other_business" placeholder="Other, specify" value="<?php echo htmlspecialchars($eco_data['other_business']); ?>">
                </div>
              </div>

              <!-- Monthly Income Section -->
              <div class="col-md-6">
                <label>33. Monthly Income</label><br>
                <input type="checkbox" name="income_range[]" value="1000-5000" <?php echo (strpos($eco_data['monthly_income_range'], '1000-5000') !== false) ? 'checked' : ''; ?>> Php 1,000.00 to Php 5,000.00 <br>
                <input type="checkbox" name="income_range[]" value="5000-10000" <?php echo (strpos($eco_data['monthly_income_range'], '5000-10000') !== false) ? 'checked' : ''; ?>> Php 5,000.00 to Php 10,000.00 <br>
                <input type="checkbox" name="income_range[]" value="10000-20000" <?php echo (strpos($eco_data['monthly_income_range'], '10000-20000') !== false) ? 'checked' : ''; ?>> Php 10,000.00 to Php 20,000.00 <br>
                <input type="checkbox" name="income_range[]" value="20000-50000" <?php echo (strpos($eco_data['monthly_income_range'], '20000-50000') !== false) ? 'checked' : ''; ?>> Php 20,000.00 to Php 50,000.00 <br>
                <input type="checkbox" name="income_range[]" value="50000-above" <?php echo (strpos($eco_data['monthly_income_range'], '50000-above') !== false) ? 'checked' : ''; ?>> Php 50,000.00 and above <br>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <br>
              <button type="submit" class="btn btn-primary">Save</button>
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