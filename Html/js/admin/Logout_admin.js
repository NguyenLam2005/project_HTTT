$(".logout-btn-admin").click(function () {
  $.ajax({
    type: "POST",
    url: "../../PHP/Logout_Admin.php",
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        window.location.href = "../../login_admin.php";
      }
    },
    error: function () {
      alert("Có lỗi xảy ra khi đăng xuất!");
    }
  });
});
