<?php
include 'config.php';
header('Content-Type: application/json');

$import_id = $_POST['import_id'] ?? '';
$status = $_POST['status'] ?? '';

if (!$import_id || !in_array($status, ['1', '2'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
    exit;
}

// Lấy trạng thái hiện tại
$stmt = $conn->prepare("SELECT status FROM importreceipts WHERE id = ?");
$stmt->bind_param('s', $import_id);
$stmt->execute();
$stmt->bind_result($current_status);
$stmt->fetch();
$stmt->close();

if ($current_status == '1' && $status == '2') {
    // Lấy serial lớn nhất đang có trong bảng inventory
    $serial_result = $conn->query("SELECT MAX(CAST(SUBSTRING(serialNumber, 3) AS UNSIGNED)) as max_serial FROM inventory");
    $serial_row = $serial_result->fetch_assoc();
    $max_serial = $serial_row['max_serial'] ?? 0;

    // Lấy danh sách sản phẩm và số lượng trong phiếu nhập
    $sql = "SELECT product_id, quantity FROM importreceipt_details WHERE importreceipt_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $import_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];

        // Ghi từng serialNumber vào bảng inventory
        for ($i = 1; $i <= $quantity; $i++) {
            $current_serial = $max_serial + 1;
            $serialNumber = 'SE' . str_pad($current_serial, 4, '0', STR_PAD_LEFT);

            $insert = $conn->prepare("INSERT INTO inventory (importID, product_id, serialNumber) VALUES (?, ?, ?)");
            $insert->bind_param('sis', $import_id, $product_id, $serialNumber);
            $insert->execute();
            $insert->close();

            $max_serial++; // tăng số seria
        }
    }

    $stmt->close();
}

// Cập nhật trạng thái phiếu nhập
$stmt = $conn->prepare("UPDATE importreceipts SET status = ? WHERE id = ?");
$stmt->bind_param('ss', $status, $import_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại!']);
}

$stmt->close();
$conn->close();
