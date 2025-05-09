function backMainPage(){
    window.location.href = "../../index.php";
}
function paymentPage(){
    const cart = sessionStorage.getItem("cart");
    
    if (cart && (cart === "[]" || cart.trim() === "")) {
        showToast("Bạn cần thêm sản phẩm vào giỏ hàng", false);
        return;
    }
    window.location.href = "../../Layout/Client/payment.php";
}
$(document).ready(function () {
    getCart();
});

function showToast(message, isSuccess, duration = 2000) {
    const toast = document.createElement("div");
    toast.className = "toast";
    toast.textContent = message;
    toast.style.backgroundColor = isSuccess ? "#4caf50" : "#f44336";

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = "fadeout 0.3s ease forwards";
        setTimeout(() => toast.remove(), 300);
    }, duration);

    return duration + 300; 
}
function addToCart(productId, quantity = 1) {
    let currentQuantity = getQuantityFromCartSession(productId);
    console.log(currentQuantity);
    $.ajax({
        url: "http://localhost/project_HTTT/Server/Cart/addToCartById.php",
        type: "POST",
        data: {
            'product_id': productId,
            'quantityCheck': currentQuantity,
            'quantity': quantity
        },
        success: function (response) {
            // alert(response);
            if(response.includes("Bạn cần đăng nhập"))
            {
                showToast("Bạn cần đăng nhập để mua hàng.", false);
            } else if (response === "Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!") {
                showToast('Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!', false);
            }
            else{
                $('.cart-count').text(response);
                getCart();
                showToast("Đã thêm sản phẩm vào giỏ hàng.", true);
            }
        }
    });
    
    
}
function getQuantityFromCartSession(productId) {
    let cart = sessionStorage.getItem("cart");
    if (!cart) {
        return 0; 
    }
    cart = JSON.parse(cart);
    let product = cart.find(item => parseInt(item.id) === parseInt(productId));
    if (product) {
        return product.quantity; 
    } else {
        return 0; 
    }
}
function getCart() {
    $.ajax({
        url: "../../Server/Cart/getCart.php",
        type: "POST",
        dataType: "json",
        success: function (response) {
            if (response.status === "error") {
                
                return;
            }

            let new_cart  = response;
            sessionStorage.setItem("cart", JSON.stringify(new_cart));
            displayItemInCart(new_cart);
            calculateTotal(new_cart);
        }
    })
}

function displayItemInCart(new_cart) {
    let html = '';
    new_cart.forEach(item => {
        html += `
            <div class="PDCart">
                <div id="PDCart1">
                    <img src="${item.image}" width="8%" height="100%" alt="">
                    <div id="PDCart-NP">
                        <div id="PDCart-Name">${item.name}</div>
                        <div id="PDCart-Price">${parseInt(item.price).toLocaleString("vi-VN")}đ</div>
                    </div>
                </div>
                <div id="PDCart2">
                    <div id="quantity-container">
                    <div id="downQuantity" onclick = "decreaseItemInCart(${item.id})"><i class="fa-solid fa-minus"></i></div>
                    <div id="PDCart-Quantity">${item.quantity}</div>
                    <div id="upQuantity" onclick = "addItemToCart(${item.id},${item.quantity})"><i class="fa-solid fa-plus"></i></div>
                </div>
                    <div id="delete-icon" onclick = "removeItemFromCart(${item.id})">
                        <i class="fa-regular fa-trash-can"></i>
                    </div>
                </div>
            </div>
        `;
    })
    document.querySelector('#cart-body #list-PD').innerHTML = html;
}

function calculateTotal(new_cart) {
    let totalAmout = 0;
    new_cart.forEach(item => {
        totalAmout += item.price * item.quantity;
    })
    document.querySelector('#price-total').textContent = totalAmout.toLocaleString("vi-VN") + "đ";
}

function addItemToCart(id, quantityCheck, quantity = 1) {
    $.ajax({
        url: "../../Server/Cart/addToCartById.php",
        type: "POST",
        data: {
            'product_id': id,
            'quantityCheck': quantityCheck,
            'quantity': quantity
        },
        success: function (response) {
            if (response === "Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!") {
                showToast('Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!', false);
            } else {
                getCart(() => {
                    itemQuantityCount();
                });
            }
        }
    });
    console.log("Thêm sản phẩm: " + id);
}

function decreaseItemInCart(id) {
    $.ajax({
        url: "../../Server/Cart/decreaseInCart.php",
        type: "POST",
        data: {
            'product_id': id
        },
        success: function () {
            getCart();
        }
    });
    console.log("Giam san pham: " + id);
}

function removeItemFromCart(id) {
    $.ajax({
        url: "../../Server/Cart/removeFromCart.php",
        type: "POST",
        data: {
            'product_id': id
        },
        success: function () {
            getCart();
        }
    });
    console.log("Xoa san pham: " + id);
}

function addToCart2(productId, quantity = 1, callback = null) {
    let currentQuantity = getQuantityFromCartSession(productId);
    $.ajax({
        url: "http://localhost/project_HTTT/Server/Cart/addToCartById.php",
        type: "POST",
        data: {
            'product_id': productId,
            'quantityCheck': currentQuantity,
            'quantity': quantity
        },
        success: function (response) {
            if (response.includes("Bạn cần đăng nhập")) {
                showToast("Bạn cần đăng nhập để mua hàng.", false);
            } else if (response === "Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!") {
                showToast('Số lượng sản phẩm vượt quá số lượng có sẵn trong kho!', false);
            } else {
                $('.cart-count').text(response);
                getCart();
                showToast("Đang tới trang thanh toán.....", true);
                if (callback) callback(); // Gọi callback khi xong
            }
        }
    });
}

function addToCartAndPaying(productId) {
    addToCart2(productId, 1, () => {
        setTimeout(() => {
            paymentPage(); // Chờ một chút để getCart kịp cập nhật
        }, 1000);
    });
}
