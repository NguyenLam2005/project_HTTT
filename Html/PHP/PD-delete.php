<?php
include __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Lấy số lượng sản phẩm hiện tại
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

        // Xóa sản phẩm
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($image !== "/project_HTTT/Html/img/Default.jpg") {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Không thể xóa sản phẩm khỏi cơ sở dữ liệu."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Không tìm thấy sản phẩm."]);
        $stmt->close();
    }

    $conn->close();
    exit;
}
?>




