<?php
include __DIR__ . '/config.php';
header('Content-Type: application/json');

// Nhận dữ liệu từ AJAX (JSON)
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Không nhận được dữ liệu!']);
    exit;
}

$employee_id = $data['employee_id'] ?? null;
$supplier_id = $data['supplier_id'] ?? null;
$importDate = date('Y-m-d');
$status = 1; 
$productList = $data['products'] ?? [];
$totalAmount = 0;

if (!$employee_id || !$supplier_id || empty($productList)) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin phiếu nhập!']);
    exit;
}

// Bắt đầu transaction (bởi vì truy vấn nhiều bảng)
$conn->begin_transaction();

try {
    // Tính tổng tiền
    foreach ($productList as $item) {
        $totalAmount += floatval($item['import_price']) * intval($item['quantity']);
    }

    // Lấy ID theo kiểu "IP00..."
    $result = $conn->query("SELECT MAX(CAST(SUBSTRING(id, 3) AS UNSIGNED)) as max_id FROM importreceipts");
    $row = $result->fetch_assoc();
    $max_id = $row['max_id'] ?? 0;
    $new_id = 'IP' . str_pad($max_id + 1, 3, '0', STR_PAD_LEFT);

    // Thêm vào bảng importreceipts
    $stmt = $conn->prepare("INSERT INTO importreceipts (id, employee_id, supplier_id, totalAmount, importDate, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssidss', $new_id, $employee_id, $supplier_id, $totalAmount, $importDate, $status);
    
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi thêm phiếu nhập: " . $stmt->error);
    }
    
    $stmt->close();

    // Kiểm tra tất cả product_id có tồn tại không
    $invalid_products = [];
    foreach ($productList as $item) {
        $check_stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
        $check_stmt->bind_param('i', $item['product_id']);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if ($check_result->num_rows == 0) {
            $invalid_products[] = $item['product_id'];
        }
        $check_stmt->close();
    }

    if (!empty($invalid_products)) {
        throw new Exception('Các sản phẩm có ID: ' . implode(', ', $invalid_products) . ' không tồn tại trong hệ thống!');
    }

    // Thêm chi tiết phiếu nhập
    $stmt = $conn->prepare("INSERT INTO importreceipt_details (importreceipt_id, product_id, quantity, unitPrice, serialList) VALUES (?, ?, ?, ?, '')");
    
    foreach ($productList as $item) {
        $stmt->bind_param('siid', $new_id, $item['product_id'], $item['quantity'], $item['import_price']);
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi thêm chi tiết phiếu nhập: " . $stmt->error);
        }
    }
    $stmt->close();

    // Lấy tên nhân viên
    $empName = '';
    $res = $conn->query("SELECT fullName FROM employees WHERE id = '".$employee_id."'");
    if ($row = $res->fetch_assoc()) $empName = $row['fullName'];

    // Commit transaction nếu mọi thứ OK
    $conn->commit();

    // Trả về dữ liệu để render ra bảng
    $response = [
        'success' => true,
        'import' => [
            'id' => $new_id,
            'employee_id' => $employee_id,
            'employee_name' => $empName,
            'importDate' => date('d-m-Y', strtotime($importDate)),
            'status' => $status,
            'totalAmount' => $totalAmount
        ]
    ];
    echo json_encode($response);
// Kiểm lỗi
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close(); 