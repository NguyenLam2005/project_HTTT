<?php
include __DIR__ . '/config.php';
header('Content-Type: application/json');

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_id = $_POST['role-id'] ?? '';
    $role_name = $_POST['role-name'] ?? '';
    $functions = $_POST['permissions'] ?? [];

    // Tách lại các function_id và action_id từ mảng permission
    $functions_map = [];
    foreach ($functions as $value) {
        list($function_id, $action_id) = explode('_', $value);
        $functions_map[$function_id][] = $action_id;
    }

    // Validate dữ liệu
    if (empty($role_id) || empty($role_name)) {
        echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ!"]);
        exit();
    }
    if (empty($functions)) {
        echo json_encode(["success" => false, "message" => "Vui lòng chọn ít nhất 1 chức năng!"]);
        exit();
    }

    // Cập nhật tên quyền
    $stmt = $conn->prepare("UPDATE permissions SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $role_name, $role_id);
    if (!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật quyền: " . $stmt->error]);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Xóa các chức năng cũ trước khi thêm mới
    $stmt = $conn->prepare("DELETE FROM permission_function WHERE permission_id = ?");
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $stmt->close();

    // Thêm lại chức năng mới
    $stmt = $conn->prepare("INSERT INTO permission_function (permission_id, function_id, ActionID) VALUES (?, ?, ?)");
    foreach ($functions_map as $function_id => $action_ids) {
        foreach ($action_ids as $action_id) {
            $stmt->bind_param("iis", $role_id, $function_id, $action_id);
            if (!$stmt->execute()) {
                echo json_encode([
                    'success' => false,
                    'message' => "Lỗi khi thêm chức năng: " . $stmt->error
                ]);
                $stmt->close();
                exit();
            }
        }
    }
    $stmt->close();

    // Đếm số chức năng được gán lại
    $count_stmt = $conn->prepare("SELECT COUNT(*) FROM permission_function WHERE permission_id = ?");
    $count_stmt->bind_param("i", $role_id);
    $count_stmt->execute();
    $count_stmt->bind_result($function_count);
    $count_stmt->fetch();
    $count_stmt->close();

    // Trả về phản hồi thành công
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật quyền thành công!',
        'function_count' => $function_count,
        'role' => [
            'id' => $role_id,
            'name' => $role_name,
            'functions_map' => $functions_map
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Yêu cầu không hợp lệ!"]);
}
?>
