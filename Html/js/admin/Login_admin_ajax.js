$(document).ready(function () {
    $("#admin-login-form").submit(function (e) {
        e.preventDefault();
        let username = $(".admin-username").val();
        let password = $(".admin-password").val();

        $.ajax({
            xhrFields: {
                withCredentials: true
            },
            type: "POST",
            url: "../../PHP/Login_Admin.php",
            dataType: "json",
            data: {
                "admin-login": true,
                "admin-username": username,
                "admin-password": password
            },
            success: function (res) {
                if (res.status === "success") {
                    window.location.href = "../../HTML/admin/admin.php";
                } else {
                    $(".error-msg-ad").text(res.message).addClass("show");
                }
            }
        });
    });
});



