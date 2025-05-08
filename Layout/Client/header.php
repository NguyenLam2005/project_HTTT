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
                            <input type="checkbox" class="item_filter_search" data-type="gender" value="2" id="g2">
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

    
    



</script>
