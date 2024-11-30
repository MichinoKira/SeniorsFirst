<?php 
// Include the database configuration
require_once '../db/db_config.php';


if (isset($_POST['status']) && isset($_POST['parent_id'])) {
    $status = $_POST['status'];  // The new status from the dropdown
    $parent_id = $_POST['parent_id'];  // The parent_id to identify which record to update

    // Debugging: Check what data is received
    error_log("Received status: $status, parent_id: $parent_id");

    try {
        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE user_profile SET status = :status WHERE parent_id = :parent_id");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Status updated successfully!";
        } else {
            echo "Failed to update status.";
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