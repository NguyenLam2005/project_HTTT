<?php
include __DIR__ . '/config.php';
$response = []; // Mảng chứa phản hồi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role_name = $_POST['role-name']??'';
    $functions = $_POST['permissions'];
    $functions_map = [];

    // Tách từng phần tử và lưu vào hash map
    foreach ($functions as $value) {
        list($function_id, $action_id) = explode('_', $value);
    
        // Lưu vào hash map với function_id là key
        $functions_map[$function_id][] = $action_id;
    }

    if (empty($role_name)) {
        $response = ["success" => false, "message" => "Vui lòng nhập tên quyền!"];
        echo json_encode($response);
        exit();
    }
    if (empty($functions)) {
        $response = ["success" => false, "message" => "Vui lòng chọn ít nhất 1 chức năng!"];
        echo json_encode($response);
        exit();
    }

    //check tên quyền trên database
    $check_stmt = $conn->prepare("SELECT id FROM permissions WHERE name = ?");
    $check_stmt->bind_param("s", $role_name);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        // Tên quyền đã tồn tại
        $response = [
            'success' => false,
            'message' => 'Tên quyền đã tồn tại. Vui lòng chọn tên khác.'
        ];
        echo json_encode($response);
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

// Thêm quyền vào bảng permissions nếu nó hợp lệ
    $stmt = $conn->prepare("INSERT INTO permissions (name) VALUES (?)");
    $stmt->bind_param("s", $role_name); // Bind role_name vào câu lệnh SQL
    if (!$stmt->execute()) {
        $response = ["success" => false, "message" => "Lỗi khi thêm quyền: " . $stmt->error];
        echo json_encode($response);
        $stmt->close();
        exit();
    }

    $permission_id = $stmt->insert_id;
    $stmt->close();

    // Thêm vào bảng permission_function nếu có chọn chức năng
    $stmt = $conn->prepare("INSERT INTO permission_function (permission_id, function_id, ActionID) VALUES (?, ?, ?)");
    foreach ($functions_map as $function_id => $action_ids) {
        foreach ($action_ids as $action_id) {
            $stmt->bind_param("iis", $permission_id, $function_id, $action_id);
            if (!$stmt->execute()) {
                $response = [
                    'success' => false,
                    'message' => "Lỗi khi thêm chức năng: " . $stmt->error
                ];
                echo json_encode($response);
                $stmt->close();
                exit();
            }
        }
    }
    $stmt->close();
    $count_stmt = $conn->prepare("SELECT COUNT(*) FROM permission_function WHERE permission_id = ?");
    $count_stmt->bind_param("i", $permission_id);
    $count_stmt->execute();
    $count_stmt->bind_result($function_count); // <-- Gắn kết kết quả vào biến
    $count_stmt->fetch();                      // <-- Lấy kết quả và gán vào biến
    $count_stmt->close();                      // <-- Đóng statement
    // Trả về phản hồi thành công    
    $response = [
        'success' => true,
        'message' => 'Thêm quyền thành công!',
        'role' => [
            'id' => $permission_id,
            'name' => $role_name,
            'function_names' => $functions_map // Trả về danh sách tên chức năng
        ],
        'function_count' => $function_count // Trả về số lượng chức năng
    ];

    echo json_encode($response);
}


?>
