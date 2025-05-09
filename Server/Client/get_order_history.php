<?php
session_start();
require_once __DIR__ . '/../database.php';  

$userID = $_SESSION['customer']['id'];

$sql = "SELECT o.*, os.name AS status_name 
        FROM orders o 
        JOIN orderstatus os ON o.status = os.id 
        WHERE o.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$html = '';

if ($result->num_rows === 0) {
    $html = "<p>Chưa tồn tại đơn hàng nào.</p>";
} else {
    while ($order = $result->fetch_assoc()) {
        $orderID = $order['id'];
        $orderDate = $order['orderDate'];
        $status = $order['status_name'];
        $statusID = $order['status']; 

        $sqlDetail = "SELECT od.quantity, od.price, p.name AS product_name, p.image 
                        FROM orderdetail od
                        JOIN products p ON od.product_id = p.id
                        WHERE od.order_id = ?";
        $stmtDetail = $conn->prepare($sqlDetail);
        $stmtDetail->bind_param("i", $orderID);
        $stmtDetail->execute();
        $detailResult = $stmtDetail->get_result();

        $total = 0;

        $html .= "<div class='order-box'>";
        $html .= "<h4>Đơn hàng $orderID</h4>";
        $html .= "<div class='order-date'><strong>Ngày đặt:</strong> $orderDate</div>";
        $html .= "<table class='history-order-table'>
                    <thead>
                        <tr><th>Sản phẩm</th><th>Số lượng</th><th>Thành tiền</th></tr>
                    </thead>
                    <tbody>";

        while ($item = $detailResult->fetch_assoc()) {
            $productName = $item['product_name'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $image = $item['image'];
            $subtotal = $quantity * $price;
            $total += $subtotal;

            $html .= "<tr>
                        <td>
                            <img src='$image' alt='$productName' style='width:50px;height:50px;margin-right:8px;vertical-align:middle;'>
                            $productName
                        </td>
                        <td>$quantity</td>
                        <td>" . number_format($subtotal, 0, ',', '.') . " đ</td>
                      </tr>";
        }

        $html .= "</tbody></table>
                  <div class='order-summary-history'>
                    <p><strong>Tổng tiền:</strong> " . number_format($total, 0, ',', '.') . " đ</p>
                    <p><strong>Trạng thái:</strong> $status ";

        if ($statusID == 1) {
            $html .= " <button class='cancel-btn' data-order-id='$orderID'>Hủy đơn</button>";
        }

        $html .= "</p></div></div>";
    }
}

echo $html;
?>
