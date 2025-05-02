document.addEventListener("DOMContentLoaded", function() {
    getInfoSummary();
    
});
function backPaymentPage(){
    window.location.href = "../../Layout/Client/payment.php";
    localStorage.removeItem('paymentInfo');
    localStorage.removeItem('userAddress');
}
let userName;
let email;
let phone;
let address;
let note;
let paymentDate;
let paymentMethod;
let paymentMethod_id;
let province_id;
let district_id;
let bankName = "";
let cardNumber = "";
let totalAmount = 0;
let orderItems = [];

function getInfoSummary() {
    customer = sessionStorage.getItem("customerInfo");
    customer = JSON.parse(customer);
    userName = customer.name;
    email = customer.email;
    phone = customer.phone;
    address = customer.address;
    if(localStorage.getItem("userAddress"))
    {
        let tmpAddress = JSON.parse(localStorage.getItem("userAddress"));
        address = tmpAddress.address;
    }
    // Lấy từ localStorage
    let paymentInfo = JSON.parse(localStorage.getItem("paymentInfo"));

    if (paymentInfo) {
        note = paymentInfo.ghiChu || "";
        paymentDate = paymentInfo.ngayDat || "";
        paymentMethod_id = paymentInfo.phuongThucThanhToan_id || "";
        paymentMethod = paymentInfo.phuongThucThanhToan;
        bankName = paymentInfo.tenNganHang || "";
        cardNumber = paymentInfo.soThe || "";
    }

    // Hiển thị dữ liệu ra giao diện
    document.querySelector(".invoice-customer-name").textContent = userName;
    document.querySelector(".invoice-customer-phone").textContent = phone;
    document.querySelector(".invoice-customer-address").textContent = address;
    document.querySelector(".invoice-customer-email").textContent = email;
    document.querySelector(".invoice-date").textContent = paymentDate;
    document.querySelector(".invoice-process-note").textContent = "Ghi chú: " + note;
    document.querySelector(".invoice-process-payment").textContent = "Phương thức thanh toán: " + paymentMethod + " " + bankName + " " + cardNumber;

    displayItemInSummary();
}


function displayItemInSummary() {
    let html = '';
    let cart = sessionStorage.getItem("cart");
    cart = JSON.parse(cart);
    console.log(cart);
    cart.forEach(item => {
        totalAmount += item.price * item.quantity;
        html += `
            <div class="invoice-product">
                <span class="invoice-product-img">
                    <img src = "${item.image}" style="width: 30px; object-fit: cover; vertical-align: middle; margin-right:8px">
                </span>
                <span class="invoice-product-name">${item.name}</span>
                <span class="invoice-product-quantity">X${item.quantity}</span>
                <span class="space">........................................................................</span>
                <span class="invoice-product-price">${parseInt(item.price * item.quantity).toLocaleString("vi-VN")}đ</span>
            </div>                                
        `;
    })
    document.querySelector(".invoice-product-list-container").innerHTML = html;
    document.querySelector(".invoice-total-price").innerHTML = totalAmount.toLocaleString('vi-VN') + "đ";
}

function submitPaying() {
    if(!checkToPaying()) return;
    getCartSummary();
    savePaymentIntoDatabase();
}

function checkToPaying()
{
    let selectSure = document.querySelector("#invoice-submit-checkbox")
    if(!selectSure.checked)
    {
        showToast("Vui lòng xác nhận rằng bạn đã đọc và kiểm tra trước khi thanh toán.", false);
        return false;
    }
    return true;
}

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

function getCartSummary() {
    let cart = JSON.parse(sessionStorage.getItem("cart"));

    orderItems = [];
    cart.forEach(item => {
        orderItems.push({
            id: item.id,
            name: item.name,
            quantity: item.quantity,
            price: item.price,
            totalPrice: item.price * item.quantity
        });
    });

    return orderItems;
}
function savePaymentIntoDatabase()
{
    let addressData = JSON.parse(localStorage.getItem("userAddress") || "null");
    let userSession = JSON.parse(sessionStorage.getItem("customerInfo") || "null");

    // Ưu tiên localStorage, fallback sang session
    let addressDetail = addressData?.addressDetail || userSession?.addressDetail;
    console.log(addressDetail);
    let province_id = addressData?.province || userSession?.province_id;
    let district_id = addressData?.district || userSession?.district_id;
    $.ajax({
        type: "POST",
        url: "http://localhost/project_HTTT/Server/Client/savePayment.php",
        data: {
            // address: address,
            note: note,
            paymentDate: paymentDate,
            paymentMethod: paymentMethod_id,
            addressDetail: addressDetail,
            province_id: province_id,
            district_id: district_id,
            bankName: bankName,
            cardNumber: cardNumber,
            totalAmount: totalAmount,
            orderItems: JSON.stringify(orderItems)
        },
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                console.log("Success");
                const timeShown = showToast("Thanh toán thành công.", true);
                setTimeout(() => {
                    window.location.href = "http://localhost/project_HTTT/index.php";
                }, timeShown);
            } else {
                console.log("Fail");
                showToast("Thanh toán thất bại.", false);
            }
            console.log("Server response:", response);
        }
        
    });
}

