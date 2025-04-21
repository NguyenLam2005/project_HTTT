<?php
include 'config.php';

$orderId = $_POST['id'] ?? 0;
// Lấy thông tin địa chỉ và phương thức thanh toán
$sqlAddress = "SELECT 
                  o.addressDetail,
                  o.paymentMethod_id,
                  prov.name AS province_name,
                  dist.name AS district_name,
                  pmd.bank_name,
                  pmd.card_number,
                  pm.name AS paymentMethod_name
               FROM orders o
               LEFT JOIN provinces prov ON o.province_id = prov.id
               LEFT JOIN districts dist ON o.district_id = dist.id
               LEFT JOIN paymentmethod_detail pmd ON o.id = pmd.order_id
               LEFT JOIN paymentmethod pm ON o.paymentMethod_id = pm.id
               WHERE o.id = ?";

$stmt1 = $conn->prepare($sqlAddress);
$stmt1->bind_param("i", $orderId);
$stmt1->execute();
$result1 = $stmt1->get_result();
if ($row1 = $result1->fetch_assoc()) {
    $province_name = $row1["province_name"];
    $district_name = $row1["district_name"];
    $addressDetail = $row1["addressDetail"];
    $bank_name = $row1["bank_name"];
    $card_number = $row1["card_number"];
    $paymentMethod_name = $row1["paymentMethod_name"];
    $paymentMethod_id = $row1["paymentMethod_id"];
}
$stmt1->close();
// Lấy thông tin sản phẩm
$sqlProducts = "SELECT 
                   p.pd_name,
                   od.quantity,
                   od.price
                FROM orderdetail od
                JOIN products p ON od.product_id = p.id
                WHERE od.order_id = ?";

$stmt2 = $conn->prepare($sqlProducts);
$stmt2->bind_param("i", $orderId);
$stmt2->execute();
$result2 = $stmt2->get_result();


if ($result2->num_rows > 0) {
    echo "<h4 style='text-align:center; color:#3C8DBC; margin-bottom: 20px'>Chi tiết đơn hàng $orderId</h4>";
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
    
    while ($row = $result2->fetch_assoc()) {
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
    echo "<p><strong>Địa chỉ giao hàng:</strong> $addressDetail, $district_name, $province_name</p>";
    echo "<p><strong>Phương thức thanh toán:</strong> $paymentMethod_name</p>";
    if ($paymentMethod_id == 2){
        echo "<p><strong>Tên ngân hàng:</strong> $bank_name</p>";
        echo "<p><strong>Số tài khoản:</strong> $card_number</p>";
    }
} else {
    echo "<p style='color:red; text-align:center;'>Không tìm thấy chi tiết đơn hàng.</p>";
}
?>
