document.querySelector(".add-form-role").addEventListener("submit", function (e) {
    e.preventDefault(); // Ngăn form load lại trang
    const checkboxes = document.querySelectorAll("input[name='permissions[]']:checked");
    const roleName = document.getElementById("role-name").value;
    if (roleName.trim() === "") {
        alert("Vui lòng nhập tên quyền!");
        return false; // Dừng việc submit form
    }
    if (checkboxes.length === 0) {
        alert("Vui lòng chọn ít nhất một quyền!");
        return false; // Dừng việc submit form
    }


    let formData = new FormData(this);
    console.log([...formData.entries()]); // Kiểm tra dữ liệu gửi đi

    fetch('/project_HTTT/Html/PHP/PM-Add.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Kiểm tra dữ liệu trả về
            let tableBody = document.querySelector("#role-table-body");

            if (data.success) {
                // Xử lý khi thêm thành công
                alert(data.message);

                // Thêm dòng mới vào bảng
                let newRow = document.createElement("tr");
                newRow.setAttribute("data-id", data.role.id);

                // Inner danh sách tên chức năng
                let functionsHTML = '';
                functionsHTML += `<div class='role-function'>${data.function_count}</div>`;

                newRow.innerHTML = `
                <td>${data.role.name}</td>
                <td>${functionsHTML}</td>
                <td>0</td>
                <td class='role-account'>
                    <img src='../../assest/Download cloud.png' alt='' class='show-userrole' data-id='${data.role.id}'>
                </td>
                <td>
                    <div class='fix-role'>
                        <i class='fa-solid fa-pen-to-square fix-btn-role' data-id='${data.role.id}'></i>
                        <i class='fa-solid fa-trash delete-btn-role' data-id='${data.role.id}'></i>
                    </div>
                </td>
            `;

                tableBody.appendChild(newRow);

                // Cập nhật lại danh sách quyền trong dropdown
                let permissionSelect = document.querySelector("#permissionSelect-f");
                let newOption = document.createElement("option");
                newOption.value = data.role.id;
                newOption.textContent = data.role.name;
                permissionSelect.appendChild(newOption);

                // Xóa dữ liệu trong form
                document.querySelector(".add-form-role").reset();
            } else {
                // Xử lý khi thêm thất bại
                alert("Lỗi: " + data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi khi gửi yêu cầu:', error);
        });
});


//Xóa

document.querySelector(".role-table").addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-btn-role")) {
        let permissionId = event.target.getAttribute("data-id");
        console.log("role ID:", permissionId);
        let deleteOverlay = document.getElementById('delete-overlay-role');
        deleteOverlay.style.display = 'block';
        document.getElementById('delete-acp-role').onclick = function () {
            fetch('/project_HTTT/Html/PHP/PM-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + permissionId,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("da xoa");
                        event.target.closest("tr").remove();
                    } else {
                        alert('Xóa quyền thất bại!');
                    }
                    deleteOverlay.style.display = 'none';
                })
        };
    };
});


// Sửa
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("fix-btn-role")) {
        let permissionId = event.target.getAttribute("data-id");

        console.log("Permission ID:", permissionId);
        fetch(`/project_HTTT/Html/PHP/PM-getPM.php?id=${permissionId}`)
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    console.log("Dữ liệu nhận được:", data);
                    document.getElementById("role-id-f").value = data.id;
                    document.getElementById("role-name-f").value = data.name;

                    if (Array.isArray(data.functions)) {
                        document.querySelectorAll(".permission-checkbox").forEach(checkbox => {
                            checkbox.checked = data.functions.includes(checkbox.value);
                        });
                    } else {
                        console.error("Lỗi: Dữ liệu functions không hợp lệ!", data.functions);
                    }

                    document.querySelector(".role-table").style.display = "none";
                    document.getElementById("role-plus").style.display = "none";
                    document.querySelector(".fix-form-role").style.display = "block";
        
                } else {
                    alert("Không tìm thấy quyền!");
                }
            })
            .catch(error => console.error("Lỗi:", error));
    }
});



document.getElementById("fix-form-role").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch(this.action, {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Cập nhật quyền thành công!");
                // Cập nhật giao diện người dùng 
                document.querySelector(".fix-form-role").style.display = "none";
                document.querySelector(".role-table").removeAttribute("style");
                document.getElementById("role-plus").style.display = "block";
                document.getElementById("fix-form-role").reset();// Reset lại form
                updateRoleTable();// Cập nhật lại dữ liệu bảng quyền 
            } else {
                alert("Có lỗi xảy ra: " + data.error);
            }
        })
        .catch(error => console.error("Lỗi:", error));
});




function updateRoleTable() {
    fetch('/project_HTTT/Html/PHP/PM-Manager.php')
        .then(response => response.text())
        .then(html => {
            document.querySelector(".role-table tbody").innerHTML = html;
            document.querySelector(".role-table").style.width = "100%";
        })
        .catch(error => console.error("Lỗi:", error));
}
