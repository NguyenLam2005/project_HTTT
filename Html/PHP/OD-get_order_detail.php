<?php
include 'config.php';

$orderId = $_POST['id'] ?? 0;

$sql = "SELECT 
            p.pd_name,
            od.quantity,
            od.price
        FROM orderdetail od
        JOIN products p ON od.product_id = p.id
        WHERE od.order_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h4 style='text-align:center; color:#3C8DBC;'>Chi tiết đơn hàng $orderId</h4>";
    echo "<i class='fa-solid fa-rotate-left back-orderdetail'></i>";
    echo "<table class='order-detail-table' cellpadding='8' cellspacing='0' style='width: 100%; text-align: center;'>";
    echo "<thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
          </thead>
          <tbody>";
    
    while ($row = $result->fetch_assoc()) {
        $product = htmlspecialchars($row['pd_name']);
        $quantity = $row['quantity'];
        $price = number_format($row['price']) . " đ";
        echo "<tr>
                <td>$product</td>
                <td>$quantity</td>
                <td>$price</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p style='color:red; text-align:center;'>Không tìm thấy chi tiết đơn hàng.</p>";
}
?>
