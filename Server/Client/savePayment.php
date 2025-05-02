<?php
require_once __DIR__ . '/../database.php';  
session_start();
$user_id = $_SESSION['customer']['id'];
// $address = $_POST['address'];
$note = $_POST['note'];
$paymentDate =  date('Y-m-d');
$paymentMethod = $_POST['paymentMethod'];
$addressDetail = $_POST['addressDetail'];
$province_id = $_POST['province_id'];
$district_id = $_POST['district_id'];
$totalAmount = $_POST['totalAmount'];
$bankName = $_POST['bankName'];
$cardNumber = $_POST['cardNumber'];
$orderItems = json_decode($_POST['orderItems'], true);

$insertQuery = "INSERT INTO orders(customer_id, totalPrice, orderDate, status, notes, paymentMethod_id, province_id, district_id, addressDetail)
                VALUES ('$user_id', '$totalAmount', '$paymentDate', 1, '$note', '$paymentMethod', '$province_id', '$district_id', '$addressDetail')";

if ($conn->query($insertQuery) === TRUE) {
    $order_id = $conn->insert_id; // Lấy ID đơn hàng vừa thêm

    foreach($orderItems as $item){
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $insertDetail = "INSERT INTO orderdetail (order_id, product_id, quantity, price)
                         VALUES ('$order_id', '$product_id', '$quantity', '$price')";

        $conn->query($insertDetail);
    }

    if($paymentMethod == 2){
        $insertDetail = "INSERT INTO paymentmethod_detail (order_id, bank_name, card_number)
                         VALUES ('$order_id', '$bankName', '$cardNumber')";

        $conn->query($insertDetail);
    }

    // Xoá giỏ hàng của người dùng sau khi thanh toán
    $deleteCart = "DELETE FROM carts WHERE customer_id  = '$user_id'";
    $conn->query($deleteCart);

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
