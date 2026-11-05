<?php
header('Content-Type: application/json');
include 'db.php';

$lastId = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;
$limit = 10;

if ($lastId == 0) {
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
} else {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id < :lastId ORDER BY id DESC LIMIT :limit");
    $stmt->bindValue(':lastId', $lastId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['data' => $data]);
?>