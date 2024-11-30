<?php
// Include the database configuration
require_once '../db/db_config.php';

if (isset($_POST['approval_status']) && isset($_POST['parent_id'])) {
    $approval_status = $_POST['approval_status'];  // The new status from the dropdown
    $parent_id = $_POST['parent_id'];  // The parent_id to identify which record to update

    // Debugging: Check what data is received
    error_log("Received status: $approval_status, parent_id: $parent_id");

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE user_profile SET approval_status = :approval_status WHERE parent_id = :parent_id");
        $stmt->bindParam(':approval_status', $approval_status, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Approval status updated successfully!";
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
