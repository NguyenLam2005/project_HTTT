//Xóa
document.querySelector(".customer-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-customer")) {
        let cusId = event.target.getAttribute("data-id");
        console.log("customer ID:", cusId);
        let deleteOverlay = document.getElementById('delete-overlay-customer');
        deleteOverlay.style.display = 'block';
        document.getElementById('delete-acp-customer').onclick = function () {
            fetch('/project_HTTT/Html/PHP/CU-delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + cusId,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    event.target.closest("tr").remove();
                } else {
                    alert(data.message || 'Xóa khách hàng thất bại!');
                }
                deleteOverlay.style.display = 'none';
            })
            .catch(error => {
                console.error("Lỗi:", error);
                alert("Lỗi khi xóa khách hàng!");
                deleteOverlay.style.display = 'none';
            });
        };
    }
});

//Sửa
document.getElementById("fix-form-customer").addEventListener("submit", function (event) {
    event.preventDefault(); 

    clearErrors(this);

    let username = document.getElementById("customer-uname-f").value;
    let email = document.getElementById("customer-email-f").value;
    let password = document.getElementById("customer-pass-f").value;
    let phonenumber = document.getElementById("customer-phone-f").value;
    let fullname = document.getElementById("customer-name-f").value;

    let usernameRegex = /^[a-zA-Z0-9_]+$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let passwordRegex = /^.{8,}$/;
    let phoneRegex = /^0\d{9}$/;
    let fullnameRegex = /^[a-zA-ZÀ-Ỹà-ỹ\s]+$/;

    if (!passwordRegex.test(password)) {
        showError(document.getElementById("customer-pass-f"), "Mật khẩu phải từ 8 ký tự trở lên.");
        return;
    }

    if (!emailRegex.test(email)) {
        showError(document.getElementById("customer-email-f"), "Email không hợp lệ.");
        return;
    }

    if (!phoneRegex.test(phonenumber)) {
        showError(document.getElementById("customer-phone-f"), "Số điện thoại không hợp lệ.");
        return;
    }

    if (!fullnameRegex.test(fullname)) {
        showError(document.getElementById("customer-name-f"), "Tên không hợp lệ.");
        return;
    }

    let formData = new FormData(this);
    fetch('/project_HTTT/Html/PHP/CU-Edit.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Cập nhật thông tin trong bảng
            let row = document.querySelector(`tr[data-id='${data.customer.id}']`);
            if (row) {
                row.cells[1].textContent = data.customer.fullName;
                // Cập nhật các thông tin khác nếu cần
            }
            // Ẩn form sửa
            document.querySelector(".fix-form-customer").style.display = "none";
            document.querySelector(".customer-table").style.display = "table";
        } else {
            alert(data.message || "Lỗi khi cập nhật thông tin khách hàng!");
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert("Lỗi khi cập nhật thông tin khách hàng!");
    });
});

// Cập nhật trạng thái
document.querySelector(".customer-table").addEventListener("change", function(event) {
    if (event.target.classList.contains("customer-status")) {
        let cusId = event.target.getAttribute("data-id");
        let newStatus = event.target.value;
        
        fetch('/project_HTTT/Html/PHP/CU-update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${cusId}&status=${newStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || "Lỗi khi cập nhật trạng thái!");
                // Khôi phục giá trị cũ
                event.target.value = event.target.getAttribute("data-current-status");
                updateStatusColor();
            }
        })
        .catch(error => {
            console.error("Lỗi:", error);
            alert("Lỗi khi cập nhật trạng thái!");
            // Khôi phục giá trị cũ
            event.target.value = event.target.getAttribute("data-current-status");
        });
    }
});

function updateStatusColor() {
    const statusElements = document.querySelectorAll(".customer-status");
    statusElements.forEach(select => {
        ChangeStatus({ target: select }); 
    });
}


function ChangeStatus(event){
    let select = event.target;

    if(select.value == "2"){
        select.style.boxShadow = "0 0 5px 1px red";
    }
    else{
        select.style.boxShadow = "0 0 5px 1px rgb(47, 218, 70)";
    }
}




document.addEventListener("click", function (event) {
    if (event.target.classList.contains("fix-btn-customer")) {
        let customerId = event.target.getAttribute("data-id");
        console.log("customer ID:", customerId);
        fetch(`/project_HTTT/Html/PHP/CU-getCU.php?id=${customerId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    console.log(data);
                    document.getElementById("customer-id").value = data.id;
                    document.getElementById("customer-name-f").value = data.fullName;
                    document.getElementById("customer-phone-f").value = data.phoneNumber;
                    document.getElementById("customer-email-f").value = data.email;
                    // document.getElementById("customer-address-f").value = data.address;
                    document.getElementById("customer-uname-f").value = data.userName;

                    // Ẩn bảng khách hàng và nút thêm
                    document.querySelector(".customer-table").style.display = "none";

                    // Hiển thị form sửa khách hàng
                    document.querySelector(".fix-form-customer").style.display = "block";
                } else {
                    alert("Không tìm thấy khách hàng!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
    }
});

// Hàm lấy lại màu trạng thái
function updateStatusColor(select) {
    if(select.value == "2"){
        select.style.boxShadow = "0 0 5px 1px red";
    }
    else{
        select.style.boxShadow = "0 0 5px 1px rgb(47, 218, 70)";
    }
}

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

