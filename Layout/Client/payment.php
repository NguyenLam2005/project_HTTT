<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighTech</title>

    <!-- Thư viện -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../Js/Client/payment.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../../Css/base.css">
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
        <div class="overlayAddressPayment">
        <div class="addr-title-wrapper">
                <h2 class="addr-title">Thay đổi địa chỉ</h2>
                <span class="addr-close" onclick="closeAddressPopup()">×</span>
            </div>
            <label for="diaChi" class="addr-label">Địa chỉ cụ thể:</label>
            <input type="text" class="address addr-input" placeholder="Số nhà, tên đường...">

            <label for="tinh" class="addr-label">Tỉnh / Thành phố:</label>
            <select class="province addr-input">
                <option value="">-- Chọn tỉnh / thành phố --</option>
            </select>

            <label for="quan" class="addr-label">Quận / Huyện:</label>
            <select class="district addr-input">
                <option value="">-- Chọn quận / huyện --</option>
            </select>

            <button class="addr-button" onclick="changeAddress()">Thay đổi</button>
        </div>
        <div id="overlay-payment">
            <div id="payment-container">
                <div class="payment-left-container">
                    <div class="payment-header">
                        <button id="close-payment">x</button>
                        <h3 class="header">THÔNG TIN THANH TOÁN</h3>
                    </div>
                    
                    <form id="payment-left-form">
                        <div class="cus-name">
                            <label><strong>Tên:</strong> </label><span class="payment-customer-name"></span>
                        </div>
                        
                        <br>
                        <div class="cus-email">
                            <label><strong>Email:</strong> </label><span class="payment-customer-email"></span>
                        </div>
                        <br>
                        <div class="cus-phone">
                            <label for="phone-payment" ><strong>Số điện thoại:</strong></label>
                            <span class="payment-customer-phone"></span>
                        </div>
                        <br />
                        <div class="cus-address">
                            <label for="address-payment"><strong>Địa chỉ:</strong> </label>
                            <span class="payment-customer-address content no-margin"></span>
                            <span class="changed no-margin" onclick = "OnUpdateAddressPayment()">Thay đổi</span>    
                        </div>
                        <br />
                        <div class="payment-customer-note">
                            <label for="note-payment"><strong>Ghi chú đơn hàng (tùy chọn)</strong></label> <br />
                            <input style="width: 30vw;" type="text" id="note-payment" placeholder="Nhập ghi chú cho đơn hàng" />

                        </div>
                        <div class="payment-left-footer">
                            <p id="payment-back-cart" style="display: inline-block; margin-top: 200px; color: #007BFF; text-decoration: none;text-align:left;cursor:pointer;margin-left: 0px;position:relative;top: 80px;">
                                ← Quay lại giỏ hàng
                            </p>
                        </div>
                        
                    </form>
                </div>

                <form class="order-summary">
                    <table class="payment-table">
                        <thead>
                            <tr style="border-bottom: 1px solid #ddd">
                                <th colspan="2" class="payment-heading">ĐƠN HÀNG CỦA BẠN</th>
                                <th>
                                <strong>Ngày đặt:
                                    <span class="payment-date">22/09/2005</span>
                                </strong>
                                </th>
                            </tr>
                            <tr class="order-header">
                                <th colspan="2"><strong>SẢN PHẨM</strong></th>
                                <th><strong>TẠM TÍNH</strong></th>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd">
                                <th class="payment-product-name">Tên sản phẩm</th>
                                <th class="payment-quantity">Số lượng</th>
                                <th class="payment-price">Giá</th>
                            </tr>
                        </thead>

                        <tbody id="product-list">
                            
                        </tbody>

                        <tfoot>
                        <tr style="border-top: 1px solid #ddd">
                            <td colspan="2">Tổng tạm tính:</td>
                            <td><span class="payment-total-product-price-value">1.200.200</span><sup>đ</sup></td>
                        </tr>
                        <tr>
                            <td colspan="2">Giao hàng:</td>
                            <td>Giao hàng miễn phí</td>
                        </tr>
                        <tr>
                            <td colspan="2">Tổng đơn:</td>
                            <td><span class="payment-total-price-value">12.000.000<sup>đ</sup></span></td>
                        </tr>
                        </tfoot>
                    </table>
                    
                    <h3>Phương thức thanh toán</h3>
                    <div>
                        <input type="radio" id="cash-on-delivery" name="payment" value="tm" onclick = "toggleCOD()"/>
                        <label for="cash-on-delivery">Thanh toán khi nhận hàng</label>
                    </div>
                    <div>
                        <input type="radio" id="atm-payment" name="payment" value="atm" onclick = "togglePaymentOptions()"/>
                        <label for="atm-payment">Thanh toán bằng ATM</label>
                        <div id="atm-options">
                            <label for="bank">Chọn ngân hàng:</label>
                            <select id="bank">
                                <option value="">Chọn ngân hàng</option>
                                <option value="vietcombank">Vietcombank</option>
                                <option value="techcombank">Techcombank</option>
                                <option value="vpbank">VPBank</option>
                                <option value="agribank">Agribank</option>
                            </select>
                            <div id="select-bank" class="error-msg-payment"></div>
                            <br /><br />
                            <label for="card-number">Số thẻ:</label>
                            <input type="number" id="card-number" placeholder="Nhập số thẻ ATM" required />
                            <div id="payment-card-method-error" class="error-msg-payment"></div>
                        </div>
                    </div>
                    <div id="payment-method-error" class="error-msg-payment"></div>
                    <div class="payment-submit-background">
                        <button type="submit" id="submit-payment-btn" onclick = "invoicePage()">Thanh toán</button>
                    </div>
                </form>

            </div>

        </div>     
    <?php include '../../Layout/Client/footer.php'; ?>
</body>
</html>
