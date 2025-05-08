<?php
include 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Kiểm tra trạng thái phiếu nhập
    $check_status = $conn->prepare("SELECT status FROM importreceipts WHERE id = ?");
    $check_status->bind_param('s', $id);
    $check_status->execute();
    $result = $check_status->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy phiếu nhập!']);
        exit;
    }
    
    // Chỉ cho phép xóa khi trạng thái là 1 (Chưa duyệt)
    if ($row['status'] != 1) {
        echo json_encode(['success' => false, 'message' => 'Không thể xóa phiếu nhập này!']);
        exit;
    }
    
    // Xóa phiếu nhập
    $delete_query = $conn->prepare("DELETE FROM importreceipts WHERE id = ?");
    $delete_query->bind_param('s', $id);
    
    if ($delete_query->execute()) {
        echo json_encode(['success' => true, 'message' => 'Xóa phiếu nhập thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Xóa phiếu nhập thất bại!']);
    }
    
    $delete_query->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
}

$conn->close();
?> 