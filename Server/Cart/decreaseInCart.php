<?php
    require_once __DIR__ . '/../database.php';  
    session_start();

    $customer_id = $_SESSION['customer']['id'];
    $product_id = $_POST['product_id'];

    $sql = "SELECT * FROM carts WHERE customer_id = $customer_id AND product_id = $product_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_quantity = $row['quantity'];

        if ($current_quantity > 1) {
            $conn->query("UPDATE carts SET quantity = quantity - 1 WHERE customer_id = $customer_id AND product_id = $product_id");
            echo "Giảm số lượng sản phẩm thành công!";
        } else {
            $conn->query("DELETE FROM carts WHERE customer_id = $customer_id AND product_id = $product_id");
            echo "Sản phẩm đã được xóa khỏi giỏ hàng!";
        }
    } else {
        echo "Sản phẩm không có trong giỏ hàng!";
    }
?>