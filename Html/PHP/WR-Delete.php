<?php
include __DIR__ . '/config.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

$today = date("Y-m-d");

// Cập nhật các bảo hành hết hạn hôm nay
$sql = "UPDATE warrantys 
        SET is_deleted = 1 
        WHERE expirationDate <= ? AND is_deleted = 0";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Đã cập nhật các bảo hành hết hạn ngày hôm nay."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi cập nhật: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
