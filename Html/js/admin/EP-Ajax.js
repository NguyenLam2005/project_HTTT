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
document.querySelector(".add-form-employee").addEventListener("submit", function(e) {
    e.preventDefault();

    // Validation
    let fullName = document.getElementById("employee-name").value.trim();
    let email = document.getElementById("employee-email").value.trim();
    let phoneNumber = document.getElementById("employee-phone").value.trim();
    let address = document.getElementById("employee-address").value.trim();
    let position = document.getElementById("positionSelect").value;
    
    if (!fullName) {
        alert("Vui lòng nhập họ tên!");
        return;
    }

    if (fullName.length > 100) {
        alert("Họ tên quá dài (tối đa 100 ký tự)!");
        return;
    }

    if (!email) {
        alert("Vui lòng nhập email!");
        return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Email không hợp lệ!");
        return;
    }

    if (!phoneNumber) {
        alert("Vui lòng nhập số điện thoại!");
        return;
    }

    if (!/^[0-9]{10,11}$/.test(phoneNumber)) {
        alert("Số điện thoại không hợp lệ!");
        return;
    }

    if (!address) {
        alert("Vui lòng nhập địa chỉ!");
        return;
    }

    if (address.length > 200) {
        alert("Địa chỉ quá dài (tối đa 200 ký tự)!");
        return;
    }

    if (!position) {
        alert("Vui lòng chọn chức vụ!");
        return;
    }

    let formData = new FormData(this);

    fetch('/PHP/EP-Add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        let tableBody = document.querySelector("#employee-table-body");
        if (data.success) {
            alert(data.message);
            let newRow = document.createElement("tr");
            newRow.setAttribute("data-id", data.employee.id); 
            newRow.innerHTML = `
                <td>${tableBody.children.length + 1}</td>
                <td>${data.employee.id}</td>
                <td>${data.employee.fullName}</td>
                <td>${data.employee.position_name}</td>
                <td>${data.employee.email}</td>
                <td>${data.employee.address}</td>
                <td>${data.employee.phoneNumber}</td>
                <td>
                    <div class='fix-employee'>
                        <i class='fa-solid fa-pen-to-square fix-btn-employee' data-id='${data.employee.id}'></i>
                        <i class='fa-solid fa-trash delete-btn-employee' data-id='${data.employee.id}'></i>
                    </div>
                </td>
            `;
            tableBody.appendChild(newRow);
            document.querySelector(".add-form-employee").reset();
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau.');
    });
});

//Xóa
document.querySelector(".employee-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-employee")) {
        let employeeId = event.target.getAttribute("data-id");
        console.log("Employee ID:", employeeId);
        let deleteOverlay = document.getElementById('delete-overlay-employee');
        deleteOverlay.style.display = 'block';
        
        document.getElementById('delete-acp-employee').onclick = function () {
            fetch('/PHP/EP-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + employeeId,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log("Đã xóa");
                    event.target.closest("tr").remove();
                } else {
                    alert('Xóa nhân viên thất bại: ' + data.message);
                }
                deleteOverlay.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau.');
                deleteOverlay.style.display = 'none';
            });
        };
    }
});

//Sửa
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("fix-btn-employee")) {
        let empId = event.target.getAttribute("data-id");
        
        console.log("employee ID:", empId);
        fetch(`../../PHP/EP-getEP.php?id=${empId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    console.log(data);
                    // Điền thông tin vào form
                    document.getElementById("employee-id").value = data.employee.id;
                    document.getElementById("employee-nameFIX").value = data.employee.fullName;
                    document.getElementById("employee-emailFIX").value = data.employee.email;
                    document.getElementById("employee-addressFIX").value = data.employee.address;
                    document.getElementById("employee-phoneFIX").value = data.employee.phoneNumber;
                  
                    // Cập nhật quyền 
                    if (data.employee.position_id) {
                        document.getElementById("positionSelectFIX").value = data.employee.position_id;
                    }

                    // Ẩn bảng tài khoản và nút thêm
                    document.querySelector(".employee-table").style.display = "none";
                    document.getElementById("employee-plus").style.display = "none";

                    // Hiển thị form sửa tài khoản
                    document.querySelector(".fix-form-employee").style.display = "block";
                } else {
                    alert("Không tìm thấy nhân viên!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
    }
});

document.getElementById("fix-form-employee").addEventListener("submit", function (event) {
    event.preventDefault();

    // Validation
    let fullName = document.getElementById("employee-nameFIX").value.trim();
    let email = document.getElementById("employee-emailFIX").value.trim();
    let phoneNumber = document.getElementById("employee-phoneFIX").value.trim();
    let address = document.getElementById("employee-addressFIX").value.trim();
    let position = document.getElementById("positionSelectFIX").value;
    
    if (!fullName) {
        alert("Vui lòng nhập họ tên!");
        return;
    }

    if (fullName.length > 100) {
        alert("Họ tên quá dài (tối đa 100 ký tự)!");
        return;
    }

    if (!email) {
        alert("Vui lòng nhập email!");
        return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Email không hợp lệ!");
        return;
    }

    if (!phoneNumber) {
        alert("Vui lòng nhập số điện thoại!");
        return;
    }

    if (!/^[0-9]{10,11}$/.test(phoneNumber)) {
        alert("Số điện thoại không hợp lệ!");
        return;
    }

    if (!address) {
        alert("Vui lòng nhập địa chỉ!");
        return;
    }

    if (address.length > 200) {
        alert("Địa chỉ quá dài (tối đa 200 ký tự)!");
        return;
    }

    if (!position) {
        alert("Vui lòng chọn chức vụ!");
        return;
    }

    let formData = new FormData(this);

    fetch('/PHP/EP-Edit.php', {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert("Cập nhật nhân viên thành công!");
            document.querySelector(".fix-form-employee").style.display = "none";
            document.querySelector(".employee-table").removeAttribute("style");
            document.getElementById("employee-plus").style.display = "block";
            document.getElementById("fix-form-employee").reset();
            updateEmployeeTable();
        } else {
            alert("Có lỗi xảy ra: " + data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert('Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau.');
    });
});
