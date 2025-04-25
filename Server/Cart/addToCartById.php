<?php
    require_once __DIR__ . '/../database.php';  
    session_start();

    if(!isset($_SESSION['customer']))
    {
        echo "Bạn cần đăng nhập";
        exit();
    }

    $customer_id = $_SESSION['customer']['id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    if($quantity == null) $quantity = 1;
    $sql = "SELECT * FROM carts WHERE customer_id = $customer_id AND product_id = $product_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $conn->query("UPDATE carts SET quantity = quantity + $quantity WHERE customer_id = $customer_id AND product_id = $product_id");
    } else {
        $conn->query("INSERT INTO carts (customer_id, product_id, quantity) VALUES ($customer_id,  $product_id, $quantity)");
    }
    
    $total_sql = "SELECT SUM(quantity) AS total FROM carts WHERE customer_id = $customer_id";
    $total_result = $conn->query($total_sql);
    $row = $total_result->fetch_assoc();

    echo $row['total']; // gửi về số lượng để JS hiển thị
?>