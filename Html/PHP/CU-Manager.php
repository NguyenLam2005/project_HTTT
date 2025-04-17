<?php
include 'config.php';

$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        $cusId = $row['id'];
        echo "<tr data-id='$cusId'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fullName']) . "</td>";
        echo "<td>
                <select class='customer-status' data-id='$cusId' data-current-status='$status'>
                    <option value='1' " . ($status == 1 ? "selected" : "") . ">Đang hoạt động</option>
                    <option value='2' " . ($status == 2 ? "selected" : "") . ">Đã khóa</option>
                </select>
              </td>";
        echo "<td style='text-align: center; vertical-align: middle;'>
                <img src='' class='customer-detail' data-id='$cusId' alt='Xem chi tiết'>
              </td>";
        echo "<td style='text-align: center; vertical-align: middle;'>
              <img src='' class='history-order' alt='Xem lịch sử'>
            </td>";
        echo "<td>
                <div class='fix-customer'>
                    <i class='fa-solid fa-pen-to-square fix-btn-customer' data-id='$cusId'></i>
                    <i class='fa-solid fa-trash delete-btn-customer' data-id='$cusId'></i>
                </div>
              </td>";
        echo "</tr>";

        // Phần hiển thị chi tiết khách hàng
        echo "<div class='detail-customer-container' id='detail-customer-$cusId' >";
        echo "    <i class='fa-solid fa-rotate-left back-customer1' data-id='$cusId'></i>";
        echo "    <h2>Thông Tin Tài Khoản</h2>";
        echo "    <div class='cus-info'><span class='cus-label'>Mã Khách Hàng:</span><span class='cus-value'>" . $row['id'] . "</span></div>";
        echo "    <div class='cus-info'><span class='cus-label'>Tên khách hàng:</span><span class='cus-value'>" . $row['fullName'] . "</span></div>";
        echo "    <div class='cus-info'><span class='cus-label'>Trạng thái tài khoản:</span><span class='cus-value'>" . ($status == 1 ? "Đang hoạt động" : "Đã khóa") . "</span></div>";
        echo "    <div class='cus-info'><span class='cus-label'>Số điện thoại:</span><span class='cus-value'>" . $row['phoneNumber'] . "</span></div>";
        echo "    <div class='cus-info'><span class='cus-label'>Email:</span><span class='cus-value'>" . $row['email'] . "</span></div>";
        echo "    <div class='cus-info'><span class='cus-label'>Địa chỉ:</span><span class='cus-value'>" . $row['address'] . "</span></div>";
        echo "    <div class='cus-info'><span class='cus-label'>Tên đăng nhập:</span><span class='cus-value'>" . $row['userName'] . "</span></div>";
        echo "</div>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align: center;'>Không có tài khoản nào</td></tr>";
}
?>

<div id="delete-overlay-customer">
    <div class="delete-container">
        <span>Bạn muốn xóa khách hàng?</span>
        <button id="delete-acp-customer">Xác nhận</button>
        <button id="cancel-customer">Hủy</button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let table = document.querySelector(".customer-table");

        // Lắng nghe sự kiện click trên document để xử lý cả phần tử được thêm động
        document.addEventListener("click", function (event) {
            let target = event.target;

            // Khi click vào ảnh, hiển thị thông tin chi tiết khách hàng
            if (target.classList.contains("customer-detail")) {
                let cusId = target.getAttribute("data-id");
                table.style.display = "none";

                // Ẩn tất cả các chi tiết khách hàng
                document.querySelectorAll(".detail-customer-container").forEach(div => {
                    div.style.display = "none";
                });

                // Hiển thị chi tiết khách hàng được chọn
                let detailCustomer = document.getElementById("detail-customer-" + cusId);
                if (detailCustomer) {
                    detailCustomer.style.display = "block";
                }
            }

            // Khi click vào nút quay lại
            if (target.classList.contains("back-customer1")) {
                let cusId = target.getAttribute("data-id");

                // Hiện lại bảng danh sách khách hàng
                table.style.display = "table";

                // Ẩn phần chi tiết khách hàng
                let detailCustomer = document.getElementById("detail-customer-" + cusId);
                if (detailCustomer) {
                    detailCustomer.style.display = "none";
                }
            }
        });
    });


    // Thay đổi trạng thái
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("customer-status")) {
            let customerId = event.target.getAttribute("data-id");
            let newStatus = event.target.value;

            fetch("../PHP/CU-update_status.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${customerId}&status=${newStatus}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Trạng thái của khách hàng ${customerId} đã được cập nhật!`);
                    } else {
                        alert("Lỗi khi cập nhật trạng thái: " + data.message);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
        }
    });



    // Hiển thị lịch sử đơn hàng
    document.addEventListener("DOMContentLoaded", function () {
        let table = document.querySelector(".customer-table");
        const historyContainer = document.querySelector(".history-order-container");

        document.addEventListener("click", function (event) {
            let target = event.target;

            // Click vào biểu tượng xem lịch sử
            if (target.classList.contains("history-order")) {
                let cusId = target.closest("tr").getAttribute("data-id");

                // Ẩn bảng danh sách
                table.style.display = "none";

                // Gửi AJAX để lấy lịch sử đơn hàng
                fetch("../PHP/CU-get_order_history.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${cusId}`
                })
                .then(response => response.text())
                .then(html => {
                    historyContainer.innerHTML = html;
                    historyContainer.style.display = "block";
                })
                .catch(error => console.error("Lỗi khi tải lịch sử:", error));
            }

            // Click vào nút quay lại trong lịch sử
            if (target.classList.contains("back-customer2")) {
                historyContainer.style.display = "none";
                table.style.display = "table";
            }
        });
    });


</script>