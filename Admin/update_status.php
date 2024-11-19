<?php
require_once '../db/db_config.php';

// Check if data is received via POST
if (isset($_POST['bhw_id']) && isset($_POST['status'])) {
    $bhwId = $_POST['bhw_id'];
    $status = $_POST['status'];

    // Update the BHW status in the database
    $stmt = $pdo->prepare("UPDATE BHW SET status = :status WHERE bhw_id = :bhw_id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':bhw_id', $bhwId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
