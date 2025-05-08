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
    $quantityCheck = $_POST['quantityCheck'];
    $quantity = $_POST['quantity'];
    $product_sql = "SELECT quantity FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_sql);
    $product_row = $product_result->fetch_assoc();

    // Nếu không tìm thấy sản phẩm hoặc số lượng yêu cầu vượt quá kho
    if (!$product_row || $product_row['quantity'] <= $quantityCheck) {
        echo "Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!";
        exit();
    }

    // Kiểm tra giỏ hàng của người dùng
    $sql = "SELECT * FROM carts WHERE customer_id = $customer_id AND product_id = $product_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $conn->query("UPDATE carts SET quantity = quantity + $quantity WHERE customer_id = $customer_id AND product_id = $product_id");
    } else {
        $conn->query("INSERT INTO carts (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $quantity)");
    }

    // Tính lại tổng số lượng trong giỏ hàng
    $total_sql = "SELECT SUM(quantity) AS total FROM carts WHERE customer_id = $customer_id";
    $total_result = $conn->query($total_sql);
    $row = $total_result->fetch_assoc();

    echo $row['total']; // gửi về số lượng để JS hiển thị
?>

