<?php
include __DIR__ . '/config.php';

$sql = "SELECT w.*, p.name AS product_name 
        FROM warrantys w 
        JOIN products p ON w.product_id = p.id
        WHERE w.is_deleted = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-id='{$row['id']}'>";
        echo "<td>" . htmlspecialchars($row['serialNumber']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['saleDate']))) . "</td>";
        echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['expirationDate']))) . "</td>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align: center;'>Không thông tin bảo hành nào</td></tr>";
}
$conn->close();
?>
