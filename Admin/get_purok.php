<?php
require_once '../db/db_config.php';

if (isset($_GET['purok_id'])) {
    $purok_id = $_GET['purok_id'];

    // Prepare and execute the query
    $stmt = $pdo->prepare("SELECT * FROM puroks WHERE purok_id = ?");
    $stmt->execute([$purok_id]);

    // Fetch the record
    $purok = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the result as JSON
    echo json_encode($purok);
} else {
    echo json_encode(["error" => "Purok ID not provided."]);
}
?>
