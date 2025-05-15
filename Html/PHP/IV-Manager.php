<?php
include __DIR__ . '/config.php';

$sql = "SELECT i.*, p.id AS product_id , p.name AS product_name, ip.importDate FROM inventory i
        INNER JOIN products p ON i.product_id=p.id
        INNER JOIN importreceipts ip ON i.importID=ip.id
        WHERE i.is_deleted = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-id='{$row['id']}'>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['importID']) . "</td>";
        echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['importDate']))) . "</td>";
        echo "<td>" . htmlspecialchars($row['serialNumber']) . "</td>";
    }
} else {
    echo "<tr><td colspan='6' style='text-align: center;'>Không sản phẩm tồn kho</td></tr>";
}
$conn->close();
?>
