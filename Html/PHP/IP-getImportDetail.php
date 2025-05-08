<?php
include __DIR__ . '/config.php';

// Kiểm tra ID phiếu nhập
if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy ID phiếu nhập']);
    exit();
}

$import_id = $_GET['id'];

// Lấy thông tin phiếu nhập
$sql = "SELECT i.*, e.fullName AS employee_name, s.name AS supplier_name, s.address AS supplier_address
        FROM importreceipts i 
        LEFT JOIN employees e ON i.employee_id = e.id
        LEFT JOIN suppliers s ON i.supplier_id = s.id 
        WHERE i.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $import_id);
$stmt->execute();
$result = $stmt->get_result();
$import = $result->fetch_assoc();

if (!$import) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy phiếu nhập']);
    exit();
}

// Lấy chi tiết các sản phẩm trong phiếu nhập
$sql = "SELECT id.*, p.name as product_name, p.price as product_price
        FROM importreceipt_details id
        LEFT JOIN products p ON id.product_id = p.id
        WHERE id.importreceipt_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $import_id);
$stmt->execute();
$details = $stmt->get_result();

// Tính tổng tiền
$total_amount = 0;
$details_array = [];
while($detail = $details->fetch_assoc()) {
    $detail['subtotal'] = $detail['quantity'] * $detail['unitPrice'];
    $total_amount += $detail['subtotal'];
    $details_array[] = $detail;
}

// Trả về dữ liệu
echo json_encode([
    'success' => true,
    'import' => [
        'id' => $import['id'],
        'employee_id' => $import['employee_id'],
        'employee_name' => $import['employee_name'],
        'importDate' => date('d-m-Y', strtotime($import['importDate'])),
        'status' => $import['status'],
        'supplier_name' => $import['supplier_name'],
        'supplier_address' => $import['supplier_address'],
        'total_amount' => $total_amount
    ],
    'details' => $details_array
]);

$conn->close();
?> 