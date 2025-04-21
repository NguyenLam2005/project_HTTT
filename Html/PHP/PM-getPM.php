<?php
include __DIR__ . '/config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $permissionId = $_GET['id'];

    // Lấy tên quyền từ bảng permissions
    $sql = "SELECT name FROM permissions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $permissionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $roleName = $row['name'];

        // Lấy danh sách chức năng theo id quyền
        $sql = "SELECT function_id FROM permission_function WHERE permission_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $permissionId);
        $stmt->execute();
        $result = $stmt->get_result();

        $functions = [];
        while ($row = $result->fetch_assoc()) {
            $functions[] = $row['function_id']; // Lấy id của các chức năng
        }

        // Lấy danh sách userName từ bảng users có permission_id = id của bảng permission
        $sql = "SELECT userName FROM employeeaccount WHERE permission_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $permissionId);
        $stmt->execute();
        $result = $stmt->get_result();

        $userNames = [];
        while ($row = $result->fetch_assoc()) {
            $userNames[] = $row['userName']; // Lấy danh sách userName
        }

        // Trả về dữ liệu dạng JSON
        echo json_encode([
            "id" => $permissionId,
            "name" => $roleName,
            "functions" => $functions,
            "users" => $userNames
        ]);
    } else {
        echo json_encode(["error" => "Không tìm thấy quyền!"]);
    }
} else {
    echo json_encode(["error" => "ID không hợp lệ!"]);
}
?>
