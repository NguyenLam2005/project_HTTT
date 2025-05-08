<?php
include __DIR__ . '/config.php';

$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

// Bắt đầu thẻ select
echo "<select name='product-category' class='form-select' id='product-category' required>";
echo "  <option value=''>-- Chọn thể loại sản phẩm --</option>";

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
} else {
    echo "<option value=''>Không có thể loại nào!</option>";
}

echo "</select>";
?>
