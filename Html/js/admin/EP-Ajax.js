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
document.querySelector(".add-form-employee").addEventListener("submit", function (event) {
    event.preventDefault();
    clearErrors(this);

    let fullname = document.getElementById("employee-name").value;
    let email = document.getElementById("employee-email").value;
    let address = document.getElementById("employee-address").value;
    let phonenumber = document.getElementById("employee-phone").value;
    let position = document.getElementById("positionSelect").value;

    let fullnameRegex = /^[a-zA-ZÀ-Ỹà-ỹ\s]+$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phoneRegex = /^0\d{9}$/;
   

    if (!fullnameRegex.test(fullname)) {
        showError(document.getElementById("employee-name"), "Tên không hợp lệ.");
        return;
    }
    if (!emailRegex.test(email)) {
        showError(document.getElementById("employee-email"), "Email không hợp lệ.");
        return;
    }
    if (!phoneRegex.test(phonenumber)) {
        showError(document.getElementById("employee-phone"), "Số điện thoại không hợp lệ.");
        return;
    }

    let formData = new FormData(this);
    fetch('../../PHP/EP-Add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error("Server trả về lỗi");
        return response.json();
    })
    .then(data => {
        let tableBody = document.querySelector("#employee-table-body");
        if (data.success) {
            alert(data.message);
            console.log(data);
            let newRow = document.createElement("tr");
            newRow.setAttribute("data-id", data.employee.id); 
            newRow.innerHTML = `
                <td>${tableBody.rows.length + 1}</td>
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
        console.error('Fetch Error:', error);
        alert('Đã xảy ra lỗi trong quá trình xử lý. Xem console để biết thêm chi tiết.');
    });
});

//Xóa
document.querySelector(".employee-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-employee")) {
        let empId = event.target.getAttribute("data-id");
        console.log("employee ID:", empId);

        let deleteOverlay = document.getElementById('delete-overlay-employee');
        deleteOverlay.style.display = 'block';

        document.getElementById('delete-acp-employee').onclick = function () {
            fetch('../../PHP/EP-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(empId),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Đã xoá thành công");
                    event.target.closest("tr").remove();
                } else {
                    alert('Xoá nhân viên thất bại!');
                }
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

    clearErrors(this); // Xóa lỗi cũ

    let fullname = document.getElementById("employee-nameFIX").value;
    let email = document.getElementById("employee-emailFIX").value;
    let address = document.getElementById("employee-addressFIX").value;
    let phonenumber = document.getElementById("employee-phoneFIX").value;
    let position = document.getElementById("positionSelectFIX").value;

    let fullnameRegex = /^[a-zA-ZÀ-Ỹà-ỹ\s]+$/;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let phoneRegex = /^0\d{9}$/;
   

    if (!fullnameRegex.test(fullname)) {
        showError(document.getElementById("employee-nameFIX"), "Tên không hợp lệ.");
        return;
    }
    if (!emailRegex.test(email)) {
        showError(document.getElementById("employee-emailFIX"), "Email không hợp lệ.");
        return;
    }
    if (!phoneRegex.test(phonenumber)) {
        showError(document.getElementById("employee-phoneFIX"), "Số điện thoại không hợp lệ.");
        return;
    }

    let formData = new FormData(this);
    fetch("../../PHP/EP-Edit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            console.log(data);
            // Cập nhật giao diện người dùng 
            let row = document.querySelector(`tr[data-id='${data.employee.id}']`);
            if (row) {
                row.innerHTML = `
                    <td>${row.rowIndex}</td>
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
            }
            else
                console.log("Không tìm thấy tài khoản cần cập nhật!");
        } else {
            alert("Lỗi: " + data.message);
        }
    })
    .catch(error => console.error("Lỗi:", error));
  });
