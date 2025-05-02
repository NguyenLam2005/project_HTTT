<?php
session_start();
require_once __DIR__ . '/../database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderID'])) {
    $orderID = intval($_POST['orderID']);
    $userID = $_SESSION['customer']['id'];

    $sql = "UPDATE orders SET status = 5 WHERE id = ? AND customer_id = ? AND status = 1"; // 5 = 'Đã hủy'
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $orderID, $userID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Đơn hàng đã được hủy.";
    } else {
        echo "Không thể hủy đơn hàng này.";
    }
}
?>
