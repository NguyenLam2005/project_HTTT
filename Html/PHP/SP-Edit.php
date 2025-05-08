<?php
ob_clean(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/config.php';
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['supplier-id']; 
    $name = $_POST['supplier-name'];
    $phoneNumber = $_POST['supplier-phone'];
    $address = $_POST['supplier-address'];
   
    $sql = "UPDATE suppliers SET name = ?, phoneNumber = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $phoneNumber, $address, $id);

    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Cập nhật thành công!',
            'supplier' => [
                'id' => $id,
                'name' => $name,
                'address' => $address,
                'phoneNumber' => $phoneNumber
            ]
        ];
    }else {
        $response = [
            "success" => false, 
            "message" => "Lỗi cập nhật: " . $stmt->error
        ];
    }

    $stmt->close();
    $conn->close();
    
    echo json_encode($response);
    exit();
}
?>
