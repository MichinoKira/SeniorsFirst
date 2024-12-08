<?php
// Start the session and include the necessary files
session_start();
require_once '../db/db_config.php';

// Check if the user is logged in and is a BHW
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'bhw') {
    echo "Unauthorized access";
    exit();
}

// Get the logged-in BHW ID from the session
$bhw_id = $_SESSION['username']; 

try {
    // Correct the variable name to be consistent: $bhw_id (case sensitivity)
    $stmt = $pdo->prepare("SELECT bhw_id FROM bhw WHERE username = :username");
    $stmt->bindParam(':username', $bhw_id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $bhw_id = $row['bhw_id'];  // Correct BHW ID fetched from the database
    } else {
        echo "BHW ID not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching BHW ID: " . $e->getMessage();
    exit();
}

// Get the approval status and profile_id (parent_id) from the POST data
$approval_status = isset($_POST['approval_status']) ? $_POST['approval_status'] : '';
$profile_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';

// Validate input
if (empty($approval_status) || empty($profile_id)) {
    echo "Missing approval status or profile ID.";
    exit();
}

try {
    // Step 1: Update the approval status in the user_profile table
    $updateStmt = $pdo->prepare("UPDATE user_profile SET approval_status = :approval_status WHERE profile_id = :profile_id");
    $updateStmt->bindParam(':approval_status', $approval_status);
    $updateStmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $updateStmt->execute();

    // Step 2: Log the activity in the activity_log table
    $action = "Changed approval status to " . $approval_status;
    $logStmt = $pdo->prepare("INSERT INTO activity_log (bhw_id, profile_id, action) VALUES (:bhw_id, :profile_id, :action)");
    $logStmt->bindParam(':bhw_id', $bhw_id, PDO::PARAM_INT);
    $logStmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $logStmt->bindParam(':action', $action, PDO::PARAM_STR); // Corrected to PDO::PARAM_STR
    $logStmt->execute();

    echo "Approval status updated and activity logged successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
