<?php
// Start the session and include the necessary files
session_start();
require_once '../db/db_config.php';

// Check if the user is logged in and is a BHW
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'bhw') {
    echo "Unauthorized access";
    exit();
}

// Get the logged-in BHW username from the session
$bhw_username = $_SESSION['username'];

try {
    // Retrieve the BHW ID from the database
    $stmt = $pdo->prepare("SELECT bhw_id FROM bhw WHERE username = :username");
    $stmt->bindParam(':username', $bhw_username, PDO::PARAM_STR);
    $stmt->execute();
    $bhw_id = $stmt->fetchColumn();

    if (!$bhw_id) {
        echo "BHW ID not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error fetching BHW ID: " . $e->getMessage();
    exit();
}

// Get the status and profile_id from the POST data
$status = $_POST['status'] ?? '';
$profile_id = $_POST['parent_id'] ?? '';

// Validate input
if (empty($status) || empty($profile_id)) {
    echo "Missing status or profile ID.";
    exit();
}

try {
    // Update the status in the user_profile table
    $updateStmt = $pdo->prepare("UPDATE user_profile SET status = :status WHERE profile_id = :profile_id");
    $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
    $updateStmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $updateStmt->execute();

    // Log the activity in the activity_log table
    $action = "Changed status to $status";
    $logStmt = $pdo->prepare("INSERT INTO activity_log (bhw_id, profile_id, action) VALUES (:bhw_id, :profile_id, :action)");
    $logStmt->bindParam(':bhw_id', $bhw_id, PDO::PARAM_INT);
    $logStmt->bindParam(':profile_id', $profile_id, PDO::PARAM_INT);
    $logStmt->bindParam(':action', $action, PDO::PARAM_STR);
    $logStmt->execute();

    echo "Status updated and activity logged successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
