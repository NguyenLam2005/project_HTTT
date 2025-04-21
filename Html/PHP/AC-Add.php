<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php'; // Kết nối database
header('Content-Type: application/json');
$response = []; // Mảng chứa phản hồi

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Phương thức không hợp lệ");
    }

    if (!$conn) {
        throw new Exception("Không thể kết nối database");
    }

    $username = trim($_POST['account-name'] ?? '');
    $password = trim($_POST['account-pass'] ?? '');
    $permission_id = $_POST['permission_id'] ?? null;

    // Validation
    if (empty($username)) {
        throw new Exception("Vui lòng nhập tên đăng nhập!");
    }

    if (empty($password)) {
        throw new Exception("Vui lòng nhập mật khẩu!");
    }

    if (strlen($username) > 50) {
        throw new Exception("Tên đăng nhập quá dài (tối đa 50 ký tự)");
    }

    if (strlen($password) < 6) {
        throw new Exception("Mật khẩu phải có ít nhất 6 ký tự");
    }

    if (!$permission_id) {
        throw new Exception("Vui lòng chọn quyền!");
    }

    // Kiểm tra username đã tồn tại chưa
    $stmt = $conn->prepare("SELECT id FROM employeeaccount WHERE userName = ?");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh SQL");
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        throw new Exception("Tên đăng nhập đã tồn tại!");
    }
    $stmt->close();

    //Lấy tên quyền
    $stmt = $conn->prepare("SELECT name FROM permissions WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $stmt->bind_param("i", $permission_id);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh SQL");
    }

    $result = $stmt->get_result();
    $permission_name = null;
    if ($row = $result->fetch_assoc()) {
        $permission_name = $row["name"];
    } else {
        throw new Exception("Quyền không tồn tại!");
    }
    $stmt->close();

    // Lấy tên nhân viên
    $stmt = $conn->prepare("SELECT fullName FROM employees WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh SQL");
    }

    $result = $stmt->get_result();
    $fullName = "";
    if ($row = $result->fetch_assoc()) {
        $fullName = $row["fullName"];
    } else {
        throw new Exception("Nhân viên không tồn tại!");
    }
    $stmt->close();

    // Thêm tài khoản vào bảng
    $hasshedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO employeeaccount (userName, password, permission_id) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $stmt->bind_param("ssi", $username, $hasshedPassword, $permission_id);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thêm tài khoản: " . $conn->error);
    }

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
            "status" => 1
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
