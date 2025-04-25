<?php
    require_once __DIR__ . '/../database.php';  
    session_start();
    if(!isset($_SESSION['customer'])){
        echo json_encode(['status' => 'error']);
        exit();
    }

    $customerID = $_SESSION['customer']['id'];
    $sql = "SELECT products.id, products.image, products.name, products.price, carts.quantity 
            FROM carts 
            JOIN products ON carts.product_id = products.id
            WHERE carts.customer_id = $customerID";
    
    $result = $conn->query($sql);
    $cart = [];

    while($row = $result->fetch_assoc()){
        $cart[] = $row;
    }

    echo json_encode($cart);
?>