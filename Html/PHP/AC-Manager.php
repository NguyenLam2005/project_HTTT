<?php
include __DIR__ . '/config.php';

$sql = "SELECT employeeaccount.*, permissions.name AS p_name, employees.fullName 
        FROM employeeaccount 
        LEFT JOIN permissions ON employeeaccount.permission_id = permissions.id
        LEFT JOIN employees ON employeeaccount.userName = employees.id
        ORDER BY employeeaccount.id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];  
        $userId = $row['id'];
        $permission_id = $row['permission_id'];
        $permission_name = $row['p_name'];
        echo "<tr data-id='$userId'>";
        echo "<td>" . htmlspecialchars($row['userName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fullName']) . "</td>";
        echo "<td>
                <select class='account-status' data-id='$userId' data-current-status='$status'>
                    <option value='1' " . ($status == 1 ? "selected" : "") . ">Đang hoạt động</option>
                    <option value='2' " . ($status == 2 ? "selected" : "") . ">Đã khóa</option>
                </select>
              </td>";
         echo "<td>
            <span style=' font-weight: bold;'>" . htmlspecialchars($permission_name) . "</span>
         </td>";
         echo "<td>
         <div class='fix-account'>
             <i class='fa-solid fa-pen-to-square fix-btn-account' data-id='$userId'></i>
             <i class='fa-solid fa-trash delete-btn-account' data-id='$userId'></i>
         </div>
         </td>";
         echo "</tr>";
         echo "<div id='role-popup'>  
                    
               <div class='popup-arrow'></div>
               </div>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align: center;'>Không có tài khoản nào</td></tr>";
}
?>
    <!-- hop thoai xoa AC -->
    <div id="delete-overlay-account">
        <div class="delete-container">
          <span>Bạn muốn xóa tài khoản này?</span>
          <button id="delete-acp-account">Xác nhận</button>
          <button id="cancel-account">Hủy</button>  
        </div>
    </div>


<script>
     
    // Thay đổi trạng thái
    document.addEventListener("DOMContentLoaded", function() {
    document.addEventListener("change", function (event) {
    if (event.target.classList.contains("account-status")) {
        let userId = event.target.getAttribute("data-id");
        let newStatus = event.target.value;

        fetch("../../PHP/AC-update_status.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${userId}&status=${newStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Trạng thái của tài khoản ${userId} đã được cập nhật!`);
            } else {
                alert("Lỗi khi cập nhật trạng thái: " + data.message);
            }
        })
        .catch(error => console.error("Lỗi:", error));
    }
});
});
   

</script>




