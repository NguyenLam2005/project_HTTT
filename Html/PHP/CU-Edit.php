<?php
ob_clean(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/config.php';
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['customer-id']; 
    $fullName = $_POST['customer-name'];
    $phoneNumber = $_POST['customer-phone'];
    $email = $_POST['customer-email'];
    $userName = $_POST['customer-uname'];
    $password = $_POST['customer-pass'];

    // Lấy thông tin hiện tại của khách hàng
    $sql_get_info = "SELECT status, province_id, district_id, addressDetail FROM customers WHERE id = ?";
    $stmt_get_info = $conn->prepare($sql_get_info);
    $stmt_get_info->bind_param("i", $id);
    $stmt_get_info->execute();
    $result = $stmt_get_info->get_result();
    $current_info = $result->fetch_assoc();
    $stmt_get_info->close();

    if (!$current_info) {
        $response = ["success" => false, "message" => "Không tìm thấy khách hàng"];
        echo json_encode($response);
        exit();
    }

    // Cập nhật database
    $sql = "UPDATE customers SET userName = ?, email = ?, fullName = ?, phoneNumber = ?";
    $params = [$userName, $email, $fullName, $phoneNumber];
    $types = "ssss";

    // Chỉ cập nhật mật khẩu nếu có thay đổi
    if (!empty($password)) {
        $sql .= ", password = ?";
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $params[] = $hashedPassword;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // Lấy thông tin cập nhật để trả về
        $sql_get_updated = "SELECT c.*, p.name AS province_name, d.name AS district_name 
                          FROM customers c
                          JOIN provinces p ON c.province_id = p.id
                          JOIN districts d ON c.district_id = d.id
                          WHERE c.id = ?";
        $stmt_get_updated = $conn->prepare($sql_get_updated);
        $stmt_get_updated->bind_param("i", $id);
        $stmt_get_updated->execute();
        $result = $stmt_get_updated->get_result();
        $updated_customer = $result->fetch_assoc();
        $stmt_get_updated->close();

        $response = [
            "success" => true,
            "message" => "Cập nhật thông tin thành công!",
            "customer" => [
                "id" => $updated_customer['id'],
                "fullName" => $updated_customer['fullName'],
                "userName" => $updated_customer['userName'],
                "email" => $updated_customer['email'],
                "phoneNumber" => $updated_customer['phoneNumber'],
                "status" => $updated_customer['status'],
                "address" => $updated_customer['addressDetail'] . ", " . 
                            $updated_customer['district_name'] . ", " . 
                            $updated_customer['province_name']
            ]
        ];
    } else {
        $response = ["success" => false, "message" => "Lỗi khi cập nhật: " . $stmt->error];
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
