<?php
include 'config.php';

$sql = "SELECT products.*, subcategories.name AS subcategory_name, categories.name AS category_name 
        FROM products 
        INNER JOIN subcategories ON products.subcategory_id = subcategories.id
        INNER JOIN categories ON subcategories.category_id = categories.id
        ORDER BY products.id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        echo "<tr data-id='$id'>";
        echo "<td class='img-admin'><img src='" . $row['image'] . "' alt=''></td>";
        echo "<td>" . $row['pd_name'] . "</td>";
        echo "<td>" . $row['category_name'] . "</td>";
        echo "<td>" . $row['subcategory_name'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . number_format($row['price'], 0, ',', '.') . " VND</td>";
        echo "<td><div class='fix-product'>
              <i class='fa-solid fa-pen-to-square fix-btn-product' data-id='$id'></i>
              <i class='fa-solid fa-trash delete-btn-product' data-id='$id'></i>
            </div></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td style= 'text-align: center;'  colspan='6'>Không có sản phẩm nào</td></tr>";
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