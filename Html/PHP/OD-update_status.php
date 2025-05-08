<?php
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['id'];
    $newStatus = $_POST['status'];

    // Lấy trạng thái hiện tại (tránh cập nhật trùng lặp)
    $stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    if ($currentStatus == 4) {
        echo json_encode(["success" => false, "message" => "Đơn hàng đã giao trước đó!"]);
        exit;
    }

    // Cập nhật trạng thái đơn hàng
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $orderId);

    if ($stmt->execute()) {
        // Nếu trạng thái là "đã giao", cập nhật tồn kho
        if ($newStatus == 4) {
            // Lấy danh sách sản phẩm trong đơn hàng
            $sql = "SELECT product_id, quantity FROM orderdetail WHERE order_id = ?";
            $stmt2 = $conn->prepare($sql);
            $stmt2->bind_param("i", $orderId);
            $stmt2->execute();
            $result = $stmt2->get_result();

            while ($row = $result->fetch_assoc()) {
                $product_id = $row['product_id'];
                $quantity = $row['quantity'];

                // Giảm số lượng sản phẩm trong bảng products
                $update = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
                $update->bind_param("ii", $quantity, $product_id);
                $update->execute();
                $update->close();

                // Xóa số lượng tương ứng trong inventory
                $delete = $conn->prepare("DELETE FROM inventory WHERE product_id = ? ORDER BY id ASC LIMIT ?");
                $delete->bind_param("ii", $product_id, $quantity);
                $delete->execute();
                $delete->close();
            }
            $stmt2->close();
        }

        echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật trạng thái!"]);
    }

    $stmt->close();
    $conn->close();
}
?>
