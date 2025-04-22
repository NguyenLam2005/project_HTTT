<!-- Navbar -->
<div class="header__navbar">
    <ul class="header__navbar-list" id = "navbar_list">
    </ul>
</div>

<!-- Bộ lọc + Sản phẩm -->
<div class="content_wrapper">
    <div class="content__infor">
        <h1 id = "infor_product">Sản phẩm</h1>
    </div>
    <div class="content">

        <!-- Nút mở filter (tuỳ ý) -->
        <div class="bnt__filter" id="bnt_filter">
            Bộ lọc <i class="fa-solid fa-filter"></i>
        </div>

        <!-- Filter -->
        <div class="product__filter" id="product_filter"></div>

        <!-- Sắp xếp -->
        <div class="sort__product" id="sort_product">
                    <select name="sap_xep" id="sap_xep">  
                        <option value="">Mặc định</option> 
                        <option value="1">Tên sản phẩm</option>
                        <option value="2">Giá từ thấp lên cao</option>
                        <option value="3">Giá từ cao xuống thấp</option>
                    </select>
        </div>

        <!-- Hiển thị sản phẩm -->
        <div class="product__content">
            <div class="protduct__container">
                <!-- Các sản phẩm sẽ được load bằng Ajax -->
            </div>

            <!-- Phân trang -->
            <div class="product__pagination"></div>
        </div>

        <!-- Chi tiết sản phẩm (ẩn ban đầu) -->
        <div class="product__detail" id = "product_detail"></div>
    </div>
</div>

<!-- Scripts -->
<!-- <script src="./Js/Client/navbar.js"></script> -->
<script src="./Js/Client/product.js?v1.1"></script>

