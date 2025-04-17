<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';
header('Content-Type: application/json');
$response = [];

if (isset($_POST['account-id']) && isset($_POST['account-name'])) {
    $accountId = $_POST['account-id'];
    $userName = $_POST['account-name'];
    $password = $_POST['account-pass'];
    $permissionId = $_POST['permission_id']; 
    $permission_name = null;

    // Lấy trạng thái hiện tại và tên nhân viên
    $sql_get_status = "
    SELECT ea.status, e.fullName 
    FROM employeeaccount ea 
    JOIN employees e ON ea.userName = e.id 
    WHERE ea.id = ?
    ";
    $stmt_get_status = $conn->prepare($sql_get_status);
    $stmt_get_status->bind_param("i", $accountId);
    $stmt_get_status->execute();
    $stmt_get_status->bind_result($current_status, $fullName);
    $stmt_get_status->fetch();
    $stmt_get_status->close();
    $status = $current_status;

    // Lấy tên quyền
    $sql_get_permission_name = "SELECT name FROM permissions WHERE id = ?";
    $stmt_get_permission_name = $conn->prepare($sql_get_permission_name);
    $stmt_get_permission_name->bind_param("i", $permissionId);
    $stmt_get_permission_name->execute();
    $stmt_get_permission_name->bind_result($update_permission);
    $stmt_get_permission_name->fetch();
    $stmt_get_permission_name->close();
    $permission_name=$update_permission;

    // Cập nhật thông tin tài khoản
    $hasshedPassword = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE employeeaccount SET userName = ?, password = ?, permission_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $userName, $hasshedPassword, $permissionId, $accountId);

    if ($stmt->execute()) {
        $response = [
            "success" =>true,
            "message" => "Cập nhật tài khoản thành công!",
            "user" => [
                "id" => $accountId,
                "userName" => $userName,
                "password" => $hasshedPassword,
                "permission_name" => $permission_name,
                "fullName" => $fullName,
                "status" => $status
            ]
            ];

    } else {
        $response = ["success" => false, "message" => "Lỗi cập nhật: " . $conn->error];
    }

    $stmt->close();
    $conn->close();

    // Trả về JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
