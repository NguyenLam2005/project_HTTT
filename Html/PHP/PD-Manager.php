<?php
include __DIR__ . '/config.php';

$supplier_id = $_POST['supplier'] ?? "";
$product_id = $_POST['name'] ?? "";

$where = [];

if (!empty($supplier_id)) {
    $where[] = "products.supplier_id = " . intval($supplier_id);
}

if (!empty($product_id)) {
    $where[] = "products.id = " . intval($product_id);
}

$whereSQL = "";
if (!empty($where)) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

$sql = "SELECT products.*, categories.name AS category_name, brand.name AS brand_name
        FROM products 
        INNER JOIN categories ON products.category_id = categories.id
        INNER JOIN brand ON products.brand_id = brand.id
        $whereSQL AND products.is_deleted = 0
        ORDER BY products.id ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];

        // Truy vấn số lượng sản phẩm từ bảng inventory
        $sql_inventory = "SELECT COUNT(*) AS quantity
        FROM inventory
        WHERE product_id = ? AND is_deleted = 0";
        $stmt = $conn->prepare($sql_inventory);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $inventory_result = $stmt->get_result();
        $quantity = 0; // Mặc định là 0

        if ($inventory_row = $inventory_result->fetch_assoc()) {
        $quantity = $inventory_row["quantity"];
        }
        $stmt->close();

        $sql = "UPDATE products SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        $stmt->execute();
        $stmt->close();

        echo "<tr data-id='$id'>";
        echo "<td class='img-admin'><img src='" . $row['image'] . "' alt=''></td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['brand_name'] . "</td>";
        echo "<td>" . $row['category_name'] . "</td>";
        echo "<td>" . $quantity . "</td>";
        echo "<td>" . number_format($row['price'], 0, ',', '.') . " VND</td>";
        echo "<td><div class='fix-product'>
              <i class='fa-solid fa-pen-to-square fix-btn-product' data-id='$id'></i>
              <i class='fa-solid fa-trash delete-btn-product' data-id='$id'></i>
            </div></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td style= 'text-align: center;'  colspan='7'>Không có sản phẩm nào</td></tr>";
}
$conn->close();
?>
<div id='delete-overlay-product'>
    <div class='delete-container'>
        <span>Bạn muốn xóa sản phẩm này?</span>
        <button id='delete-acp-product'>Xác nhận</button>
        <button id='cancel-product'>Hủy</button>
    </div>
</div>