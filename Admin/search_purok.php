<?php
require_once '../db/db_config.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$query = $data['query'] ?? '';

// Check if the query is empty
if (empty($query)) {
    // Fetch all records if the search query is empty
    $stmt = $pdo->prepare("SELECT * FROM puroks");
} else {
    // Prepare the statement to search for matching records
    $query = "%$query%"; // Prepare for LIKE clause
    $stmt = $pdo->prepare("SELECT * FROM puroks WHERE purok_name LIKE ? OR contact_person LIKE ?");
    $stmt->execute([$query, $query]);
}

// Execute the query and fetch results
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>
