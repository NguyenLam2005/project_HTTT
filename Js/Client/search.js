$(document).ready(function () {
    // Nút "Nâng cao"
    $(document).on('click','#bnt_show_search_filer', function () {
        $('#search_result').css('display', 'none');
        $('#search_filter').css('display', 'grid').hide().fadeIn(200);
    });


    // Nút "Xem kết quả"
    $(document).on('click','#bnt_search_result', function () {
        $('#search_filter').slideUp(200); // Ẩn filter
        $('#search_result').css('display', 'grid').hide().fadeIn(200);
        search();
    });

    //Nút reset
    $(document).on('click', '#bnt_search_reset', function () {
        $('#search_filter input[type="checkbox"]').prop('checked', false);
        $('#search_filter input[type="number"]').val('');
    });

    // Khi gõ vào ô input, hiện box
    $('#search_infor').on('input', function () {
        const keyword = $(this).val().trim();
        if (keyword !== '') {
            $('.search__box').fadeIn(100); // hoặc .show()
            // Gửi Ajax tìm kiếm nếu cần
        } else {
            $('.search__box').fadeOut(100); // hoặc .hide()
        }
    });

    // Ẩn box khi click ra ngoài
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.header__searchbar').length) {
            $('.search__box').fadeOut(100);
        }
    });


    //Tìm kiếm
    $('#search_infor').on('input', function () {
        search();
    });
    
    function search(){
        let keyword = $('#search_infor').val().trim();
    
        let brands = [];
        let genders = [];
        let categories = [];
        let startPrice = $('#start_price_search').val();
        let endPrice = $('#end_price_search').val();
    
        $('.item_filter_search[type="checkbox"]:checked').each(function () {
            let type = $(this).data('type');
            let value = $(this).val();
    
            if (type === 'brand') brands.push(value);
            if (type === 'gender') genders.push(value);
            if (type === 'category') categories.push(value);
        });
    
        $.ajax({
            url: '/project_HTTT/Server/Client/search.php',
            type: 'POST',
            data: {
                action: 'searchProduct',
                keyword: keyword,
                brands: brands,
                genders: genders,
                categories: categories,
                startPrice: startPrice,
                endPrice: endPrice
            },
            success: function (response) {
                $('#product_search').html(response);
            }
        });
    }

});