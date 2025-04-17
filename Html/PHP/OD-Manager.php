<?php
include 'config.php';

$status = isset($_POST['status']) ? intval($_POST['status']) : 0;

$sql = "SELECT 
            orders.id AS order_id,
            DATE_FORMAT(orders.orderDate, '%d/%m/%Y') AS orderDate,
            orders.totalPrice,
            orders.status,
            customers.fullName,
            customers.id AS customer_id
        FROM orders
        JOIN customers ON orders.customer_id = customers.id";

if ($status != 0) { //Nếu có lọc thì thêm điều kiện
    $sql .= " WHERE orders.status = $status";
}
$sql .= " ORDER BY order_id ASC";


$result = $conn->query($sql);
if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()) {
        $orderId =  $row['order_id'];
        echo "<tr data-id='$orderId'>";
        echo "<td>" . $row['order_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fullName']) . "</td>";
        echo "<td>" . number_format($row['totalPrice']) . " đ</td>";
        echo "<td>" . htmlspecialchars($row['orderDate']) . "</td>";
        echo "<td style='text-align: center; vertical-align: middle;'>
                <i class='fa-solid fa-circle-info order-detail' data-id='$orderId' style='cursor:pointer;'></i>
              </td>";
        echo "<td>
                <select class='order-status' data-id='$orderId' data-ole='{$row['status']}'>
                    <option value='1' " . ($row['status'] == 1 ? "selected" : "") . ">Chờ xử lí</option>
                    <option value='2' " . ($row['status'] == 2 ? "selected" : "") . ">Đã xử lí</option>
                    <option value='3' " . ($row['status'] == 3 ? "selected" : "") . ">Đang giao</option>
                    <option value='4' " . ($row['status'] == 4 ? "selected" : "") . ">Đã giao</option>
                    <option value='5' " . ($row['status'] == 5 ? "selected" : "") . ">Đã hủy</option>
                </select>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8' style='text-align: center;'>Không có đơn hàng nào</td></tr>";
}
?>




