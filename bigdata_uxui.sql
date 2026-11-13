-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2026 lúc 06:52 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `bigdata_uxui`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`) VALUES
(1, 'Laptop Dell Inspiron 15', 18500000.00, 'Laptop'),
(2, 'Laptop HP Pavilion x360', 16200000.00, 'Laptop'),
(3, 'Smartphone Xiaomi Redmi Note 13', 5500000.00, 'Smartphone'),
(4, 'Smartphone OPPO Reno11', 10900000.00, 'Smartphone'),
(5, 'Tablet Samsung Galaxy Tab S9', 19800000.00, 'Tablet'),
(6, 'Tai nghe Bluetooth Apple AirPods Pro 2', 5900000.00, 'Headphone'),
(7, 'Đồng hồ thông minh Apple Watch SE', 6800000.00, 'Smartwatch'),
(8, 'Laptop Lenovo ThinkPad E14', 21000000.00, 'Laptop'),
(9, 'Smartphone Google Pixel 8', 17500000.00, 'Smartphone'),
(10, 'Laptop HP Pavilion x000', 2000000.00, 'Laptop');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
