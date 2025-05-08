<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/config.php';
header('Content-Type: application/json');
$response = []; // Mảng chứa phản hồi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['account-name'] ?? '');
    $password = trim($_POST['account-pass'] ?? '');
    $permission_id = $_POST['permission_id'] ?? null;
    $permission_name = null;
    $status = 1;

    //Lấy tên quyền
    $sql = "SELECT name FROM permissions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $permission_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $permission_name = $row["name"];
    }

    $stmt->close();

    // Lấy tên nhân viên
    $sql = "SELECT fullName FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $position_name = "";
    if ($row = $result->fetch_assoc()) {
        $fullName = $row["fullName"];
    }
    $stmt->close();
   

    

    // Thêm tài khoản vào bảng
    $hasshedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO employeeaccount (userName, password, permission_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $hasshedPassword, $permission_id);

    if ($stmt->execute()) {
        $response = [
            "success" => true,
            "message" => "Thêm tài khoản thành công!",
            "account" => [
                "id" => $conn->insert_id,
                "username" => $username,
                "hasshedPassword" => $hasshedPassword,
                "permission_id" => $permission_id,
                "permission_name" => $permission_name,
                "fullName" => $fullName,
                "status" => $status
            ]
        ];
    } else {
        $response = ["success" => false, "message" => "Lỗi: " . $conn->error];
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
