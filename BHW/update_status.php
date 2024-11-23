<?php
require_once '../db/db_config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['parent_id']) && isset($data['status'])) {
    $parentId = $data['parent_id'];
    $newStatus = $data['status'];

    try {
        $stmt = $pdo->prepare("UPDATE user_profile SET status = :status WHERE parent_id = :parent_id");
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parentId, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid input."]);
}
?>
