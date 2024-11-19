<?php
// Include the database configuration file
require_once '../db/db_config.php';

// Set headers for Excel export
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=seniors_list.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Fetch data from the profile table
$stmt = $pdo->query("SELECT * FROM profile");

// Open output stream for writing CSV content
$output = fopen('php://output', 'w');

// Output column headers
fputcsv($output, ['ID', 'Name', 'Age', 'Gender', 'Date of Birth', 'Address']);

// Output data from each row
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
    $row['profile_id'],
    $row['firstname'] . " " . $row['lastname'],
    $row['age'],
    $row['gender'],
    $row['dob'],
    $row['zone'] . " Brgy. " . $row['brgy'] . " " . $row['city'] . ", " . $row['province']

    ]);
}

// Close output stream
fclose($output);
?>
