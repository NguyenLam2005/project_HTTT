<?php
include __DIR__ . '/config.php';
header('Content-Type: application/json');

if (isset($_GET['brand_id']) && isset($_GET['supplier_id'])) {
    $brand_id = intval($_GET['brand_id']);
    $supplier_id = intval($_GET['supplier_id']);
    $sql = "SELECT p.id, p.name, p.image, p.price, p.quantity, c.name AS category_name FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.brand_id = ? AND p.supplier_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $brand_id, $supplier_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode(['success' => true, 'products' => $products]);
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu brand_id hoặc supplier_id']);
}
$conn->close(); 