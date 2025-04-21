<?php
include __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerId = $_POST['id'];
    $newStatus = $_POST['status'];

    // Cập nhật trạng thái đơn hàng
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $customerId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật trạng thái!"]);
    }

    $stmt->close();
    $conn->close();
}
?>
