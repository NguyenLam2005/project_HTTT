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
                    <li id = "info_customer">Thông tin tài khoản</li>
                    <li id = "order_customer">Đơn hàng của tôi</li>
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

    <div id="overlayInfo">
        <div id="InfoUser-container">
            <div class="InfoUser-Title">
                <h1 class="Title">Thông tin</h1>
                <i id="Back" class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <div class="InfoUser_Detail">
                
            </div>
        </div>
    </div>
    <div class="overlayInfoAddress"></div>
        <div class="overlayAddress">
            <div class="addr-title-wrapper">
                <h2 class="addr-title">Cập nhật địa chỉ</h2>
                <span class="addr-close" onclick="closeAddressPopup()">×</span>
            </div>

            <label for="diaChi" class="addr-label">Địa chỉ cụ thể:</label>
            <input type="text" class="address addr-input" placeholder="Số nhà, tên đường...">

            <label for="tinh" class="addr-label">Tỉnh / Thành phố:</label>
            <select class="province addr-input">
                <option value="">-- Chọn tỉnh / thành phố --</option>
            </select>

            <label for="quan" class="addr-label">Quận / Huyện:</label>
            <select class="district addr-input">
                <option value="">-- Chọn quận / huyện --</option>
            </select>

            <button class="addr-button" onclick="saveAddress()">Lưu địa chỉ</button>
        </div>
</div>
</header>

<script>
    //truy cập đến giỏ hàng
    $(document).ready(function(){
        $('#info_customer').click(function() {
            $('#overlayInfo').toggle();  // Hiển thị/ẩn phần thông tin
        });

    // Đóng thông tin tài khoản khi nhấn nút quay lại
        $('#Back').click(function() {
            $('#overlayInfo').hide();  // Ẩn phần thông tin khi nhấn nút quay lại
        });       

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
                            sessionStorage.removeItem("customerInfo");
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
loadCustomerInfo();

    function loadCustomerInfo(){
        let customerData = JSON.parse(sessionStorage.getItem("customerInfo"));
        let html = `
        <div class="row">
            <label for="account" class="Detail">Tài khoản: </label>
            <span>${customerData.username}</span>
        </div>
        <div class="row">
            <label for="fullname" class="Detail">Họ và tên: </label>
            <span>${customerData.name}</span>
        </div>
        <div class="row">
            <label for="email" class="Detail">Email:</label>
            <span>${customerData.email}</span>
        </div>
        <div class="row">
            <label for="phone" class="Detail">Số điện thoại: </label>
            <span>${customerData.phone}</span>
        </div>
        <div class="row">
            <label for="address" class="Detail titleAddressInfo">Địa chỉ: </label>
            <div class="value-wrapper">
                <span class="content no-margin">${customerData.address}</span>
                <span class="changed no-margin" onclick = "OnUpdateAddress()">Cập nhật</span>
            </div>
        </div>   `
        
        document.querySelector('.InfoUser_Detail').innerHTML = html;
    }

    let e=document.querySelector(".overlayInfoAddress");
    function OnUpdateAddress() {
        e.style.display = "block";
        document.querySelector(".overlayAddress").style.display = "block";
    }
    e.addEventListener("click",function(){
        e.style.display = "none";
        document.querySelector(".overlayAddress").style.display = "none";
        document.querySelector(".overlayAddressPayment").style.display = "none";
    })
    $(document).ready(function() {
        // Load danh sách tỉnh cho tất cả .province
        $.get("../../Server/Client/get_provinces.php", function(data) {
            $(".province").each(function() {
                $(this).append(data);
            });
        });

        // Xử lý khi chọn tỉnh -> load quận/huyện tương ứng
        $(".province").change(function() {
            const provinceSelect = $(this);
            const districtSelect = provinceSelect.closest("div").find(".district");
            const provinceId = provinceSelect.val();

            if (provinceId !== "") {
                $.post("../../Server/Client/get_districts.php", { province_id: provinceId }, function(data) {
                    districtSelect.html(data);
                });
            } else {
                districtSelect.html("<option value=''>-- Chọn quận / huyện --</option>");
            }
        });
    });
    function saveAddress() {
        var dc = $('.overlayAddress .address').val();
        var tinh = $('.overlayAddress .province').val();
        var quan = $('.overlayAddress .district').val();
        if (!dc || !tinh || !quan) {
            showToast("Vui lòng nhập đầy đủ thông tin!", false);
            return;
        }

    
        $.ajax({
            type: "POST",
            url: "./Server/Client/saveAddress.php",  
            data: {
                "addressDetail": dc,
                "province": tinh,
                "district": quan
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === "success") {
                    sessionStorage.setItem("customerInfo", JSON.stringify(res.user));
                    showToast("Đã cập nhật địa chỉ thành công", true);
                    $('.address').val('');
                    $('.province').val('');
                    $('.district').val('');
                    loadCustomerInfo();
                    // setUserInfoPayment();
                    document.querySelector(".overlayAddress").style.display = "none";
                    document.getElementById("overlayInfo").style.display = "block";
                    document.querySelector(".overlayInfoAddress").style.display = "none";
                } else {
                    alert("Lỗi: " + res.message);
                }
            }
        });
    }
    function closeAddressPopup() {
        document.querySelector(".overlayAddress").style.display = "none";
        document.querySelector(".overlayInfoAddress").style.display = "none";
        document.querySelector(".overlayAddressPayment").style.display = "none";
    }
</script>
