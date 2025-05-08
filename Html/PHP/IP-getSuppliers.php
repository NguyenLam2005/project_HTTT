<?php
include __DIR__ . '/config.php';
header('Content-Type: application/json');

$sql = "SELECT id, name FROM suppliers ORDER BY name ASC";
$result = $conn->query($sql);
$suppliers = [];
while ($row = $result->fetch_assoc()) {
    $suppliers[] = $row;
}
echo json_encode(['success' => true, 'suppliers' => $suppliers]);
$conn->close(); 