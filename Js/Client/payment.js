function GoToPayProcess() {
    getPayDate();
    setUserInfoPayment();
    displayItemReadyPaying();
}
document.addEventListener("DOMContentLoaded", function() {
    GoToPayProcess();
});
function togglePaymentOptions() {
    document.getElementById("atm-options").style.display = "block";
}
function toggleCOD() {
    document.getElementById("atm-options").style.display = "none";
}
function getPayDate() {
    const today = new Date(); // Lấy ngày tháng năm hiện tại
    const day = String(today.getDate()).padStart(2, '0'); // Lấy ngày và đảm bảo có 2 chữ số
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Lấy tháng và đảm bảo có 2 chữ số (tháng bắt đầu từ 0)
    const year = today.getFullYear(); // Lấy năm đầy đủ

    const formattedDate = `${day}/${month}/${year}`;
    document.querySelector(".payment-date").textContent = formattedDate;
    return formattedDate;
}
function setUserInfoPayment() {
    userSession = sessionStorage.getItem("customerInfo");
    userSession = JSON.parse(userSession);
    document.querySelector(".payment-customer-name").textContent = userSession.name;
    document.querySelector(".payment-customer-email").textContent = userSession.email;
    document.querySelector(".payment-customer-phone").textContent = userSession.phone + "";
    document.querySelector(".payment-customer-address").textContent = userSession.address;
}

function displayItemReadyPaying() {
    let totalAmount = 0;
    let html = '';
    let cart = sessionStorage.getItem("cart");
    cart = JSON.parse(cart);
    console.log(cart);
    cart.forEach(item => {
        totalAmount += item.price * item.quantity;
        html += `
            <tr>
                
                <td><img src="${item.image}"style="width: 30px; object-fit: cover; vertical-align: middle; margin-right:8px"></td>
                <td style=" text-align:left; width:100px">${item.name}</td>
                <td style=" text-align:center;">${item.quantity}</td>
                <td style="text-align:right;">${(item.price * item.quantity).toLocaleString('vi-VN')}<sup>đ</sup></td>
            </tr>                                
        `;
    })
    document.querySelector(".payment-table #product-list").innerHTML = html;
    document.querySelector(".payment-table .payment-total-product-price-value").innerHTML = totalAmount.toLocaleString('vi-VN');
    document.querySelector(".payment-table .payment-total-price-value").innerHTML = totalAmount.toLocaleString('vi-VN');
}


function changeAddress()
{
    var dc = $('.overlayAddressPayment .address').val();
    var tinh = $('.overlayAddressPayment .province').val();
    var quan = $('.overlayAddressPayment .district').val();
    if (!dc || !tinh || !quan) {
        showToast("Vui lòng nhập đầy đủ thông tin!", false);
        return;
    }
    $.ajax({
        type: "POST",
        url: "../../Server/Client/getAddressName.php",  
        data: {
            "addressDetail": dc,
            "province": tinh,
            "district": quan
        },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                showToast("Đã thay đổi địa chỉ thành công", true);
                $('.address').val('');
                $('.province').val('');
                $('.district').val('');
                document.querySelector(".overlayAddressPayment").style.display = "none";
                document.querySelector(".overlayInfoAddress").style.display = "none";

                let provinceName = res.provinceName;
                let districtName = res.districtName;
                let address = dc + ", " + districtName + ", " + provinceName;

                document.querySelector(".payment-customer-address").textContent = address;
                localStorage.setItem("userAddress", JSON.stringify({
                    address: address,
                    addressDetail: dc,
                    province: tinh,
                    district: quan
                }));
            } else {
                alert("Lỗi: " + res.message);
            }
        }
    });
    
    
}


function OnUpdateAddressPayment() {
    document.querySelector(".overlayInfoAddress").style.display = "block";
    document.querySelector(".overlayAddressPayment").style.display = "block";
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

function invoicePage(){
    const addressPayment = document.querySelector('.payment-customer-address');
    const cashPayment = document.querySelector('#cash-on-delivery');
    const atmPayment = document.querySelector('#atm-payment');
    if(addressPayment.textContent === 'Chưa có'){
        showToast("Vui lòng cung cấp địa chỉ!", false);
        return;
    }

    if (!cashPayment.checked && !atmPayment.checked) {
        showToast("Vui lòng chọn hình thức thanh toán!", false);
        return;
    }

    const info = getPaymentInfo();
    if (!info) return; 

    window.location.href = "../../Layout/Client/invoice.php";
}


function getPaymentInfo() {
    const ngayDat = document.querySelector('.payment-date').innerText;
    const ghiChu = document.getElementById('note-payment').value;
    const cashPaymentMethod = document.querySelector('#cash-on-delivery');
    const atmPaymentMethod = document.querySelector('#atm-payment');
    let phuongThucThanhToan_id = 1;
    let phuongThucThanhToan = 'Chưa chọn';
    let tenNganHang = '';
    let soThe = '';

    if (cashPaymentMethod.checked) {
        phuongThucThanhToan = 'Thanh toán khi nhận hàng';
    } else if (atmPaymentMethod.checked) {
        phuongThucThanhToan_id = 2;
        phuongThucThanhToan = 'Thanh toán bằng ATM';
        tenNganHang = document.getElementById('bank').value.trim();
        soThe = document.getElementById('card-number').value.trim();

        if (tenNganHang === '') {
            showToast("Vui lòng chọn ngân hàng!", false);
            return null;
        }
        if (soThe === '') { 
            showToast("Vui lòng nhập số tài khoản!", false);
            return null;
        }
    }

    const paymentInfo = {
        ngayDat,
        ghiChu,
        phuongThucThanhToan_id,
        phuongThucThanhToan,
        tenNganHang,
        soThe
    };

    localStorage.setItem('paymentInfo', JSON.stringify(paymentInfo));
    return paymentInfo;
}


function backCart()
{
    window.location.href = "../../Pages/Client/cart.php";
}

