document.addEventListener("DOMContentLoaded", function () {
  // ----------- Form Thêm Sản Phẩm -----------
  const categoryAdd = document.getElementById("product-category");
  const subcategoryAdd = document.getElementById("product-subcategory");

  if (categoryAdd && subcategoryAdd) {
    categoryAdd.addEventListener("change", function () {
      const categoryId = this.value;

      fetch("../../PHP/PD-getSubcategory.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "category_id=" + encodeURIComponent(categoryId),
      })
        .then((response) => response.text())
        .then((data) => {
          subcategoryAdd.innerHTML = data;
        })
        .catch((error) => {
          console.error("Lỗi khi tải phân loại (thêm):", error);
          subcategoryAdd.innerHTML = "<option value=''>Không thể tải dữ liệu</option>";
        });
    });
  }

  // ----------- Form Sửa Sản Phẩm -----------
  const categoryFix = document.getElementById("product-categoryFIX");
  const subcategoryFix = document.getElementById("product-subcategoryFIX");

  if (categoryFix && subcategoryFix) {
    categoryFix.addEventListener("change", function () {
      const categoryId = this.value;

      fetch("../../PHP/PD-getSubcategory.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "category_id=" + encodeURIComponent(categoryId),
      })
        .then((response) => response.text())
        .then((data) => {
          subcategoryFix.innerHTML = data;
        })
        .catch((error) => {
          console.error("Lỗi khi tải phân loại (sửa):", error);
          subcategoryFix.innerHTML = "<option value=''>Không thể tải dữ liệu</option>";
        });
    });
  }
});
