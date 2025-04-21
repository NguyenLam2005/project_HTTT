<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/config.php'; // Kết nối database
header('Content-Type: application/json');
$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['employee-name'] ?? '');
    $email = trim($_POST['employee-email'] ?? '');
    $phoneNumber = trim($_POST['employee-phone'] ?? '');
    $address = trim($_POST['employee-address'] ?? '');
    $position_id = $_POST['position_id'] ?? null;

    // Lấy tên chức vụ
    $sql = "SELECT name FROM positions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $position_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $position_name = "";
    if ($row = $result->fetch_assoc()) {
        $position_name = $row["name"];
    }
    $stmt->close();

    // Kiểm tra email đã tồn tại chưa
    $stmt = $conn->prepare("SELECT id FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Email đã tồn tại!"]);
        exit();
    }
    $stmt->close();

    // Thêm nhân viên vào bảng
    $stmt = $conn->prepare("INSERT INTO employees (fullName, email, address, phoneNumber, position_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $fullName, $email, $address, $phoneNumber, $position_id);

    if ($stmt->execute()) {
        // Lấy lại id để hiển thị ra
        $stmt = $conn->prepare("SELECT id FROM employees WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = "";
        if ($row = $result->fetch_assoc()) {
            $id = $row['id'];
        }
    
        $response = [
            "success" => true,
            "message" => "Thêm tài khoản thành công!",
            "employee" => [
                "id" => $id,
                "fullName" => $fullName,
                "email" => $email,
                "phoneNumber" => $phoneNumber,
                "address" => $address,
                "position_name" => $position_name
            ]
        ];
    } else {
        $response = ["success" => false, "message" => "Lỗi: " . $stmt->error];
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
