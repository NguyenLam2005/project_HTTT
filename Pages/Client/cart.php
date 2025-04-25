<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighTech</title>

    <!-- Thư viện -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../Js/Client/cart.js"></script>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../Css/base.css">
    <link rel="stylesheet" href="../../Css/Client/headpages.css">
    <link rel="stylesheet" href="../../Css/Client/navbar.css">
    <link rel="stylesheet" href="../../Css/Client/footer.css">
    <link rel="stylesheet" href="../../Css/Client/loginCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/registerCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/cart.css">
    <link rel="stylesheet" href="../../Css/Client/customerInfo.css">
</head>

<body>

    <?php include '../../Layout/Client/headpage.php'; ?>
    <?php include '../../Layout/Client/header.php'; ?>

    <div id="shopcart-container">
        <div id="cart-header">
            <i class="fa-solid fa-arrow-left" id="back-cart" onclick = "backMainPage()"></i>
            <h1>Giỏ hàng</h1>
        </div>
        <div id="cart-body">
            <p id="Title">Sản phẩm</p>
            <div id="list-PD">
                
            </div>
        </div>
        <div id="cart-footer">
            <div style="display: flex; margin-left: 1.5%;">
                <p>Tạm tính:</p>
                <p id="price-total"></p>
            </div>
            <button id="buy" onclick = "paymentPage()">Mua Ngay</button>
        </div>
    </div>
    <?php include '../../Layout/Client/footer.php'; ?>
</body>
</html>
