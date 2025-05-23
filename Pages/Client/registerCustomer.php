<?php include '../../Layout/Client/headpage.php'; ?>
<?php include '../../Layout/Client/header.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighTech</title>

    <!-- Thư viện -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<div class="register__wrapper">
        <form class = "form__res-Customer" id = "register_customer">
            <h1>Đăng ký</h1>
        <div class="form__container">
            <div class="form__left">
                <input type="text" name="fullname" id="fullname" placeholder="Họ và tên">
                <input type="text" name="std" id="std" placeholder="Số điện thoại">
                <input type="text" placeholder="Email" name="email" id="email">
            </div>
            <div class="form__right">
                <input type="text" name = "userName" id="username" placeholder="Tên đăng nhặp">
                <div class="password__container">
                <input type="password" name = "password" id="password" placeholder="Mật khẩu">
                <i class="fas fa-eye"></i>
                </div>
                <div class="password__container">
                    <input type="password" id="re-pass" placeholder="Nhập lại mật khẩu">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="form__footer">
            <span id="error_mes">*Thông tin lỗi</span>
            <button id="bnt-submit" type = "submit">Đăng kí</button>
            <p>Bạn đã có tài khoản ? <a href="loginCustomer.php">Đăng nhập</a></p>
        </div>
        </form>
    </div>

    <script>

$(document).ready(function () {

    // Hiện mật khẩu
    $(".password__container i").click(function () {
        let input = $(this).siblings("input");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            $(this).removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            input.attr("type", "password");
            $(this).removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    function clearError(){
        $("#error_mes").text("").hide();
    }

    // Đăng ký tài khoản
    async function validateInput(input) {

        const value = input.val().trim();
        const id = input.attr("id");
        let result = { valid: true, message: "" };

        switch (id){
            case "fullname":
                if(value === ""){
                    result = { valid: false, message: "Vui lòng nhập họ tên" };
                }
                break;
            
            case "std": 
                result = await checkStd(value);
                break;
            case "email":
                result = await checkEmail(value);
                break;
            case "username":
                result = await checkUsername(value);
                break;
            case "password":
                if (value === "") {
                result = { valid: false, message: "Vui lòng nhập mật khẩu!" };
                }
                break;
            case "re-pass":
                const password = $("#password").val().trim();
                if(value === ""){
                    result = {valid: false, message: "Vui lòng nhập lại mật khẩu"};
                }
                else if(value !== password) {
                    result = {valid: false, massage: "Mật khẩu nhập lại không chính xác!"};
                }
                break;
        }

        if (!result.valid) {
        $("#error_mes").text(result.message).css('display', 'block');
        input.css("border-color", "red");
        } else {
            clearError();
            input.css("border-color", "");
        }

        return result.valid;
    }

    let debounceTimers = {};

    function debounce(key, callback, delay = 250) {
        clearTimeout(debounceTimers[key]);
        debounceTimers[key] = setTimeout(callback, delay);
    }

    function checkStd(phone){
        return new Promise((resolve) => {
            debounce('phone', async () => {
                if(!/^0\d{9}$/.test(phone)){
                    resolve({valid: false, message: "Số điện thoại không đúng!"});
                    return;
                }
                
                var formData = new FormData();
                formData.append("action", "check_sdt");
                formData.append("sdt", phone);

                try{
                    const res = await $.ajax({
                        url: '../../Server/Client/account_customer.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                    });

                    if(res.exists){
                        resolve({valid: false, message: "Số điện thoại đã được sử dụng!"});
                    }
                    else{
                        resolve({valid: true});
                    }
                }
                catch{
                    resolve({valid: false, message: "Lỗi khi kiểm tra số điện thoại!"});
                }
            });
        });
    }

    function checkEmail(email){
        return new Promise((resolve) => {
            debounce('email', async () => {
                if(email === ""){
                    resolve({valid: true});
                    return;
                }

                if(!/^[\w.%+-]+@[\w.-]+\.[a-zA-Z]{2,}$/.test(email)){
                    resolve({ valid: false, message: "Email không hợp lệ!" });
                    return;
                }

                const formData = new FormData();
                formData.append("action", "check_email");
                formData.append("email", email);

                try{
                    const res = await $.ajax({
                        url: '../../Server/Client/account_customer.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                    });

                    if(res.exists){
                        resolve({valid: false, message: "Email đã được sử dụng!"});
                    }
                    else{
                        resolve({valid: true});
                    }
                }
                catch{
                        resolve({valid: false, message: "Lỗi khi kiểm tra email!"});
                }

            });
        });
    }

    function checkUsername(username){
        return new Promise((resolve) => {
            debounce('username', async () => {
                if(!/^[a-zA-Z0-9]{6,}$/.test(username)){
                    resolve({valid: false, message: "Tên đăng nhập phải có ít nhất 6 kí tự và không có kí tự đặc biệt"});
                    return;
                }

                var formData = new FormData();
                formData.append("action", "check_username");
                formData.append("userName", username);

                try {
                    const res = await $.ajax({
                        url: '../../Server/Client/account_customer.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                    });

                    if(res.exists){
                    resolve({ valid: false, message: "Tên đăng nhập đã tồn tại!" });
                    }
                    else{
                    resolve({ valid: true });
                    }
                }
                catch{
                    resolve({ valid: false, message: "Lỗi khi kiểm tra tên đăng nhập!" });
                }
            });
        });
    }

    $(document).ready(() => {
        $("input").on("input", async function() {
            await validateInput($(this));
        });
    });

    $("#register_customer").submit( async function (e) {
        e.preventDefault();

        let formIsValid = true;
        let firstInvalidInput = null;

        for (const input of $("input")) {
            const valid = await validateInput($(input));
            if (!valid && !firstInvalidInput) {
                firstInvalidInput = $(input);
                formIsValid = false;
                break;
            }
        }

        if (formIsValid) {
            var formData = new FormData(this);
            formData.append("action", "register_customer");

            $.ajax({
                url: '../../Server/Client/account_customer.php',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $("#register_customer")[0].reset();
                        alert("Đăng ký thành công");
                        window.location.href = "loginCustomer.php";
                    } else {
                        alert("Đăng ký thất bại: " + response.error);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Lỗi hệ thống: " + error);
                }
            });
        } else {
            if (firstInvalidInput){
            firstInvalidInput.focus();
        }
        }
    });
});

    </script>

<?php include '../../Layout/Client/footer.php'; ?>