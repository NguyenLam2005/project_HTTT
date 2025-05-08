<?php
ob_clean(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '/config.php';
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['employee-id']; 
    $fullName = $_POST['employee-name'];
    $phoneNumber = $_POST['employee-phone'];
    $email = $_POST['employee-email'];
    $address = $_POST['employee-address'];
    $position_id = $_POST['position_id'];
   
    $sql = "UPDATE employees SET position_id = ?, email = ?, fullName = ?, phoneNumber = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss",$position_id, $email, $fullName, $phoneNumber, $address, $id);


    if ($stmt->execute()) {
        $stmt_position = $conn->prepare("SELECT name FROM positions WHERE id = ?");
        $stmt_position->bind_param("i", $position_id);
        $stmt_position->execute();
        $result_position = $stmt_position->get_result();
        $position_name = "";
        if ($row = $result_position->fetch_assoc()) {
            $position_name = $row['name'];
        }

        $stmt_position->close();
            $response = [
            "success" => true,
            "message" => "Cập nhật thông tin thành công!",
            "employee" => [
                "id" => $id,
                "fullName" => $fullName,
                "position_id" => $position_id,
                "address" => $address,
                "phoneNumber" => $phoneNumber,
                "position_name" => $position_name,
                "email" => $email
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
