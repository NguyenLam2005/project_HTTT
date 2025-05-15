<?php
include __DIR__ . '/config.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['id'];
    $newStatus = $_POST['status'];

    // Lấy trạng thái hiện tại
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

    // Bắt đầu transaction
    $conn->begin_transaction();

    try {
        // Nếu cập nhật sang trạng thái đã giao
        if ($newStatus == 4) {
            $sql = "SELECT product_id, quantity FROM orderdetail WHERE order_id = ?";
            $stmt2 = $conn->prepare($sql);
            $stmt2->bind_param("i", $orderId);
            $stmt2->execute();
            $result = $stmt2->get_result();

            while ($row = $result->fetch_assoc()) {
                $product_id = $row['product_id'];
                $quantity = $row['quantity'];

                // Kiểm tra số lượng serial có đủ không
                $invQuery = $conn->prepare("SELECT id, serialNumber FROM inventory WHERE product_id = ? AND is_deleted = 0 ORDER BY id ASC LIMIT ?");
                $invQuery->bind_param("ii", $product_id, $quantity);
                $invQuery->execute();
                $invResult = $invQuery->get_result();

                if ($invResult->num_rows < $quantity) {
                    $conn->rollback();
                    echo json_encode(["success" => false, "message" => "Không đủ serial number cho sản phẩm ID $product_id!"]);
                    exit;
                }

                // Giảm số lượng sản phẩm
                $update = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
                $update->bind_param("ii", $quantity, $product_id);
                $update->execute();
                $update->close();

                $serials = [];
                while ($invRow = $invResult->fetch_assoc()) {
                    $serials[] = $invRow['serialNumber'];

                    // Đánh dấu đã xóa trong inventory
                    $updateInv = $conn->prepare("UPDATE inventory SET is_deleted = 1 WHERE id = ?");
                    $updateInv->bind_param("i", $invRow['id']);
                    $updateInv->execute();
                    $updateInv->close();
                }
                $invQuery->close();

                // Lấy thời hạn bảo hành
                $warrantyQuery = $conn->prepare("SELECT warrantyPeriod FROM products WHERE id = ?");
                $warrantyQuery->bind_param("i", $product_id);
                $warrantyQuery->execute();
                $warrantyQuery->bind_result($warrantyPeriod);
                $warrantyQuery->fetch();
                $warrantyQuery->close();

                $saleDate = date("Y-m-d");
                $expirationDate = date("Y-m-d", strtotime("+$warrantyPeriod days"));

                // Thêm vào bảng warrantys
                foreach ($serials as $serial) {
                    $insertWarranty = $conn->prepare("INSERT INTO warrantys (product_id, order_id, saleDate, expirationDate, serialNumber) VALUES (?, ?, ?, ?, ?)");
                    $insertWarranty->bind_param("iisss", $product_id, $orderId, $saleDate, $expirationDate, $serial);
                    $insertWarranty->execute();
                    $insertWarranty->close();
                }
            }
            $stmt2->close();
        }

        // Cập nhật trạng thái đơn hàng
        $updateOrder = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $updateOrder->bind_param("ii", $newStatus, $orderId);
        if ($updateOrder->execute()) {
            $conn->commit();
            echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công!"]);
        } else {
            throw new Exception("Lỗi khi cập nhật trạng thái đơn hàng!");
        }
        $updateOrder->close();

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    $conn->close();
}
?>
