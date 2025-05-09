<?php 
session_start();
?>
<header class="header">
    <script>
    const sessionData = <?= json_encode($_SESSION); ?>;
    console.log("Session hiện tại:", sessionData.customer.address);
</script>

<div class="header__container">
    <div class="header__logo">
        <a href="http://localhost/project_HTTT/index.php"><img src="http://localhost/project_HTTT/Asset/img/logo_WatchStore.png"></a>
    </div>

    <div class="header__searchbar">
        <div class="header__searcbar-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" id="search_infor" placeholder="Nhập tên sản phẩm">
        </div>

        <div class="search__box" id="search_box">
                <div class="bnt_show_search_filer" id="bnt_show_search_filer">Nâng cao</div><!-- Khi nhấn nút này thì search__filter display block nhấn lại thì display none và reset input-->
                <div class="search__filter" id="search_filter">
                    <!-- Thương hiệu -->
                    <div class="filter__search__item" id = "brand_property">
                        <!-- <div class="name_thuoc_tinh" >Thương hiệu</div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="brand" value="1" id="t1">
                            <label for="t1">Casio</label>
                        </div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="brand" value="2" id="t2">
                            <label for="t2">Rolex</label>
                        </div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="brand" value="3" id="t3">
                            <label for="t3">Moiden</label>
                        </div> -->
                    </div>

                    <!-- Loại đồng hồ -->
                    <div class="filter__search__item" id = "category_property">
                        <!-- <div class="name_thuoc_tinh">Loại đồng hồ</div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="category" value="1" id="l1">
                            <label for="l1">Cơ</label>
                        </div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="category" value="2" id="l2">
                            <label for="l2">Pin</label>
                        </div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="category" value="3" id="l3">
                            <label for="l3">Tào lao</label>
                        </div> -->
                    </div>

                    <!-- Giới tính -->
                    <div class="filter__search__item" id = "gender_property">
                        <!-- <div class="name_thuoc_tinh" >Giới tính</div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="gender" value="1" id="g1">
                            <label for="g1">Nam</label>
                        </div>
                        <div class="filter__pair">
                            <input type="   checkbox" class="item_filter_search" data-type="gender" value="2" id="g2">
                            <label for="g2">Nữ</label>
                        </div>
                        <div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="gender" value="3" id="g3">
                            <label for="g3">Cặp đôi</label>
                        </div> -->
                    </div>

                    <!-- Mức giá -->
                    <div class="filter__search__item">
                        <div class="name_thuoc_tinh">Mức giá</div>
                        <div class="filter__pair">
                            <div>Từ:</div>
                        </div>
                        <div class="filter__pair">
                            <input type="number" class="item_filter_search" id = "start_price_search">
                        </div>
                        <div class="filter__pair">
                            <div>Đến:</div>
                        </div>
                        <div class="filter__pair">
                            <input type="number" class="item_filter_search" id = "end_price_search">
                        </div>
                    </div>

                    <div class="bnt__search__result" id="bnt_search_result">Xem kết quả</div> <!-- Khi nhấn nút này thì search__filter display none và reset input-->
                    <div class="bnt__search__reset" id = "bnt_search_reset">Reset</div>
                </div>
                
                <div class="search__result" id="search_result">
                    <!-- Kết quả tìm kiếm -->
                    <div id="search_infor" class="search__infor">Kết quả tìm kiếm:</div>
                    <div class="product__search" id="product_search">
                        <!-- hiện danh sách các kết quả ở đây -->
                            <div class="product__search_item" data-id = "1">
                            <div class="search__product__img"><img src="http://localhost/project_HTTT/img/product/K001_403_642_05_01-1.avif" alt=""></div>
                            <div class="search__product__infor" >
                                <h3 class="s-product__name">dsfjgkldjg dslgjldjg sfdfsf sfsfs sffsfs sfs sfsfsfsf sfsfsf sfsfsfffsf sfsfs  sfsfsfs sfsfsf sfsf dgjdlkjl</h3>
                                <h3 class="s-product__price">1.000.000 VND</h3>
                            </div>
                            </div>

                            <div class="product__search_item">
                            <div class="search__product__img"><img src="http://localhost/project_HTTT/img/product/K001_403_642_05_01-1.avif" alt=""></div>
                            <div class="search__product__infor">
                                <h3 class="s-product__name">dsfjgkldjg dslgjldjg sfdfsf sfsfs sffsfs sfs sfsfsfsf sfsfsf sfsfsfffsf sfsfs  sfsfsfs sfsfsf sfsf dgjdlkjl</h3>
                                <h3 class="s-product__price">1.000.000 VND</h3>
                            </div>
                            </div>

                            <div class="product__search_item">
                            <div class="search__product__img"><img src="http://localhost/project_HTTT/img/product/K001_403_642_05_01-1.avif" alt=""></div>
                            <div class="search__product__infor">
                                <h3 class="s-product__name">dsfjgkldjg dslgjldjg sfdfsf sfsfs sffsfs sfs sfsfsfsf sfsfsf sfsfsfffsf sfsfs  sfsfsfs sfsfsf sfsf dgjdlkjl</h3>
                                <h3 class="s-product__price">1.000.000 VND</h3>
                            </div>
                            </div>

                            <div class="product__search_item">
                            <div class="search__product__img"><img src="http://localhost/project_HTTT/img/product/K001_403_642_05_01-1.avif" alt=""></div>
                            <div class="search__product__infor">
                                <h3 class="s-product__name">dsfjgkldjg dslgjldjg sfdfsf sfsfs sffsfs sfs sfsfsfsf sfsfsf sfsfsfffsf sfsfs  sfsfsfs sfsfsf sfsf dgjdlkjl</h3>
                                <h3 class="s-product__price">1.000.000 VND</h3>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
    </div>



    <div class="header__right-box">

        <div class="header__cart" id = "customer_cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Giỏ hàng</span>
        </div>
        <!-- <div class="header__account">
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
        </div> -->

        

        <div class="header__right-box">

            <!-- <div class="header__cart" id = "customer_cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Giỏ hàng</span>
            </div> -->
            <div class="header__account">
                <i class="fa-solid fa-user"></i>
                <?php if (isset($_SESSION['customer'])): ?>
                    <span id="infor__account"><?= htmlspecialchars($_SESSION['customer']['name']) ?></span>
                    <ul class="header__account-dropdown" id="account-dropdown">
                        <li id = "info_customer">Thông tin tài khoản</li>
                        <li id = "order_customer" onclick = "openOrderHistory()">Đơn hàng của tôi</li>
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


            <div class="modal-overlay-history">
                <div class="modal-content">
                    <span class="close-history-modal">&times;</span>
                    <h3 class="order-title">Đơn hàng đã mua</h3>
                    <div class="orders-scroll-area">
                        
                    </div>
                </div>
            </div>
    </div>
    </header>

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


        //Load bộ lọc sản phẩm trên tìm kiếm

        loadBrandSearch();
        loadGenderSearch();
        loadCategorySearch();

        //Load thương hiệu
        function loadBrandSearch(){
            $.ajax({
                url: '/project_HTTT/Server/Client/search.php',
                type: 'POST',
                data:{action: 'loadBrandSearch'},
                success: function(response){
                    $('#brand_property').html(response);
                }
            });
        }

        //Load giới tính
        function loadGenderSearch(){
            $.ajax({
                url: '/project_HTTT/Server/Client/search.php',
                type: 'POST',
                data:{action: 'loadGenderSearch'},
                success: function(response){
                    $('#gender_property').html(response);
                }
            });
        }


        //Load Loại sản phẩm
        function loadCategorySearch(){
            $.ajax({
                url: '/project_HTTT/Server/Client/search.php',
                type: 'POST',
                data:{action: 'loadCategorySearch'},
                success: function(response){
                    $('#category_property').html(response);
                }
            });
        }

    });
loadCustomerInfo();

    function loadCustomerInfo(){
        const sessionData = <?= json_encode($_SESSION); ?>;
        sessionStorage.setItem("customerInfo", JSON.stringify(sessionData.customer));
        let customerData = sessionData.customer;
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
        $.get("http://localhost/project_HTTT/Server/Client/get_provinces.php", function(data) {
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
                $.post("http://localhost/project_HTTT/Server/Client/get_districts.php", { province_id: provinceId }, function(data) {
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

    const closeBtn = document.querySelector('.close-history-modal');
    const modalOverlay = document.querySelector('.modal-overlay-history');

    function openOrderHistory() {
        loadOrders();
    }

    closeBtn.addEventListener('click', function () {
        modalOverlay.style.display = "none";
    });

    function loadOrders() {
        fetch('http://localhost/project_HTTT/Server/Client/get_order_history.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('.orders-scroll-area').innerHTML = data;
                modalOverlay.style.display = "flex";

                document.querySelectorAll('.cancel-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const orderID = btn.getAttribute('data-order-id');
                        if (confirm(`Bạn có chắc muốn hủy đơn hàng #${orderID}?`)) {
                            fetch('http://localhost/project_HTTT/Server/Client/cancelOrder.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'orderID=' + orderID
                            })
                            .then(res => res.text())
                            .then(msg => {
                                alert(msg);
                                loadOrders(); 
                            });
                        }
                    });
                });
            })
            .catch(error => {
                console.error("Lỗi:", error);
            });
    }

</script>
