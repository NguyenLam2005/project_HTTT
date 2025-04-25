<?php include '../../Layout/Client/headpage.php'; ?>
<?php include '../../Layout/Client/header.php'; ?>

<div class="login__wrapper">
        <div class="login__box">
            <div class="login__image">
                <img src="../../img/login_img2.png" alt="Login Illustration">
            </div>
            <form class="login__form-customer" id="login_form">
                <h2>Đăng nhập</h2>
                <input type="text" id="username" placeholder="Tên đăng nhập" name = "username">
                <div class="password__container">
                    <input type="password" id="password" placeholder="Mật khẩu" name = "password">
                    <i class="fas fa-eye"></i>
                </div>
                <span id="login__error">*Thông tin không hợp lệ</span>
                <button type="submit">Đăng nhập</button>
                <p>Bạn chưa có tài khoản? <a href="registerCustomer.php">Đăng ký</a></p>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
           //Hiện mật khẩu
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

            $('#username, #password').on('input', function() {
                $('#login__error').hide();
            });

            //Đăng nhập
            $('#login_form').submit(function(e){
                e.preventDefault();
                if($('#username').val().trim() === ""){
                    $("#login__error").text('Vui lòng nhập tên đăng nhập!').css("display", "block");
                    $('#username').focus();
                    return;
                }
                if($('#password').val().trim() === ""){
                    $("#login__error").text('Vui lòng nhập mật khẩu!').css("display", "block");
                    $('#password').focus();
                    return;
                }
                let formData = new FormData(this);
                formData.append("action", "login_customer");
                $.ajax({
                    url: '../../Server/Client/account_customer.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',

                    success: function(response){
                        if(response.exists){
                            sessionStorage.setItem("customerInfo", JSON.stringify(response.customer));
                            alert("Đăng nhập thành công!");
                            $('#login_form')[0].reset();
                            window.location.href = '../../index.php';
                        } else if(response.blocked) {
                            alert("Tài khoản đã bị khoá không thể đăng nhập!")
                            $('#login_form')[0].reset();
                        } else {
                            $("#login__error").text("*Tên đăng nhập hoặc mật khẩu không đúng").css("display", "block");
                            $("#username").focus();
                        }
                    },

                    error: function(xhr, status, error){
                        alert("Lỗi hệ thống: " + error);
                    }
                });
            });

        });
    </script>
<?php include '../../Layout/Client/footer.php'; ?>
