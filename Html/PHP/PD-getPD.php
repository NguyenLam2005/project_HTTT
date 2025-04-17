<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "
        SELECT 
            products.*, 
            subcategories.name AS subcategory_name, 
            subcategories.id AS subcategory_id, 
            categories.name AS category_name,
            categories.id AS category_id
        FROM products
        INNER JOIN subcategories ON products.subcategory_id = subcategories.id
        INNER JOIN categories ON subcategories.category_id = categories.id
        WHERE products.id = $id
    ";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(["error" => "Sản phẩm không tồn tại"]);
    }
}

mysqli_close($conn);
?>
