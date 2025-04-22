<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighTech</title>

    <!-- Thư viện -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../../Css/base.css">
    <link rel="stylesheet" href="../../Css/Client/headpages.css">
    <link rel="stylesheet" href="../../Css/Client/navbar.css">
    <link rel="stylesheet" href="../../Css/Client/footer.css">
    <link rel="stylesheet" href="../../Css/Client/loginCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/registerCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/cart.css">
</head>

<body>

    <?php include '../../Layout/Client/headpage.php'; ?>
    <?php include '../../Layout/Client/header.php'; ?>

    <div id="shopcart-container">
        <div id="cart-header">
            <i class="fa-solid fa-arrow-left" id="back-cart"></i>
            <h1>Giỏ hàng</h1>
        </div>
        <div id="cart-body">
            <p id="Title">Sản phẩm</p>
            <div id="list-PD">
                <div class="PDCart">
                    <div id="PDCart1">
                        <img src="${item.image}" width="8%" height="100%" alt="">
                        <div id="PDCart-NP">
                            <div id="PDCart-Name">${item.pd_name}</div>
                            <div id="PDCart-Price">${parseInt(item.price).toLocaleString("vi-VN")}đ</div>
                        </div>
                    </div>
                    <div id="PDCart2">
                        <div id="quantity-container">
                        <div id="downQuantity" onclick = "decreaseItemInCart(${item.id})"><i class="fa-solid fa-minus"></i></div>
                        <div id="PDCart-Quantity">${item.quantity}</div>
                        <div id="upQuantity" onclick = "addItemToCart(${item.id},1)"><i class="fa-solid fa-plus"></i></div>
                    </div>
                        <div id="delete-icon" onclick = "removeItemFromCart(${item.id})">
                            <i class="fa-regular fa-trash-can"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="cart-footer">
            <div style="display: flex; margin-left: 1.5%;">
                <p>Tạm tính:</p>
                <p id="price-total"></p>
            </div>
            <button id="buy">Mua Ngay</button>
        </div>
    </div>
    <?php include '../../Layout/Client/footer.php'; ?>
</body>
</html>
