<?php
// Include the database configuration
require_once '../db/db_config.php';

// Check if the approval status and parent_id are received from the form
if (isset($_POST['approval_status']) && isset($_POST['parent_id'])) {
    $approval_status = $_POST['approval_status'];  // The new status from the dropdown
    $parent_id = $_POST['parent_id'];  // The parent_id to identify which record to update

    // Debugging: Log received data
    error_log("Received status: $approval_status, parent_id: $parent_id");

    try {
        // Prepare the SQL statement to update the user profile
        $stmt = $pdo->prepare("UPDATE user_profile SET approval_status = :approval_status WHERE parent_id = :parent_id");
        $stmt->bindParam(':approval_status', $approval_status, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Approval status updated successfully!";

            // Activity logging for user approval status change
            if (isset($_SESSION['username'])) {
                try {
                    // Prepare the SQL statement to insert activity into the log
                    $logStmt = $pdo->prepare("INSERT INTO activity_log (bhw_id, action, timestamp) VALUES (:bhw_id, :action, NOW())");
                    
                    // Bind parameters
                    $logStmt->bindParam(':bhw_id', $_SESSION['username']);  // Assuming username is stored in session
                    $action = "Changed approval status of user to " . $approval_status;  // Define the action text
                    $logStmt->bindParam(':action', $action);
                    
                    // Execute the query
                    $logStmt->execute();
                } catch (PDOException $e) {
                    echo "Error logging activity: " . $e->getMessage();
                    exit();
                }
            } else {
                // Debugging: Log missing session data
                error_log("Session username not set.");
            }

        } else {
            echo "Failed to update approval status.";
        }
    } catch (PDOException $e) {
        // Handle any error during the database operation
        echo "Error: " . $e->getMessage();
    }
} else {
    // Debugging: Log missing data
    error_log("Missing data for update. Status or parent_id not set.");
    echo "Missing data for update.";
}

?>
