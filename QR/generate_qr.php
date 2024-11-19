<?php
// Include the PHP QR Code library
require_once 'phpqrcode/qrlib.php'; // Replace with the actual path

// Fetch the user_id from session or database
session_start();
$user_id = $_SESSION['user_id']; // Assuming the user_id is stored in session

// Generate the QR code content
$qr_content = "https://SeniorsFirst/form1.php?user_id=" . $user_id;

// Set file paths
$qr_image_path = 'qrCodes/qr_code_' . $user_id . '.png'; // Where QR code image will be saved
$logo_path = '../Admin/admin_css/img/logo.png'; // Path to your logo file
$final_image_path = 'qrCodes/qr_code_with_logo_' . $user_id . '.png'; // Final image with logo

// Generate the QR code without the logo
QRcode::png($qr_content, $qr_image_path, QR_ECLEVEL_L, 10); // Customize size as needed

// Load the QR code and logo images
$qr_image = imagecreatefrompng($qr_image_path);
$logo_image = imagecreatefrompng($logo_path);

// Get the dimensions of the QR code and logo
$qr_width = imagesx($qr_image);
$qr_height = imagesy($qr_image);
$logo_width = imagesx($logo_image);
$logo_height = imagesy($logo_image);

// Calculate the position to center the logo on the QR code
$logo_x = ($qr_width - $logo_width) / 2;
$logo_y = ($qr_height - $logo_height) / 2;

// Merge the logo onto the QR code
imagecopy($qr_image, $logo_image, $logo_x, $logo_y, 0, 0, $logo_width, $logo_height);

// Save the final image with the logo
imagepng($qr_image, $final_image_path);

// Clean up
imagedestroy($qr_image);
imagedestroy($logo_image);

// Output the final image path (optional)
echo "<img src='" . $final_image_path . "' alt='QR Code with Logo'>";
?>
