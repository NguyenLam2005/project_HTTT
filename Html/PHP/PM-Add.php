<?php
require_once 'config.php';

$response = []; // Mảng chứa phản hồi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_name = trim($_POST['role-name'] ?? '');
    $functions = $_POST['permissions'] ?? []; 

    if (empty($role_name)) {
        $response = ["success" => false, "message" => "Vui lòng nhập tên quyền!"];
        echo json_encode($response);
        exit();
    }
    
    
    $function_names = []; //mảng chứa danh sách tên chức năng
    if (!empty($functions)) {
        $placeholders = implode(',', array_fill(0, count($functions), '?'));
        $sql = "SELECT name FROM functions WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param(str_repeat('i', count($functions)), ...$functions);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $function_names[] = $row["name"];
        }

        $stmt->close();
    }

    // Thêm quyền vào bảng permissions
    $stmt = $conn->prepare("INSERT INTO permissions (name) VALUES (?)");
    $stmt->bind_param("s", $role_name);

    if ($stmt->execute()) {
        $permission_id = $stmt->insert_id;
        $stmt->close();

        // Thêm vào bảng permission_function nếu có chọn chức năng
        if (!empty($functions)) {
            $stmt = $conn->prepare("INSERT INTO permission_function (permission_id, function_id) VALUES (?, ?)");
            foreach ($functions as $function_id) {
                $stmt->bind_param("ii", $permission_id, $function_id);
                $stmt->execute();
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
    } else {
        $response = ["success" => false, "message" => "Lỗi: " . $conn->error];
    }

    // Đóng kết nối và trả kết quả JSON
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
