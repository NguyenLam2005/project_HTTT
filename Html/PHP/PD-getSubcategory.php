<?php
include 'config.php';

if (isset($_POST['category_id'])) {
    $categoryId = intval($_POST['category_id']);
    $sql = "SELECT id, name FROM subcategories WHERE category_id = $categoryId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<option value=''>-- Chọn phân loại sản phẩm --</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
    } else {
        echo "<option value=''>Không có phân loại</option>";
    }
} else {
    echo "<option value=''>Thiếu category_id</option>";
}
?>
