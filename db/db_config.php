<?php
// db_config.php

$host = 'localhost';
$dbname = 'seniors_first';
$username = 'root';      // Replace with your database username
$password = '';          // Replace with your database password


try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set the default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Set the PDO emulation mode for prepared statements
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch (PDOException $e) {
    // Handle the error gracefully
    error_log("Database connection error: " . $e->getMessage());
    die("Error: Could not connect to the database.");
}
?>
