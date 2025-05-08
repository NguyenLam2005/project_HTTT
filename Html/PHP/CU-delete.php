<?php
    include __DIR__ . '/config.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])){
        $id = $_POST['id'];
        $CU_delete = "DELETE FROM customers WHERE id = ?";
        $stmt = $conn->prepare($CU_delete);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Xóa khách hàng thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi khi xóa khách hàng: " . $stmt->error]); 
        }
        $stmt->close();
        $conn->close();
        exit;
    }
?>