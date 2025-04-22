<?php include '../../Layout/Client/headpage.php'; ?>
<?php include '../../Layout/Client/header.php'; ?>
<div class="register__wrapper">
        <form class = "form__res-Customer" id = "register_customer">
            <h1>Đăng ký</h1>
        <div class="form__container">
            <div class="form__left">
                <input type="text" name="fullname" id="fullname" placeholder="Họ và tên">
                <input type="text" name="std" id="std" placeholder="Số điện thoại">
                <input type="text" placeholder="Địa chỉ" name="dia_chi" id="dia_chi">
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

    // Đăng ký tài khoản
    function validateInput(input) {
        const value = input.val().trim();
        const id = input.attr("id");
        let isValid = true;
        let errorMessage = "";
        const errorElement = $("#error_mes");

        if (id === "fullname" && value === "") {
            isValid = false;
            errorMessage = "Vui lòng nhập họ tên!";
        }

        if (id === "std") {
            if (value === "") {
                isValid = false;
                errorMessage = "Vui lòng nhập số điện thoại!";
            } else if (!/^0\d{9}$/.test(value)) {
                isValid = false;
                errorMessage = "*Số điện thoại không đúng";
            } else {
                var formData = new FormData();
                formData.append("action", "check_sdt");
                formData.append("sdt", value);

                $.ajax({
                    url: '../../Server/Client/account_customer.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.exists) {
                            errorElement.text("*Số điện thoại đã được sử dụng").css("display", "block");
                            input.css("border-color", "red");
                        } else {
                            errorElement.css("display", "none");
                            input.css("border-color", "");
                        }
                    },
                    error: function () {
                        console.error('Lỗi khi kiểm tra số điện thoại');
                    }
                });
            }
        }

        if (id === "dia_chi" && value === "") {
            isValid = false;
            errorMessage = "Vui lòng nhập địa chỉ!";
        }

        if (id === "username") {
            if (value === "") {
                isValid = false;
                errorMessage = "Vui lòng nhập tên đăng nhập!";
            } else if (!/^[a-zA-Z0-9]{6,}$/.test(value)) {
                isValid = false;
                errorMessage = "*Tên đăng nhập phải có ít nhất 6 ký tự, không chứa ký tự đặc biệt";
            } else {
                var formData = new FormData();
                formData.append("action", "check_username");
                formData.append("userName", value);

                $.ajax({
                    url: '../../Server/Client/account_customer.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.exists) {
                            errorElement.text("*Tên đăng nhập đã tồn tại").css("display", "block");
                            input.css("border-color", "red");
                        } else {
                            errorElement.css("display", "none");
                            input.css("border-color", "");
                        }
                    },
                    error: function () {
                        console.error('Lỗi khi kiểm tra tên đăng nhập');
                    }
                });
            }
        }

        if (id === "password" && value === "") {
            isValid = false;
            errorMessage = "Vui lòng nhập mật khẩu";
        }

        if (id === "re-pass") {
            const password = $("#password").val().trim();
            if (value !== password) {
                isValid = false;
                errorMessage = "Mật khẩu không khớp!";
            }
        }

        if (!isValid) {
            errorElement.text(errorMessage).css("display", "block");
            input.css("border-color", "red");
        } else {
            errorElement.text("").css("display", "none");
            input.css("border-color", "");
        }

        return isValid;
    }

    $("input").on("input", function () {
        validateInput($(this));
    });

    $("#register_customer").submit(function (e) {
        e.preventDefault();

        let formIsValid = true;
        let firstErrorMessage = "";
        let firstInvalidInput = null;

        $("input").each(function () {
            const isValid = validateInput($(this));
            if (!isValid && firstErrorMessage === "") {
                formIsValid = false;
                firstErrorMessage = $("#error_mes").text();
                firstInvalidInput = $(this);
            }
        });

        if (formIsValid) {
            var formData = new FormData(document.getElementById("register_customer"));
            formData.append("action", "register_customer");

            $.ajax({
                url: '../../Server/Client/account_customer.php',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response);  // In ra dữ liệu để kiểm tra
                    if (response.success) {
                        alert("Đăng ký thành công");
                        $("#register_customer")[0].reset();
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
            $("#error_mes").text(firstErrorMessage).css("display", "block");
            firstInvalidInput.focus();
        }
    });
});

    </script>

<?php include '../../Layout/Client/footer.php'; ?>