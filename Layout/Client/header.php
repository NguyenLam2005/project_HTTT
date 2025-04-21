<?php 
session_start();
?>
<header class="header">
<div class="header__container">
    <div class="header__logo">
        <a href="http://localhost/project_HTTT/index.php"><img src="http://localhost/project_HTTT/img/logo.png"></a>
    </div>

    <div class="header__searchbar">
        <div class="header__searcbar-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" id="search_infor" placeholder="Nhập tên sản phẩm">
        </div>
    </div>

    <div class="header__right-box">

        <div class="header__cart" id = "customer_cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Giỏ hàng</span>
        </div>
        <div class="header__account">
            <i class="fa-solid fa-user"></i>
            <?php if (isset($_SESSION['customer'])): ?>
                <span id="infor__account"><?= htmlspecialchars($_SESSION['customer']['name']) ?></span>
                <ul class="header__account-dropdown" id="account-dropdown">
                    <li>Thông tin tài khoản</li>
                    <li>Đơn hàng của tôi</li>
                    <li id = "logout_customer"><a>Đăng xuất</a></li>
                </ul>
                
            <?php else: ?>
                <span id="infor__account">Tài khoản</span>
                <ul class="header__account-dropdown" id="account-dropdown">
                    <li><a href="http://localhost/project_HTTT/Pages/Client/loginCustomer.php">Đăng nhập</a></li>
                    <li><a href="http://localhost/project_HTTT/Pages/Client/registerCustomer.php">Đăng kí</a></li>
                </ul>
            <?php endif; ?>
        </div>

    </div>
</div>
</header>

<script>
    //truy cập đến giỏ hàng
    $(document).ready(function(){
        $('#customer_cart').click(function() {
        <?php if (isset($_SESSION['customer'])): ?>
            window.location.href = 'http://localhost/project_HTTT/Pages/Client/cart.php';
        <?php else: ?>
            alert('Vui lòng đăng nhập để xem giỏ hàng!');
            window.location.href = 'http://localhost/project_HTTT/Pages/Client/loginCustomer.php';
        <?php endif; ?>
        });

        //Đăng xuất
        $('#logout_customer').click(function(){
            if(confirm("Bạn có chắc muốn đăng xuất!")){
                 $.ajax({
                    url: 'http://localhost/project_HTTT/Server/Client/account_customer.php',
                    type: 'POST',
                    data: { action: 'logout_customer' },
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            alert("Thành công!");
                            window.location.href = 'index.php';
                        }
                    },
                    error: function(xhr, status, error){
                        alert("Lỗi hệ thống: " + error);
                    }
                 });
            }
        });

    });
</script>
