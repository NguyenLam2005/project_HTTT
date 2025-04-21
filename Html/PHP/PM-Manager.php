<?php
include __DIR__ . '/config.php';

$sql = "SELECT 
    p.id AS permission_id,
    p.name AS 'P_NAME', 
    GROUP_CONCAT(DISTINCT f.name ORDER BY f.name SEPARATOR '|') AS 'F_NAME',
    COUNT(DISTINCT u.id) AS 'AC_COUNT',
    GROUP_CONCAT(DISTINCT u.userName ORDER BY u.userName SEPARATOR '|') AS 'USER_LIST'
FROM permissions p
LEFT JOIN permission_function pf ON p.id = pf.permission_id
LEFT JOIN functions f ON pf.function_id = f.id
LEFT JOIN employeeaccount u ON p.id = u.permission_id
GROUP BY p.id";

$result = $conn->query($sql);

$usersList = []; // Mảng chứa danh sách user theo permission_id

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $permissionId = $row['permission_id'];
        $usersList[$permissionId] = isset($row['USER_LIST']) ? explode('|', $row['USER_LIST']) : [];

        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['P_NAME']) . "</td>";

        // Chức năng
        echo "<td class='list-role-function'>";
        $functions = explode('|', $row['F_NAME']);
        foreach ($functions as $function) {
            echo "<div class='role-function'>" . htmlspecialchars($function) . "</div>";
        }
        echo "</td>";

        // Số lượng tài khoản
        echo "<td>" . $row['AC_COUNT'] . "</td>";

        // Nút hiển thị modal
        echo "<td class='role-account'>";
        echo "<img src='../../assest/Download cloud.png' alt='' class='show-userrole' data-id='$permissionId'>";
        echo "</td>";

        // Edit
        echo "<td>
        <div class='fix-role'>
            <i class='fa-solid fa-pen-to-square fix-btn-role' data-id='$permissionId'></i>
            <i class='fa-solid fa-trash delete-btn-role' data-id='$permissionId'></i>
        </div>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td style='text-align: center;' colspan='5'>Không có dữ liệu</td></tr>";
}

// Đặt modal ngoài vòng lặp để tránh lặp nhiều lần
?>
<div id="account-overlay-role">
    <div class="account-role-container">
        <img src="../../assest/Chevron down.png" alt="" id="close-modal">
        <div class="list-user-role" id="account-list"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let usersList = <?php echo json_encode($usersList); ?>; // Chuyển dữ liệu PHP sang JavaScript

        document.querySelectorAll(".show-userrole").forEach(function (button) {
            button.addEventListener("click", function () {
                let permissionId = this.getAttribute("data-id"); // Lấy ID quyền
                let overlay = document.querySelector("#account-overlay-role"); // Modal chính
                let userListContainer = document.querySelector("#account-list"); // Danh sách user trong modal
                
                // Xóa danh sách user cũ trước khi thêm mới
                userListContainer.innerHTML = "";

                if (usersList[permissionId] && usersList[permissionId].length > 0) {
                    usersList[permissionId].forEach(function (user) {
                        let userDiv = document.createElement("div");
                        userDiv.className = "role-function";
                        userDiv.textContent = user;
                        userListContainer.appendChild(userDiv);
                    });
                } else {
                    userListContainer.innerHTML = "<div class='role-function'>Không có người dùng</div>";
                }

                overlay.style.display = "flex"; // Hiển thị modal
            });
        });

        // Đóng modal khi click ra ngoài hoặc vào nút đóng
        document.querySelector("#account-overlay-role").addEventListener("click", function (e) {
            if (e.target === this || e.target.id === "close-modal") {
                this.style.display = "none"; // Ẩn modal
            }
        });
    });
</script>