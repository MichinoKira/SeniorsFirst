<?php
// Include the database configuration file
require_once '../db/db_config.php';

// Query to fetch data
$stmt = $pdo->query("SELECT bhw.*, bhw_profile.* FROM BHW INNER JOIN bhw_profile ON BHW.bhw_id = bhw_profile.bhw_id");

// Set headers to force download as an Excel file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=bhw_data.csv');

// Open output stream for writing CSV data
$output = fopen('php://output', 'w');

// Write column headers
fputcsv($output, ['ID', 'Cluster', 'Name', 'Contact Number', 'Gender', 'Email Address', 'Address']);

// Fetch rows and write to CSV
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $row['bhw_id'],
        $row['purok_name'],
        $row['name'],
        $row['contact_number'],
        $row['gender'],
        $row['email'],
        $row['zone'] . " Brgy. " . $row['brgy'] . " " . $row['city'] . ", " . $row['province']
    ]);
}

// Close output stream
fclose($output);
?>
