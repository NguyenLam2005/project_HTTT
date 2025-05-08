$(".logout-btn-admin").click(function () {
  $.ajax({
    type: "POST",
    url: "/project_HTTT/Html/PHP/Logout_Admin.php",
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        window.location.href = "/project_HTTT/Html/login_admin.php";
      }
    },
    error: function () {
      alert("Có lỗi xảy ra khi đăng xuất!");
    }
  });
});
