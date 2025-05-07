<?php
include __DIR__ . '/config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $permissionId = $_GET['id'];

    // Lấy tên quyền
    $stmt = $conn->prepare("SELECT name FROM permissions WHERE id = ?");
    $stmt->bind_param("i", $permissionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $roleName = $row['name'];

        $stmt = $conn->prepare("SELECT function_id, ActionID FROM permission_function WHERE permission_id = ?");
        $stmt->bind_param("i", $permissionId);
        $stmt->execute();
        $result = $stmt->get_result();

        $functions = [];
        while ($row = $result->fetch_assoc()) {
            // Trả về dạng "functionId_actionId"
            $functions[] = $row['function_id'] . "_" . $row['ActionID'];
        }

        // Lấy danh sách tài khoản thuộc quyền
        $stmt = $conn->prepare("SELECT userName FROM employeeaccount WHERE permission_id = ?");
        $stmt->bind_param("i", $permissionId);
        $stmt->execute();
        $result = $stmt->get_result();

        $userNames = [];
        while ($row = $result->fetch_assoc()) {
            $userNames[] = $row['userName'];
        }

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

