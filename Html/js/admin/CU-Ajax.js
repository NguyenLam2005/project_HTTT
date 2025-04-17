//Xóa
document.querySelector(".customer-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-customer")) {
        let cusId = event.target.getAttribute("data-id");
        console.log("customer ID:", cusId);
        let deleteOverlay = document.getElementById('delete-overlay-customer');
        deleteOverlay.style.display = 'block';
        document.getElementById('delete-acp-customer').onclick = function () {
            fetch('../../PHP/CU-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + cusId,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("da xoa");
                    event.target.closest("tr").remove();
                } else {
                    alert('Xóa khách hàng phẩm thất bại!');
                }
                deleteOverlay.style.display = 'none';
            })};
    };
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
    if (!usernameRegex.test(username)) {
        showError(document.getElementById("customer-uname-f"), "Tên đăng nhập không hợp lệ.");
        return;
    }
    if (!emailRegex.test(email)) {
        showError(document.getElementById("customer-email-f"), "Email không hợp lệ.");
        return;
    }
    if (!fullnameRegex.test(fullname)) {
        showError(document.getElementById("customer-name-f"), "Tên không hợp lệ.");
        return;
    }
    if (!phoneRegex.test(phonenumber)) {
        showError(document.getElementById("customer-phone-f"), "Số điện thoại không hợp lệ.");
        return;
    }

    
    
    let formData = new FormData(this); // Lấy dữ liệu form
    let customerId = document.getElementById("customer-id").value;
    console.log("ID khách hàng:", customerId);

    fetch("../../PHP/CU-Edit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); 
            console.log(data.customer.id);

            // Cập nhật dòng khách hàng trên bảng nếu có
            let row = document.querySelector(`tr[data-id='${data.customer.id}']`);
            if (row) {
                row.innerHTML = `
                    <td>${data.customer.id}</td>
                    <td>${data.customer.fullName}</td>
                    <td>
                        <select class='customer-status' data-id="${data.customer.id}">
                            <option value='1' ${data.customer.status == 1 ? "selected" : ""}>Đang hoạt động</option>
                            <option value='2' ${data.customer.status == 2 ? "selected" : ""}>Đã khóa</option>
                        </select>
                    </td>
                    <td style='text-align: center; vertical-align: middle;'><img src='../../assest/ACdetail.png' class='customer-detail' data-id="${data.customer.id} " alt='Xem chi tiết' ></td>
                    <td style='text-align: center; vertical-align: middle;'>
                        <img src='../../assest/H-oder.png' class='history-order' alt='Xem lịch sử'>
                    </td>
                    <td>
                        <div class='fix-customer'>
                            <i class='fa-solid fa-pen-to-square fix-btn-customer' data-id="${data.customer.id}"></i>
                            <i class='fa-solid fa-trash delete-btn-customer' data-id="${data.customer.id}"></i>
                        </div>
                    </td>
                `;

                let statusSelect = row.querySelector(".customer-status");
                updateStatusColor(statusSelect);// Lấy lại màu trạng thái sau khi cập nhật

                console.log("Cập nhật thành công!");
            }
            
            // Cập nhật phần hiển thị chi tiết
            let detailSection = document.getElementById(`detail-customer-${customerId}`);
            if (detailSection) {
                detailSection.innerHTML = `
                    <i class='fa-solid fa-rotate-left back-customer1' data-id='${customerId}'></i>
                    <h2>Thông Tin Tài Khoản</h2>
                    <div class='cus-info'><span class='cus-label'>Mã Khách Hàng:</span><span class='cus-value'>${data.customer.id}</span></div>
                    <div class='cus-info'><span class='cus-label'>Tên khách hàng:</span><span class='cus-value'>${data.customer.fullName}</span></div>
                    <div class='cus-info'><span class='cus-label'>Trạng thái tài khoản:</span><span class='cus-value'>${data.customer.status == 1 ? "Đang hoạt động" : "Đã khóa"}</span></div>
                    <div class='cus-info'><span class='cus-label'>Số điện thoại:</span><span class='cus-value'>${data.customer.phoneNumber}</span></div>
                    <div class='cus-info'><span class='cus-label'>Email:</span><span class='cus-value'>${data.customer.email}</span></div>
                    <div class='cus-info'><span class='cus-label'>Địa chỉ:</span><span class='cus-value'>${data.customer.address}</span></div>
                    <div class='cus-info'><span class='cus-label'>Tên đăng nhập:</span><span class='cus-value'>${data.customer.userName}</span></div>
                `;
            }
            else
                console.log("Không tìm thấy khách hàng cần cập nhật!");
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        alert('Đã xảy ra lỗi trong quá trình xử lý. Xem console để biết thêm chi tiết.');
    });
});

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("fix-btn-customer")) {
        let customerId = event.target.getAttribute("data-id");
        console.log("customer ID:", customerId);
        fetch(`../../PHP/CU-getCU.php?id=${customerId}`)
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

