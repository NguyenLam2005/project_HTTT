<?php
include __DIR__ . '/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM suppliers WHERE id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $supplier = $result->fetch_assoc();
        echo json_encode(["supplier" => $supplier]);
    } else {
        echo json_encode(["error" => "Nhà cung cấp không tồn tại"]);
    }

    $stmt->close();
}

$conn->close();
?>
