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

    $famQuery = "SELECT * FROM family_sec WHERE parent_id = ?";
    $famStmt = $pdo->prepare($famQuery);
    $famStmt->execute([$user_id]);

    // Check if any data exists
    if ($famStmt->rowCount() > 0) {
        $fam = $famStmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Default values if no data found
        $fam = [
            'spouse_lastname' => '',
            'spouse_firstname' => '',
            'spouse_middlename' => '',
            'spouse_extension' => '',
            'father_lastname' => '',
            'father_firstname' => '',
            'father_middlename' => '',
            'father_extension' => '',
            'mother_lastname' => '',
            'mother_firstname' => '',
            'mother_middlename' => '',
            'mother_extension' => ''
        ];
    }

} else {
    // Handle the case where the user does not exist
    die("User not found.");
}


  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capture the form data
    $spouse_lastname = $_POST['spouse_lastname'];
    $spouse_firstname = $_POST['spouse_firstname'];
    $spouse_middlename = $_POST['spouse_middlename'];
    $spouse_extension = $_POST['spouse_extension'];
    $father_lastname = $_POST['father_lastname'];
    $father_firstname = $_POST['father_firstname'];
    $father_middlename = $_POST['father_middlename'];
    $father_extension = $_POST['father_extension'];
    $mother_lastname = $_POST['mother_lastname'];
    $mother_firstname = $_POST['mother_firstname'];
    $mother_middlename = $_POST['mother_middlename'];
    $mother_extension = $_POST['mother_extension'];
    
    $existsQuery = "SELECT COUNT(*) FROM family_sec WHERE parent_id = ?";
    $stmt = $pdo->prepare($existsQuery);
    $stmt->execute([$user_id]);
    $recordExists = $stmt->fetchColumn();

if ($recordExists) {
    // Update existing record
    $updateQuery = "
        UPDATE family_sec SET 
        spouse_lastname = ?, spouse_firstname = ?, spouse_middlename = ?, spouse_extension = ?, 
        father_lastname = ?, father_firstname = ?, father_middlename = ?, father_extension = ?, 
        mother_lastname = ?, mother_firstname = ?, mother_middlename = ?, mother_extension = ? 
        WHERE parent_id = ?"; // Use parent_id here to identify the record

    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([
        $spouse_lastname, $spouse_firstname, $spouse_middlename, $spouse_extension,
        $father_lastname, $father_firstname, $father_middlename, $father_extension,
        $mother_lastname, $mother_firstname, $mother_middlename, $mother_extension,
        $user_id // Corrected to use $user_id for the parent_id in WHERE
    ]);
} else {
    // Insert new record
    $insertQuery = "
        INSERT INTO family_sec 
            (parent_id, spouse_lastname, spouse_firstname, spouse_middlename, spouse_extension, 
            father_lastname, father_firstname, father_middlename, father_extension, 
            mother_lastname, mother_firstname, mother_middlename, mother_extension)
        VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([
            $user_id, $spouse_lastname, $spouse_firstname, $spouse_middlename, $spouse_extension,
            $father_lastname, $father_firstname, $father_middlename, $father_extension,
            $mother_lastname, $mother_firstname, $mother_middlename, $mother_extension
        ]);
}

        // Redirect to edu_sec.php after successful operation
        header("Location: edu_sec.php");
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

        <!-- Index2 -->
        <form method="POST" action="family_sec.php" enctype="multipart/form-data">
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
                <input type="text" class="form-control" id="spouse_lastname" name="spouse_lastname" value="<?php echo htmlspecialchars($fam['spouse_lastname'] ?? ''); ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="firstname">Firstname (Pangalan) *</label>
                <input type="text" class="form-control" id="spouse_firstname" name="spouse_firstname" value="<?php echo htmlspecialchars($fam['spouse_firstname'] ?? ''); ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="middlename">Middlename (Gitnang Pangalan) *</label>
                <input type="text" class="form-control" id="spouse_middlename" name="spouse_middlename" value="<?php echo htmlspecialchars($fam['spouse_middlename'] ?? ''); ?>">
            </div>
            <div class="form-group col-md-2">
                <label for="extension">Extension</label>
        <input type="text" class="form-control" id="spouse_extension" name="spouse_extension" value="<?php echo htmlspecialchars($fam['spouse_extension'] ?? ''); ?>">
            </div>

            <div class="FATHER-TEXT">
                <p class="fs-2"><b>
                    21.  Name of your Father</b>
                </p>
              </div>
        
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="lastname">Lastname (Apelyido) *</label>
                    <input type="text" class="form-control" id="father_lastname" name="father_lastname" value="<?php echo htmlspecialchars($fam['father_lastname'] ?? ''); ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="firstname">Firstname (Pangalan) *</label>
                    <input type="text" class="form-control" id="father_firstname" name="father_firstname" value="<?php echo htmlspecialchars($fam['father_firstname'] ?? ''); ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="middlename">Middlename (Gitnang Pangalan) *</label>
                    <input type="text" class="form-control" id="father_middlename" name="father_middlename" value="<?php echo htmlspecialchars($fam['father_middlename'] ?? ''); ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="extension">Extension</label>
                <input type="text" class="form-control" id="father_extension" name="father_extension" value="<?php echo htmlspecialchars($fam['father_extension'] ?? ''); ?>">
                </div>

                <div class="mother-TEXT">
                    <p class="fs-2"><b>
                        21.  Name of your Mother</b>
                    </p>
                  </div>
            
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="lastname">Lastname (Apelyido) *</label>
                        <input type="text" class="form-control" id="mother_lastname" name="mother_lastname" value="<?php echo htmlspecialchars($fam['mother_lastname'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="firstname">Firstname (Pangalan) *</label>
                        <input type="text" class="form-control" id="mother_firstname" name="mother_firstname" value="<?php echo htmlspecialchars($fam['mother_firstname'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="middlename">Middlename (Gitnang Pangalan) *</label>
                        <input type="text" class="form-control" id="mother_middlename" name="mother_middlename" value="<?php echo htmlspecialchars($fam['mother_middlename'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="extension">Extension</label>
                        <input type="text" class="form-control" id="mother_extension" name="mother_extension" value="<?php echo htmlspecialchars($fam['mother_extension'] ?? ''); ?>">
                    </div>    
                </div>
                <button class="btn-next mt-3">Back</button>
                <button type="submit" class="btn-next mt-3">Next</button>
            </div>
   
</form>


<script>

</script>
    <script src="js/form.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>