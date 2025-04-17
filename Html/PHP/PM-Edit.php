<?php
require_once 'config.php';

$response = [];

if (isset($_POST['role-id']) && isset($_POST['role-name'])) {
    $roleId = $_POST['role-id'];
    $roleName = $_POST['role-name'];
    $functions = isset($_POST['permissions']) ? $_POST['permissions'] : [];

    // Cập nhật tên quyền
    $sql = "UPDATE permissions SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $roleName, $roleId);
    if ($stmt->execute()) {
        // Xóa các chức năng cũ
        $sql = "DELETE FROM permission_function WHERE permission_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();

        // Thêm các chức năng mới
        $sql = "INSERT INTO permission_function (permission_id, function_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        foreach ($functions as $functionId) {
            $stmt->bind_param("ii", $roleId, $functionId);
            $stmt->execute();
        }

        $response['success'] = true;
    } else {
        $response['error'] = "Không thể cập nhật quyền!";
    }
} else {
    $response['error'] = "Dữ liệu không hợp lệ!";
}

echo json_encode($response);
?>