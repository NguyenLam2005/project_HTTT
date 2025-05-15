<?php
include __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Lấy số lượng sản phẩm hiện tại và đường dẫn ảnh
    $stmt = $conn->prepare("SELECT quantity, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentquantity, $image);
    
    if ($stmt->fetch()) {
        $stmt->close();

        if ($currentquantity != 0) {
            echo json_encode(["success" => false, "message" => "Không thể xóa sản phẩm còn tồn kho."]);
            $conn->close();
            exit;
        }

        // Kiểm tra xem sản phẩm có tồn tại trong bảng orderdetail không
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM orderdetail WHERE product_id = ?");
        $checkStmt->bind_param("i", $id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Nếu tồn tại, cập nhật is_delete trong cả 2 bảng
            $updateProducts = $conn->prepare("UPDATE products SET is_deleted = 1 WHERE id = ?");
            $updateInventory = $conn->prepare("UPDATE inventory SET is_deleted = 1 WHERE product_id = ?");
            $updateProducts->bind_param("i", $id);
            $updateInventory->bind_param("i", $id);

            $success = $updateProducts->execute() && $updateInventory->execute();
            $updateProducts->close();
            $updateInventory->close();

            if ($success) {
                echo json_encode(["success" => true, "message" => "Đã cập nhật trạng thái xóa."]);
            } else {
                echo json_encode(["success" => false, "message" => "Không thể cập nhật trạng thái xóa."]);
            }
        } else {
            // Nếu không tồn tại trong orderdetail, xóa hoàn toàn
            $deleteProducts = $conn->prepare("DELETE FROM products WHERE id = ?");
            $deleteInventory = $conn->prepare("DELETE FROM inventory WHERE product_id = ?");
            $deleteProducts->bind_param("i", $id);
            $deleteInventory->bind_param("i", $id);

            $success = $deleteProducts->execute() && $deleteInventory->execute();
            $deleteProducts->close();
            $deleteInventory->close();

            if ($success) {
                if ($image !== "/Dolce-bakery/assest/PD-Manager/Default.jpg") {
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . $image;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Không thể xóa sản phẩm khỏi cơ sở dữ liệu."]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Không tìm thấy sản phẩm."]);
        $stmt->close();
    }

    $conn->close();
    exit;
}
?>




