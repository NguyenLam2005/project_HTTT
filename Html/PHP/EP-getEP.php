<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->bind_param("s", $id); // id là dạng chuỗi: 'NV001'
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        echo json_encode(["employee" => $employee]);
    } else {
        echo json_encode(["error" => "Nhân viên không tồn tại"]);
    }

    $stmt->close();
}

$conn->close();
?>
