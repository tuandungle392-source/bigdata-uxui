# Đồ án BE1 - Chủ đề 15: UX/UI hiện đại cho dữ liệu lớn

Ứng dụng web minh họa và so sánh 3 mô hình giao diện xử lý dữ liệu lớn: **Phân trang truyền thống**, **Cuộn vô tận**, và **Giao diện Chatbot UI** sử dụng PHP thuần và MySQL.

## Thành viên nhóm
1. [Lê Tuấn Dũng] - MSSV: [24211TT4229]
2. [Nguyễn Tuấn Anh] - MSSV: [24211TT3636]
3. [Nguyễn Quốc Anh Hòa] - MSSV: [24211TT0714]

## Hướng dẫn cài đặt và chạy ứng dụng

### 1. Yêu cầu hệ thống
- Đã cài đặt XAMPP hoặc Laragon (Hỗ trợ PHP 8.x và MySQL).

### 2. Các bước cấu hình Cơ sở dữ liệu
1. Mở trình duyệt truy cập: `http://localhost/phpmyadmin/`
2. Tạo một Cơ sở dữ liệu mới có tên: **`bigdata_uxui`** (chọn Collation: `utf8mb4_unicode_ci`).
3. Tạo bảng `products` với cấu trúc sau hoặc dùng tool nhập liệu thủ công:
   - `id` (INT, Primary Key, Auto Increment)
   - `name` (VARCHAR)
   - `price` (DECIMAL)
   - `category` (VARCHAR)
4. Vào tab **Insert** trong phpMyAdmin để thêm vài sản phẩm mẫu vào bảng.

### 3. Chạy ứng dụng
1. Clone hoặc tải mã nguồn này vào thư mục gốc của server (Ví dụ: `C:\xampp\htdocs\bigdata-uxui`).
2. Mở trình duyệt và truy cập đường dẫn: 
   `http://localhost/bigdata-uxui/index.php`
