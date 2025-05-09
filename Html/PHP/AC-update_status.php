<?php
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['id'];
    $newStatus = $_POST['status'];

    $stmt_permission = $conn->prepare("SELECT name FROM permissions p JOIN employeeaccount e ON p.id = e.permission_id WHERE e.id = ?");
    $stmt_permission->bind_param("i", $userId);
     $stmt_permission->execute();
    $result_permission = $stmt_permission->get_result();
    $permission_name = "";
    if ($row = $result_permission->fetch_assoc()) {
        $permission_name = $row['name'];
    }

    if ($permission_name == "Admin") {
        echo json_encode(["success" => false, "message" => "Không thể thay đổi trạng thái của tài khoản Admin!"]);
        exit();
    }

    // Cập nhật trạng thái
    $stmt = $conn->prepare("UPDATE employeeaccount SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $newStatus, $userId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật trạng thái!"]);
    }

    $stmt->close();
    $conn->close();
}
?>
