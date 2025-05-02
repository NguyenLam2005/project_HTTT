<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighTech</title>

    <!-- Thư viện -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../Js/Client/invoice.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../../Css/base.css">
    <link rel="stylesheet" href="../../Css/Client/invoice.css">
    <link rel="stylesheet" href="../../Css/Client/payment.css">
    <link rel="stylesheet" href="../../Css/Client/headpages.css">
    <link rel="stylesheet" href="../../Css/Client/navbar.css">
    <link rel="stylesheet" href="../../Css/Client/footer.css">
    <link rel="stylesheet" href="../../Css/Client/loginCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/registerCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/cart.css">
    <link rel="stylesheet" href="../../Css/Client/customerInfo.css">
</head>

<body>

    <?php include '../../Layout/Client/headpage.php'; ?>
    <?php include '../../Layout/Client/header.php'; ?>
        <div id="overlay-invoice">
            <div id="invoice-container">
                <div class="invoice-header">
                    <button id="close-invoice" onclick = "backPaymentPage()">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại
                    </button>
                    <h3 class="header">HÓA ĐƠN THANH TOÁN</h3>
                </div>
                <div class="invoice-body">
                    <div class="invoice-customer-info">
                        <div class="invoice-customer-left">
                            <label><strong>Tên khách hàng:</strong></label>
                            <span class="invoice-customer-name"></span> <br />
                            <label><strong>Số điện thoại:</strong></label>
                            <span class="invoice-customer-phone"></span> <br />
                            <label><strong>Địa chỉ:</strong></label>
                            <span class="invoice-customer-address"></span> <br />
                            <label><strong>Email:</strong></label>
                            <span class="invoice-customer-email"></span> <br />
                            <label><strong></strong></label>
                            <span class="invoice-customer-voucher"></span> <br />
                        </div>
                        <div class="invoice-customer-right">
                            <label><strong>Ngày đặt:</strong></label>
                            <span class="invoice-date"></span> <br />
                        </div>
                            
                    
                    </div>
                    <div class="invoice-product-list">
                        <h3 class="invoice-product-list-header">Sản phẩm</h3>
                        <!-- <span class="payment-product"></span> -->
                        <div class="invoice-product-list-container">
                            <div class="invoice-product">
                                <span class="invoice-product-img">
                                    <img src>
                                </span>
                                <span class="invoice-product-name"></span>
                                <span class="invoice-product-quantity"></span>
                                <span class="space"></span>
                                <span class="invoice-product-price"></span>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="invoice-process">
                        <div class="invoice-process-total">
                            Tổng cộng:
                            <span class="invoice-total-price"></span>
                        </div>
                          
                        <div class="invoice-process-note">Ghi chú:</div>
                        <div class="invoice-process-payment">Phương thức thanh toán:</div>
                    </div>

                </div>
                <div class="invoice-footer">
                    <div class="invoice-submit">
                        
                        <input type="checkbox" id="invoice-submit-checkbox" required />
                        <label class="invoice-submit-title"for="invoice-submit-checkbox">Tôi đã đọc và kiểm tra trước khi thanh toán.</label>
                        <br>
                        <button id="submit-invoice" type="submit" onclick = "submitPaying()">Xác nhận thanh toán</button>
                    </div>
                </div>
            </div>
        </div>        
    <?php include '../../Layout/Client/footer.php'; ?>
</body>
</html>
