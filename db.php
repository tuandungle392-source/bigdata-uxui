<?php
$host = 'localhost';
$dbname = 'bigdata_uxui';
$username = 'root';
$password = ''; // Mật khẩu mặc định của XAMPP/Laragon thường để trống

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
}
?>