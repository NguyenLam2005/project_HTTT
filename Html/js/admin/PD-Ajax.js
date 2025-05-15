 // Lọc sản phẩm theo nhà cung cấp
 document.addEventListener("DOMContentLoaded", function () {
 let productFilterForm  = document.getElementById("filter-form-product1");
 let tableBodyProduct1 = document.querySelector("#product-table-body");

 console.log("Form:", productFilterForm);
 productFilterForm.addEventListener("submit", function (event) {
     event.preventDefault();

     let supplier = document.getElementById("product-supplier-filter").value;

     let formData = new URLSearchParams();
     formData.append("supplier", supplier);

     fetch("/project_HTTT/Html/PHP/PD-Manager.php", {
         method: "POST",
         headers: {
             "Content-Type": "application/x-www-form-urlencoded"
         },
         body: formData.toString()
     })
     .then(response => response.text())
     .then(html => {
        tableBodyProduct1.innerHTML = html;
     })
     .catch(error => console.error("Lỗi lọc sản phẩm:", error));
 });
});

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("fix-btn-product")) {
        let productId = event.target.getAttribute("data-id");
        console.log("Product ID:", productId);
        fetch(`/project_HTTT/Html/PHP/PD-getPD.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (!data.error) {
                    document.getElementById("preview-image").src = data.image;
                    document.getElementById("product-id").value = data.id;
                    document.getElementById("product-nameFIX").value = data.name;
                    document.getElementById("product-categoryFIX").value = data.category_id;
                    document.getElementById("product-priceFIX").value = data.price;
                    document.getElementById("product-supplierFIX").value = data.supplier_id;
                    document.getElementById("product-brandFIX").value = data.brand_id;
                    document.getElementById("product-genderFIX").value = data.gender_id;
                    document.getElementById("product-descriptionFIX").value = data.description;
                    document.getElementById("product-warrantyFIX").value = data.warrantyPeriod;

                    // Ẩn bảng sản phẩm và nút thêm
                    document.querySelector(".product-table").style.display = "none";
                    document.getElementById("product-plus").style.display = "none";

                    // Hiển thị form sửa sản phẩm
                    document.querySelector(".fix-form-product").style.display = "block";
                } else {
                    alert("Không tìm thấy sản phẩm!");
                }
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Lỗi khi tải thông tin sản phẩm!");
            });
    }
});

function uploadImg(inputElement) {
    const preview = document.getElementById("preview-image"); // Tìm ảnh xem trước
    const fileSelected = inputElement.files;

    if (fileSelected.length > 0) {
        const fileToLoad = fileSelected[0];
        const fileReader = new FileReader();

        fileReader.onload = function(event) {
            if (preview) {
                preview.src = event.target.result; // Gán ảnh mới
                preview.style.display = "block"; // Hiển thị ảnh nếu nó đang bị ẩn
            } else {
                console.error("Không tìm thấy thẻ img để hiển thị ảnh xem trước!");
            }
        };

        fileReader.readAsDataURL(fileToLoad);
    }
}

document.getElementById("product-image").onchange = function(event) {
    const file = event.target.files[0]; // Lấy file ảnh được chọn
    if (file) {
        console.log("da cap nhat")
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("preview-image").src = e.target.result; // Cập nhật ảnh preview
        };
        reader.readAsDataURL(file);
    }
};

document.querySelector(".product-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-product")) {
        let productId = event.target.getAttribute("data-id");
        let deleteOverlay = document.getElementById("delete-overlay-product");
        deleteOverlay.style.display = "block";
        console.log("Product ID:", productId);
        document.getElementById("delete-acp-product").onclick = function () {
            fetch("/project_HTTT/Html/PHP/PD-delete.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "id=" + productId,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        event.target.closest("tr").remove();
                        let inventorytableBody = document.querySelector("#inventory-table-body");
                        fetch("/project_HTTT/Html/PHP/IV-Manager.php")
                        .then(response => response.text())
                        .then(html => {
                            // Cập nhật lại nội dung bảng
                            inventorytableBody.innerHTML = html; 
                        })
                    } else {
                        alert(data.message || "Xóa sản phẩm thất bại!");
                    }
                    deleteOverlay.style.display = "none";
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Lỗi khi xóa sản phẩm!");
                    deleteOverlay.style.display = "none";
                });
        };
    }
});

document.querySelector(".add-form-product").addEventListener("submit", function(e) {
    e.preventDefault(); // Ngăn form load lại trang

    let formData = new FormData(this);

    fetch('/project_HTTT/Html/PHP/PD-Add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        let tableBody = document.querySelector("#product-table-body");
        if (data.success) {
            alert(data.message);

            // Tạo hàng mới trong bảng
            let newRow = document.createElement("tr");
            newRow.setAttribute("data-id", data.product.id); 
            newRow.innerHTML = `
                <td class='img-admin'><img src="${data.product.image}" alt='' width='50'></td>
                <td>${data.product.name}</td>
                <td>${data.product.brand_name}</td>
                <td>${data.product.category_name}</td>
                <td>${data.product.quantity}</td>
                <td>${data.product.price}</td>
                <td><div class='fix-product'>
                    <i class='fa-solid fa-pen-to-square fix-btn-product' data-id='${data.product.id}'></i>
                    <i class='fa-solid fa-trash delete-btn-product' data-id='${data.product.id}'></i>
                </div></td>
            `;

            // Thêm vào bảng sản phẩm
            tableBody.appendChild(newRow);

            // Xóa dữ liệu trong form
            document.querySelector(".add-form-product").reset();
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi kết nối đến máy chủ:", error);
        alert("Lỗi kết nối đến máy chủ!");
    });
    
});

document.getElementById("update-form-product").addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(this);
    let productId = document.getElementById("product-id").value;
    console.log("ID sản phẩm:", productId);
    fetch("/project_HTTT/Html/PHP/PD-edit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            console.log(data.product);
            let row = document.querySelector(`tr[data-id='${data.product.id}']`);
            if (row) {
                row.innerHTML = `
                    <td class='img-admin'><img src="${data.product.image}" alt="" width="50"></td>
                    <td>${data.product.name}</td>
                    <td>${data.product.brand_name}</td>
                    <td>${data.product.category_name}</td>
                    <td>${data.product.quantity}</td>
                    <td>${data.product.price}</td>
                    <td>
                        <div class='fix-product'>
                            <i class='fa-solid fa-pen-to-square fix-btn-product' data-id="${data.product.id}"></i>
                            <i class='fa-solid fa-trash delete-btn-product' data-id="${data.product.id}"></i>
                        </div>
                    </td>
                `;
                console.log("Cập nhật thành công!");
            }
            // Hiển thị lại bảng và nút thêm, ẩn form sửa
            document.querySelector(".product-table").style.display = "table";
            document.getElementById("product-plus").style.display = "block";
            document.querySelector(".fix-form-product").style.display = "none";
        } else {
            alert(data.message || "Lỗi khi cập nhật sản phẩm!");
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Lỗi khi cập nhật sản phẩm!");
    });
});

   
