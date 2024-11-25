<?php
require_once '../db/db_config.php';

if (isset($_GET['purok_id'])) {
    $purok_id = $_GET['purok_id'];
    $stmt = $pdo->prepare("SELECT * FROM puroks WHERE purok_id = ?");
    $stmt->execute([$purok_id]);
    $purok = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($purok);
}
?>
