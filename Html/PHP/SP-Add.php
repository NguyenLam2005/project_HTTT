<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/config.php';
header('Content-Type: application/json');
$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['supplier-name'] ?? '');
    $phone = trim($_POST['supplier-phone'] ?? '');
    $address = trim($_POST['supplier-address'] ?? '');

    // Thêm nhân viên vào bảng
    $stmt = $conn->prepare("INSERT INTO suppliers (name, address, phoneNumber) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $phone);

    if ($stmt->execute()) {
        $response = [
            "success" => true,
            "message" => "Thêm nhà cung cấp thành công!",
            "supplier" => [
                "id" => $conn->insert_id,
                "name" => $name,
                "phoneNumber" => $phone,
                "address" => $address,
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
