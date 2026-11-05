<?php
header('Content-Type: application/json');
include 'db.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Đếm tổng số bản ghi
$totalRows = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalPages = ceil($totalRows / $limit);

// Lấy dữ liệu cho trang hiện tại
$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'page' => $page,
    'limit' => $limit,
    'totalRows' => $totalRows,
    'totalPages' => $totalPages > 0 ? $totalPages : 1,
    'data' => $data
]);
?>