<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the phpqrcode library
include '../phpqrcode/qrlib.php'; // Update the path to where qrlib.php is located

// Data to encode
$profile_id = $_GET["user_id"];
$data = "http://localhost/seniors_first/ApplicationForm/applicationform.php?profile_id=$profile_id"; // Replace with your data

// Output the QR code directly to the browser
header('Content-Type: image/png');
QRcode::png($data);

?>