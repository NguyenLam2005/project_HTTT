<!-- 
include __DIR__ . '/config.php';

$sql = "SELECT 
            COUNT(DISTINCT o.id) AS total_orders,
            SUM(od.quantity * od.price) AS total_revenue,
            SUM(od.quantity * latest_import.unitPrice) AS total_cost,
            SUM(od.quantity * od.price) - SUM(od.quantity * latest_import.unitPrice) AS total_profit
        FROM orders o
        JOIN orderdetail od ON o.id = od.order_id
        JOIN (
            SELECT ird.product_id, ird.unitPrice
            FROM importreceipt_detail ird
            JOIN (
                SELECT product_id, MAX(ir.importDate) AS latest_date
                FROM importreceipt_details ird2
                JOIN importreceipts ir ON ir.id = ird2.importreceipt_id
                GROUP BY product_id
            ) latest ON latest.product_id = ird.product_id
            JOIN importreceipts ir ON ir.id = ird.importreceipt_id AND ir.importDate = latest.latest_date
        ) AS latest_import ON latest_import.product_id = od.product_id
        WHERE o.status = 4";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode([
    "totalOrders" => $data['total_orders'],
    "totalRevenue" => number_format($data['total_revenue'], 0, ',', '.') . " VND",
    "totalCost" => number_format($data['total_cost'], 0, ',', '.') . " VND",
    "totalProfit" => number_format($data['total_profit'], 0, ',', '.') . " VND"
]);

$conn->close();
 -->
