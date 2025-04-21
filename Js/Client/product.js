// product.js

$(document).ready(function () {
    let lockedSelect = null;

    // Load dữ liệu navbar
    function loadNavbarData() {
        $.ajax({
            url: './Server/Client/load_navbar.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#navbar_list').html(response.html);
            },
            error: function(xhr, status, error) {
                console.log('Lỗi AJAX: ' + error);
            }
        });
    }

    // Load bộ lọc sản phẩm
    function loadfilter() {
        $.ajax({
            url: './Server/Client/load_filter.php',
            method: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('#product_filter').html('<div class="loading">⏳ Đang tải bộ lọc...</div>');
            },
            success: function (response) {
                $('#product_filter').html(response.html);
            }
        });
    }

    // Hàm load sản phẩm theo filter
    function loadProducts(page = 1) {
        $.ajax({
            url: './Server/Client/load_product.php',
            method: 'POST',
            dataType: 'json',
            data: {
                brand: $('#thuong_hieu').val(),
                gender: $('#gioi_tinh').val(),
                category: $('#loai').val(),
                sort: $('#sap_xep').val(),
                gia: $('#muc_gia').val(),
                page: page
            },
            success: function (res) {
                $('.protduct__container').html(res.products);
                $('.product__pagination').html(res.pagination);
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi load sản phẩm:", error);
            }
        });
    }

    // Gọi lần đầu khi trang load
    loadNavbarData();
    loadfilter();
    loadProducts(1);

    // Khi thay đổi các bộ lọc select
    $(document).on('change', '#thuong_hieu, #gioi_tinh, #loai, #muc_gia, #sap_xep', function () {
        loadProducts(1);
    });
    

    // Click icon Hiện/Ẩn bộ lọc
    $('#bnt_filter').on('click', function () {
        $('#product_filter').css("display", "flex");
        // $('#product_filter').slideToggle();
    });

    // Click chọn thương hiệu trong navbar
    $(document).on('click', '.brand-option', function () {
        let brandName = $(this).text();
        let brandId = $(this).data('id');
        $('#infor_product').text(brandName);

        $('#thuong_hieu').val(brandId).prop('disabled', true);
        lockedSelect = '#thuong_hieu';
        $('#gioi_tinh, #loai, #muc_gia').val('').prop('disabled', false);

        history.pushState(null, '', `index.php?brand=${encodeURIComponent(brandName)}`);
        loadProducts();
    });

    // Click chọn giới tính trong navbar
    $(document).on('click', '.gender-item', function () {
        let genderName = $(this).text();
        let genderId = $(this).data('id');
        $('#infor_product').text(genderName);

        $('#gioi_tinh').val(genderId).prop('disabled', true);
        lockedSelect = '#gioi_tinh';
        $('#thuong_hieu, #loai, #muc_gia').val('').prop('disabled', false);

        history.pushState(null, '', `index.php?gender=${encodeURIComponent(genderName)}`);
        loadProducts();
    });

    // Reset khi click Trang chủ
    $(document).on('click', '#home_product', function () {
        $('#gioi_tinh, #thuong_hieu, #loai, #sap_xep').val('').prop('disabled', false);
        history.pushState(null, '', 'index.php');
        $('#infor_product').text("Sản phẩm");
        lockedSelect = null;
        loadProducts();
    });

    // Click phân trang
    $(document).on('click', '.page-num, .prev-page, .next-page', function () {
        let page = parseInt($(this).text());
        if ($(this).hasClass('prev-page')) {
            page = parseInt($('.page-num.active').text()) - 1;
        } else if ($(this).hasClass('next-page')) {
            page = parseInt($('.page-num.active').text()) + 1;
        }
        loadProducts(page);
    });

    // Click vào card sản phẩm → hiện chi tiết
    $(document).on('click', '.product__card', function () {
        let productId = $(this).data('id');
        $.ajax({
            url: './Server/Client/product_detail.php',
            method: 'POST',
            data: { product_id: productId },
            success: function (res) {
                $('.product__detail').html(res).slideDown();
            }
        });
    });

    // Xử lý active cho các mục navbar
    $(document).on('click', '.nav-item', function () {
        $('.nav-item').removeClass('active');
        $(this).addClass('active');
    });

    // Lọc realtime khi thay đổi bất kỳ bộ lọc nào
    $("#thuong_hieu, #gioi_tinh, #loai, #muc_gia, #sap_xep").on("change", function () {
        loadProducts(1); // Gọi lại loadProducts từ trang đầu
    });

});
