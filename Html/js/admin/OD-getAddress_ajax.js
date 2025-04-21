document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById("order-province");
    const districtSelect = document.getElementById("order-district");
  
    if (provinceSelect && districtSelect) {
      provinceSelect.addEventListener("change", function () {
        const selectedProvinceId = this.value;
  
        if (!selectedProvinceId) {
          districtSelect.innerHTML = "<option value=''>Chọn huyện/quận</option>";
          return;
        }
  
        fetch("../../PHP/OD-get_district.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "province_id=" + encodeURIComponent(selectedProvinceId),
        })
          .then((response) => response.text())
          .then((data) => {
            if (data.trim() === "") {
              districtSelect.innerHTML = "<option value=''>Không có quận/huyện</option>";
            } else {
              districtSelect.innerHTML = data;
            }
          })
          .catch((error) => {
            console.error("Lỗi khi tải quận/huyện:", error);
            districtSelect.innerHTML = "<option value=''>Không thể tải dữ liệu</option>";
          });
      });
    }
});
  