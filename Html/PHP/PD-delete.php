<?php
    include __DIR__ . '/config.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
        $id = $_POST['id'];
        $drop_IMGPD = ("SELECT image FROM products where id = ?");
        $stmt = $conn->prepare($drop_IMGPD);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . $row['image'];
            $PD_delete = ("DELETE FROM products where id = ?");
            $stmt = $conn->prepare($PD_delete);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                if ($row['image'] != "/project_HTTT/Html/img/Default.jpg") {
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }            
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Lỗi khi xóa sản phẩm"]); 
            }
        } else {
            echo json_encode(["success" => false, "message" => "Không tìm thấy sản phẩm"]); 
        }
        $stmt->close();
        $conn->close();
        exit;
    }
?>