<?php
$host = 'localhost';
$user = 'root'; // Tên tài khoản mặc định của XAMPP
$password = ''; // Mật khẩu mặc định là rỗng
$dbname = 'db_watch';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>