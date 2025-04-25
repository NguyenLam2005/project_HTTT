function backMainPage(){
    window.location.href = "../../index.php";
}
function paymentPage(){
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
    $.ajax({
        url: "./Server/Cart/addToCartById.php",
        type: "POST",
        data: {
            'product_id': productId,
            'quantity': quantity,
        },
        success: function (response) {
            if(response.includes("Bạn cần đăng nhập"))
            {
                showToast("Bạn cần đăng nhập để mua hàng.", false);
            }
            else{
                showToast("Đã thêm sản phẩm vào giỏ hàng.", true);
            }
        }
    });
    console.log(productId + ": " + quantity);
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
                    <div id="upQuantity" onclick = "addItemToCart(${item.id},1)"><i class="fa-solid fa-plus"></i></div>
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


function addItemToCart(id) {
    $.ajax({
        url: "../../Server/Cart/addToCartById.php",
        type: "POST",
        data: {
            'product_id': id
        },
        success: function () {
            getCart();
        }
    });
    console.log("Them san pham: " + id);
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


