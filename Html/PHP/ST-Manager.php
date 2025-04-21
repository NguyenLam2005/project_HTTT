<?php
    include __DIR__ . '/config.php';

    $start_date = $_POST['start_date'] ?? "";
    $end_date = $_POST['end_date'] ?? "";
    $sort = $_POST['sort'] ?? "";
    $limit = intval($_POST['count'] ?? 0);

    // kiểm tra đầu vào
    if (empty($limit)) {
        echo "<tr><td colspan='5' style='text-align: center;'><strong>Vui lòng nhập số lượng khách hàng muốn thống kế</strong></td></tr>";
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

    // lấy top 5 khách có tổng mua cao nhất, danh sách các đơn hàng tương ứng dưới dạng link
    $innerSQL = "
        SELECT 
            customers.id AS customer_id,
            customers.fullName,
            SUM(orders.totalPrice) AS totalAmount,
            GROUP_CONCAT(
                CONCAT(
                        '<a href=\"#\" class=\"order-info\" data-id=\"', orders.id, '\">#', orders.id, '</a>',
                        ' (', DATE_FORMAT(orders.orderDate, '%d/%m/%Y'), ')'
                )
                SEPARATOR '<br>'
            ) AS orderLinks
        FROM customers
        LEFT JOIN orders ON orders.customer_id = customers.id
        $whereSQL
        GROUP BY customers.id, customers.fullName
        ORDER BY totalAmount DESC
        LIMIT $limit
    ";

    // sắp xếp lại theo yêu cầu người dùng
    $sortSQL = "";
    if ($sort == 1) {
        $sortSQL = "ORDER BY totalAmount ASC";
    } elseif ($sort == 2) {
        $sortSQL = "ORDER BY totalAmount DESC";
    }

    // gộp với phần sắp xếp
    $sql = "SELECT * FROM ($innerSQL) AS top_customers $sortSQL";

    $temp = 0;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cusId = $row['customer_id'];
            echo "<tr data-id='$cusId'>";
            echo "<td>" . ++$temp . "</td>";
            echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fullName']) . "</td>";
            echo "<td>" . number_format($row['totalAmount']) . " đ</td>";
            echo "<td>"   . $row['orderLinks'] .   "</td>"; 
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='text-align: center;'>Không có khách hàng nào</td></tr>";
    }
?>

