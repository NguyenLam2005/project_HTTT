<?php
include __DIR__ . '/config.php';
header('Content-Type: application/json');

if (isset($_GET['supplier_id'])) {
    $supplier_id = intval($_GET['supplier_id']);
    $sql = "SELECT DISTINCT c.id, c.name FROM categories c
            JOIN products p ON c.id = p.category_id
            WHERE p.supplier_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $supplier_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode(['success' => true, 'categories' => $categories]);
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu supplier_id']);
}
$conn->close(); 