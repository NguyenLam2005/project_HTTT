<?php
include __DIR__ . '/config.php';
header('Content-Type: application/json');

if (isset($_GET['supplier_id'])) {
    $supplier_id = intval($_GET['supplier_id']);
    $sql = "SELECT DISTINCT b.id, b.name FROM brand b
            JOIN products p ON b.id = p.brand_id
            JOIN suppliers s ON s.id = p.supplier_id
            WHERE s.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $supplier_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $brand = [];
    while ($row = $result->fetch_assoc()) {
        $brand[] = $row;
    }
    echo json_encode(['success' => true, 'brand' => $brand]);
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu supplier_id']);
}
$conn->close(); 