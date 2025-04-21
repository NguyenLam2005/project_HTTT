<?php
include __DIR__ . '/config.php';

header('Content-Type: application/json');
$response = [];

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Phương thức không hợp lệ");
    }

    if (!$conn) {
        throw new Exception("Không thể kết nối database");
    }

    $role_name = trim($_POST['role-name'] ?? '');
    $functions = $_POST['permissions'] ?? []; 

    if (empty($role_name)) {
        throw new Exception("Vui lòng nhập tên quyền!");
    }

    if (strlen($role_name) > 50) {
        throw new Exception("Tên quyền quá dài (tối đa 50 ký tự)");
    }
    
    $function_names = [];
    if (!empty($functions)) {
        $placeholders = implode(',', array_fill(0, count($functions), '?'));
        $sql = "SELECT id, name FROM functions WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
        }

        $stmt->bind_param(str_repeat('i', count($functions)), ...$functions);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi thực thi câu lệnh SQL");
        }

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $function_names[] = $row["name"];
        }
        $stmt->close();
    }

    // Thêm quyền vào bảng permissions
    $stmt = $conn->prepare("INSERT INTO permissions (name) VALUES (?)");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $stmt->bind_param("s", $role_name);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thêm quyền: " . $conn->error);
    }

    $permission_id = $stmt->insert_id;
    $stmt->close();

    // Thêm vào bảng permission_function nếu có chọn chức năng
    if (!empty($functions)) {
        $stmt = $conn->prepare("INSERT INTO permission_function (permission_id, function_id) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
        }

        foreach ($functions as $function_id) {
            $stmt->bind_param("ii", $permission_id, $function_id);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thêm chức năng: " . $conn->error);
            }
        }
        $stmt->close();
    }

    $response = [
        "success" => true,
        "message" => "Thêm quyền thành công!",
        "role" => [
            "id" => $permission_id,
            "name" => $role_name,
            "function_names" => $function_names
        ]
    ];

} catch (Exception $e) {
    $response = [
        "success" => false,
        "message" => $e->getMessage()
    ];
} finally {
    if (isset($conn)) {
        $conn->close();
    }
    echo json_encode($response);
    exit();
}
?>
