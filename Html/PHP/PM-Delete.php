<?php
include __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // luôn nên ép kiểu để tránh lỗi SQL injection



    // Rồi mới xoá trong bảng permissions
    $PM_delete = "DELETE FROM permissions WHERE id = $id";
    if ($conn->query($PM_delete) === TRUE) {
        // Xoá trước trong bảng con
        $conn->query("DELETE FROM permission_function WHERE permission_id = $id");
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]); 
    }

    $conn->close();
    exit;
}


?>