// document.querySelector(".add-form-account").addEventListener("submit", function(e) {
//     e.preventDefault(); // Ngăn form load lại trang

//     let formData = new FormData(this);

//     fetch('../../PHP/AC-Add.php', {
//         method: 'POST',
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         let tableBody = document.querySelector("#account-table-body");
//         if (data.success) {
//             alert(data.message);
//             console.log(data.account);
//             // Tạo hàng mới trong bảng
//             let newRow = document.createElement("tr");
//             newRow.setAttribute("data-id", data.account.id); 
//             newRow.innerHTML = `
//                 <td>${data.account.username}</td>
//                 <td>${data.account.hasshedPassword}</td>
//                 <td>${data.account.email}</td>
//                 <td>
//                     <select class='account-status' >
//                         <option value='1' " . ($status == 1 ? "selected" : "") . ">Đang hoạt động</option>
//                         <option value='2' " . ($status == 2 ? "selected" : "") . ">Đã khóa</option>
//                     </select>
//                 </td>
//                 <td>
//                     <div style = 'display: flex;'>
//                         <span style='margin-left: 10px;'> ${data.account.permission_name}</span>
//                     </div>
//                 </td>
                
//                 <td><div class='fix-account'>
//                     <i class='fa-solid fa-pen-to-square fix-btn-account' data-id='${data.account.id}'></i>
//                     <i class='fa-solid fa-trash delete-btn-account' data-id='${data.account.id}'></i>
//                 </div></td>
//             `;

//             tableBody.appendChild(newRow);

//             // Xóa dữ liệu trong form
//             document.querySelector(".add-form-account").reset();
//         } else {
//             alert("Lỗi: " + data.message);
//         }
//     })
// });

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
document.querySelector(".add-form-account").addEventListener("submit", function(e) {
    e.preventDefault();

    // Validation
    let username = document.getElementById("account-name").value.trim();
    let password = document.getElementById("account-pass").value.trim();
    let permission = document.getElementById("permissionSelect").value;
    
    if (!username) {
        alert("Vui lòng nhập tên đăng nhập!");
        return;
    }

    if (!password) {
        alert("Vui lòng nhập mật khẩu!");
        return;
    }

    if (password.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        return;
    }

    if (!permission) {
        alert("Vui lòng chọn quyền!");
        return;
    }

    let formData = new FormData(this);

    fetch('/PHP/AC-Add.php', {
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
        let tableBody = document.querySelector("#account-table-body");
        if (data.success) {
            alert(data.message);
            let newRow = document.createElement("tr");
            newRow.setAttribute("data-id", data.account.id); 
            newRow.innerHTML = `
                <td>${data.account.username}</td>
                <td>${data.account.fullName}</td>
                <td>
                    <select class='account-status'>
                        <option value='1' ${data.account.status == 1 ? 'selected' : ''}>Đang hoạt động</option>
                        <option value='2' ${data.account.status == 2 ? 'selected' : ''}>Đã khóa</option>
                    </select>
                </td>
                <td>
                    <div style='display: flex;'>
                        <span style='margin-left: 10px; font-weight: bold;'>${data.account.permission_name}</span>
                    </div>
                </td>
                <td>
                    <div class='fix-account'>
                        <i class='fa-solid fa-pen-to-square fix-btn-account' data-id='${data.account.id}'></i>
                        <i class='fa-solid fa-trash delete-btn-account' data-id='${data.account.id}'></i>
                    </div>
                </td>
            `;
            tableBody.appendChild(newRow);
            document.querySelector(".add-form-account").reset();
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
document.querySelector(".account-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-account")) {
        let accountId = event.target.getAttribute("data-id");
        console.log("Account ID:", accountId);
        let deleteOverlay = document.getElementById('delete-overlay-account');
        deleteOverlay.style.display = 'block';
        
        document.getElementById('delete-acp-account').onclick = function () {
            fetch('/PHP/AC-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + accountId,
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
                    alert('Xóa tài khoản thất bại: ' + data.message);
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
    if (event.target.classList.contains("fix-btn-account")) {
        let userId = event.target.getAttribute("data-id");
        
        console.log("Account ID:", userId);
        fetch("../PHP/AC-get_account.php", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + userId
        })
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    // Điền thông tin vào form
                    document.getElementById("account-id").value = data.id;
                    document.getElementById("account-name-f").value = data.userName;
                    // document.getElementById("account-pass-f").value = data.password;

                    // Cập nhật quyền 
                    if (data.permission_id) {
                        document.getElementById("permissionSelect-f").value = data.permission_id;
                    }

                    // Ẩn bảng tài khoản và nút thêm
                    document.querySelector(".account-table").style.display = "none";
                    document.getElementById("account-plus").style.display = "none";

                    // Hiển thị form sửa tài khoản
                    document.querySelector(".fix-form-account").style.display = "block";
                } else {
                    alert("Không tìm thấy tài khoản!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
    }
});

document.getElementById("fix-form-account").addEventListener("submit", function (event) {
    event.preventDefault();

    // Validation
    let username = document.getElementById("account-name-f").value.trim();
    let password = document.getElementById("account-pass-f").value.trim();
    let permission = document.getElementById("permissionSelect-f").value;
    
    if (!username) {
        alert("Vui lòng nhập tên đăng nhập!");
        return;
    }

    if (password && password.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        return;
    }

    if (!permission) {
        alert("Vui lòng chọn quyền!");
        return;
    }

    let formData = new FormData(this);

    fetch('/PHP/AC-Edit.php', {
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
            alert("Cập nhật tài khoản thành công!");
            document.querySelector(".fix-form-account").style.display = "none";
            document.querySelector(".account-table").removeAttribute("style");
            document.getElementById("account-plus").style.display = "block";
            document.getElementById("fix-form-account").reset();
            updateAccountTable();
        } else {
            alert("Có lỗi xảy ra: " + data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi:", error);
        alert('Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại sau.');
    });
});

function updateStatusColor(select) {
    if(select.value == "2"){
        select.style.boxShadow = "0 0 5px 1px red";
    }
    else{
        select.style.boxShadow = "0 0 5px 1px rgb(47, 218, 70)";
    }
}

    



