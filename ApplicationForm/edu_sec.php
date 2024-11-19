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

// Query to get user information (to get parent_id)
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get parent_id (user id)
$parent_id = $user['user_id']; 

// Query to check if education data exists for this user
$query = "SELECT * FROM edu_sec WHERE parent_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$parent_id]);
$edu_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission (either insert or update)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect all selected education levels
    if (isset($_POST['education'])) {
        $education_levels = implode(", ", $_POST['education']); // Combine selected values into a string

        if ($edu_data) {
            // Update existing data
            $query = "UPDATE edu_sec SET education = ? WHERE parent_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$education_levels, $parent_id]);
        } else {
            // Insert new data
            $query = "INSERT INTO edu_sec (parent_id, education) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$parent_id, $education_levels]);
        }

        // Redirect to the next section
        header("Location: eco_sec.php"); // Update with the correct next page
        exit();
    } else {
        echo "No education level selected.";
    }
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
  
    <form method="POST" action="edu_sec.php" enctype="multipart/form-data">
            <!-- Education / HR Profile Section -->
            <div class="container">
                <div class="row">
                    <div class="col-12 section-header">
                        <h4>IV. EDUCATION / HR PROFILE</h4>
                    </div>
                    <div class="col-12">
                        <label>27. Highest Educational Attainment</label><br>

                        <?php
                        $education_levels = $edu_data ? explode(", ", $edu_data['education']) : []; // Fetch previously selected values if available

                        // List of education options
                        $options = [
                            'elementary_level' => '1. Elementary Level',
                            'elementary_grad' => '2. Elementary Graduate',
                            'highschool_level' => '3. High School Level',
                            'highschool_grad' => '4. High School Graduate',
                            'college_level' => '5. College Level',
                            'college_grad' => '6. College Graduate',
                            'postgrad' => '7. Post Graduate',
                            'vocational' => '8. Vocational',
                            'not_attended' => '9. Not Attended School',
                        ];

                        // Loop through the options and check if they were previously selected
                        foreach ($options as $value => $label) {
                            $checked = in_array($value, $education_levels) ? 'checked' : '';
                            echo "<input type='checkbox' name='education[]' value='$value' $checked> $label<br>";
                        }
                        ?>

                    </div>
                </div>
            </div>

            <button class="btn-next mt-3">Back</button>
            <button type="submit" class="btn-next mt-3">Next</button>
        </form>

<script>
</script>

    <script src="js/form.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
    
  </body>
</html>