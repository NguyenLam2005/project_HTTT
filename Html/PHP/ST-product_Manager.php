<?php
    include 'config.php';

    $start_date = $_POST['start_date'] ?? "";
    $end_date = $_POST['end_date'] ?? "";
    $sort = $_POST['sort'] ?? "";
    $limit = intval($_POST['count'] ?? 0);

    // kiểm tra đầu vào
    if (empty($limit)) {
        echo "<tr><td colspan='7' style='text-align: center;'><strong>Vui lòng nhập số sản phẩm muốn thống kế</strong></td></tr>";
        return;
    }
    // lọc theo khoảng thời gian
    $where = [];
    if (!empty($start_date)) {
        $where[] = "DATE(orders.orderDate) >= '" . $conn->real_escape_string($start_date) . "'";
    }
    if (!empty($end_date)) {
        $where[] = "DATE(orders.orderDate) <= '" . $conn->real_escape_string($end_date) . "'";
    }

    // đơn hàng phải có trạng thái "đã giao"
    $where[] = "orders.status = 4"; 

    $whereSQL = "";
    if (!empty($where)) {
        $whereSQL = "WHERE " . implode(" AND ", $where);
    }

    // lấy top 5 sản phẩm bán chạy nhất, danh sách các đơn hàng tương ứng 
    $innerSQL = "
        SELECT 
            products.id AS product_id,
            products.name,
            products.price,
            SUM(orderdetail.quantity) AS totalQuantity,
            SUM(products.price * orderdetail.quantity) AS totalAmount,
            GROUP_CONCAT(CONCAT('Đơn hàng ', orders.id, ': ', orderdetail.quantity , ' sản phẩm ','(',DATE_FORMAT(orders.orderDate, '%d/%m/%Y'),')' ) SEPARATOR '<br>') AS orderLinks
        FROM products
        LEFT JOIN orderdetail ON products.id = orderdetail.product_id
        LEFT JOIN orders ON orderdetail.order_id=orders.id
        $whereSQL
        GROUP BY products.id, products.name, products.price
        ORDER BY totalQuantity DESC
        LIMIT $limit
    ";

    // sắp xếp lại theo yêu cầu người dùng
    $sortSQL = "";
    if ($sort == 1) {
        $sortSQL = "ORDER BY totalQuantity ASC";
    } elseif ($sort == 2) {
        $sortSQL = "ORDER BY totalQuantity DESC";
    }

    // gộp với phần sắp xếp
    $sql = "SELECT * FROM ($innerSQL) AS top_products $sortSQL";

    $temp = 0;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productId = $row['product_id'];
            echo "<tr data-id='$productId'>";
            echo "<td>" . ++$temp . "</td>";
            echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . number_format($row['price']) . "</td>";
            echo "<td>" . number_format($row['totalQuantity']) . "</td>";
            echo "<td>" . number_format($row['totalAmount']) . "</td>";
            echo "<td><div style='max-height: 80px; overflow-y: auto;'>"   . $row['orderLinks'] .   "</div></td>"; 
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='text-align: center;'>Không có sản phẩm nào</td></tr>";
    }
?>

