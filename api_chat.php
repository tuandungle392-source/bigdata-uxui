<?php
header('Content-Type: application/json');
include 'db.php';

$input = json_decode(file_get_contents('php://input'), true);
$message = isset($input['message']) ? strtolower(trim($input['message'])) : '';

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

// Xử lý từ khóa tìm kiếm theo danh mục hoặc tên
if (strpos($message, 'laptop') !== false) {
    $sql .= " AND category LIKE ?";
    $params[] = '%Laptop%';
} elseif (strpos($message, 'smartphone') !== false || strpos($message, 'điện thoại') !== false) {
    $sql .= " AND category LIKE ?";
    $params[] = '%Smartphone%';
} elseif (strpos($message, 'tablet') !== false) {
    $sql .= " AND category LIKE ?";
    $params[] = '%Tablet%';
} else {
    // Nếu không khớp danh mục cụ thể, tìm theo từ khóa chung trong tên
    if (!empty($message)) {
        $sql .= " AND name LIKE ?";
        $params[] = '%' . $message . '%';
    }
}

$sql .= " ORDER BY id DESC LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reply = count($products) > 0 
    ? "Tôi tìm thấy các sản phẩm phù hợp với yêu cầu của bạn:" 
    : "Xin lỗi, tôi chưa tìm thấy sản phẩm khớp với yêu cầu của bạn.";

echo json_encode([
    'reply' => $reply,
    'products' => $products
]);
?>