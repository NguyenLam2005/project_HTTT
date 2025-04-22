function addToCart(productId, quantity = 1) {
    $.ajax({
        url: "../../Server/Cart/addToCartById.php",
        type: "POST",
        data: {
            'product_id': productId,
            'quantity': quantity,
        },
        success: function (response) {
            // alert(response);
            if(response.includes("Bạn cần đăng nhập"))
            {
                showToast("Bạn cần đăng nhập để mua hàng.", false);
            }
            else{
                $('.cart-count').text(response);
                showToast("Đã thêm sản phẩm vào giỏ hàng.", true);
            }
        }
    });
    console.log(productId + ": " + quantity);
    
}