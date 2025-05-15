function showError(inputElement, message) {
    let errorDiv = inputElement.parentNode.querySelector(".error-msg");
    if (!errorDiv) {
        errorDiv = document.createElement("div");
        errorDiv.className = "error-msg show";
        inputElement.parentNode.appendChild(errorDiv);
    }
    errorDiv.innerHTML = `<i class="fa-solid fa-circle-xmark"></i> ${message}`;
    inputElement.focus();
}

function clearErrors(form) {
    form.querySelectorAll(".error-msg").forEach((error) => {
        error.remove();
    });
}

//Thêm
document.querySelector(".add-form-supplier").addEventListener("submit", function (event) {
    event.preventDefault();
    clearErrors(this);

    let name = document.getElementById("supplier-name").value;
    let phonenumber = document.getElementById("supplier-phone").value;

    let nameRegex = /^[a-zA-ZÀ-Ỹà-ỹ\s]+$/;
    let phoneRegex = /^0\d{9}$/;
   

    if (!nameRegex.test(name)) {
        showError(document.getElementById("supplier-name"), "Tên không hợp lệ.");
        return;
    }
    if (!phoneRegex.test(phonenumber)) {
        showError(document.getElementById("supplier-phone"), "Số điện thoại không hợp lệ.");
        return;
    }

    let formData = new FormData(this);
    fetch('/project_HTTT/Html/PHP/SP-Add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Server trả về lỗi");
        return response.json();
    })
    .then(data => {
        let tableBody = document.getElementById("supplier-table-body");
        if (data.success) {
            alert(data.message);
            console.log(data);
            let newRow = document.createElement("tr");
            newRow.setAttribute("data-id", data.supplier.id); 
            newRow.innerHTML = `
                <td>${data.supplier.id}</td>
                <td>${data.supplier.name}</td>
                <td>${data.supplier.address}</td>
                <td>${data.supplier.phoneNumber}</td>
                <td>
                    <div class='fix-supplier'>
                        <i class='fa-solid fa-pen-to-square fix-btn-supplier' data-id='${data.supplier.id}'></i>
                        <i class='fa-solid fa-trash delete-btn-supplier' data-id='${data.supplier.id}'></i>
                    </div>
                </td>
            `;
            tableBody.appendChild(newRow);
            document.querySelector(".add-form-supplier").reset();
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        alert('Đã xảy ra lỗi trong quá trình xử lý. Xem console để biết thêm chi tiết.');
    });
});

//Xóa
document.querySelector(".supplier-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-supplier")) {
        let spId = event.target.getAttribute("data-id");
        console.log("supplier ID:", spId);

        let deleteOverlay = document.getElementById('delete-overlay-supplier');
        deleteOverlay.style.display = 'block';

        document.getElementById('delete-acp-supplier').onclick = function () {
            fetch('/project_HTTT/Html/PHP/SP-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(spId),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Đã xoá thành công");
                    event.target.closest("tr").remove();
                } else {
                    alert('Xoá thất bại!');
                }
                deleteOverlay.style.display = 'none';
            });
        };
    }
});


//Sửa
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("fix-btn-supplier")) {
        let spId = event.target.getAttribute("data-id");
        
        console.log("supplier ID:", spId);
        fetch(`/project_HTTT/Html/PHP/SP-getSP.php?id=${spId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    console.log(data);
                    // Điền thông tin vào form
                    document.getElementById("supplier-id").value = spId;
                    document.getElementById("supplier-nameFIX").value = data.supplier.name;
                    document.getElementById("supplier-addressFIX").value = data.supplier.address;
                    document.getElementById("supplier-phoneFIX").value = data.supplier.phoneNumber;

                    // Ẩn bảng và nút thêm
                    document.querySelector(".supplier-table").style.display = "none";
                    document.getElementById("supplier-plus").style.display = "none";

                    // Hiển thị form sửa
                    document.querySelector(".fix-form-supplier").style.display = "block";
                } else {
                    alert("Không tìm thấy nhà cung cấp!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
    }
});


document.getElementById("fix-form-supplier").addEventListener("submit", function (event) {
    event.preventDefault();
    clearErrors(this);

    let formData = new FormData(this);
    fetch("/project_HTTT/Html/PHP/SP-Edit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            console.log("Response data:", data);
            
            // Cập nhật giao diện người dùng ngay lập tức
            let row = document.querySelector(`tr[data-id='${data.supplier.id}']`);
            if (row) {
                // Cập nhật từng ô dữ liệu
                row.cells[0].textContent = data.supplier.id;
                row.cells[1].textContent = data.supplier.name;
                row.cells[2].textContent = data.supplier.address;
                row.cells[3].textContent = data.supplier.phoneNumber;
            }

            // Ẩn form sửa và hiển thị lại bảng nhà cung cấp
            document.querySelector(".fix-form-supplier").style.display = "none";
            document.querySelector(".supplier-table").style.display = "table";
            document.getElementById("supplier-plus").style.display = "block";

            // Reset form sửa
            document.getElementById("fix-form-supplier").reset();
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Đã xảy ra lỗi trong quá trình cập nhật. Vui lòng thử lại!");
    });
});
