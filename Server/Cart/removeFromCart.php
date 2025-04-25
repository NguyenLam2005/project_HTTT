<?php
    require_once __DIR__ . '/../database.php';  
    session_start();

    $customer_id = $_SESSION['customer']['id'];
    $product_id = $_POST['product_id'];

    $sql = "SELECT * FROM carts WHERE customer_id = $customer_id AND product_id = $product_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $conn->query("DELETE FROM carts WHERE customer_id = $customer_id AND product_id = $product_id");
    } 

    echo "Sản phẩm đã được xóa khỏi giỏ hàng!";
?>