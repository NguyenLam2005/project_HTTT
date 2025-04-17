    // Lọc đơn hàng theo trạng thái
    document.addEventListener("DOMContentLoaded", function () {
        const filterForm = document.getElementById("filter-form-order");
        const filterSelect = document.getElementById("filter-status");
        const tableBody = document.querySelector(".order-table tbody");
    
        filterForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Ngăn reload trang
    
            const selectedStatus = filterSelect.value;
    
            fetch("../../PHP/OD-Manager.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `status=${selectedStatus}`
            })
            .then(response => response.text())
            .then(html => {
                tableBody.innerHTML = html;
                updateStatusColorEffect(); // cập nhật màu trạng thái
            })
            .catch(error => console.error("Lỗi lọc đơn hàng:", error));
        });
    });
    

    function updateStatusColorEffect() { //Lấy đúng màu trạng thái khi lọc
        const statusElements = document.querySelectorAll(".order-status");
        statusElements.forEach(select => {
            select.addEventListener("change", ChangeStatus);
            ChangeStatus({ target: select });
        });
    }

    // Dùng ajax xem chi tiết theo từng đơn hàng
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector(".order-table");
        const detailContainer = document.querySelector(".order-detail-container");

        document.addEventListener("click", function (event) {
            let target = event.target;

            if (target.classList.contains("order-detail")) {
                const orderId = target.getAttribute("data-id");

                table.style.display = "none";

                fetch("../../PHP/OD-get_order_detail.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${orderId}`
                })
                .then(response => response.text())
                .then(html => {
                    detailContainer.innerHTML = html;
                    detailContainer.style.display = "block";
                })
                .catch(error => console.error("Lỗi khi tải chi tiết đơn hàng:", error));
            }

            if (target.classList.contains("back-orderdetail")) {
                    detailContainer.style.display = "none";
                    table.style.display = "table";
                }
        });
    });

    // Thay đổi trạng thái
    document.addEventListener("DOMContentLoaded", function () {
        document.addEventListener("change", function (event) {
            if (event.target.classList.contains("order-status")) {
                let orderId = event.target.getAttribute("data-id");
                let newStatus = event.target.value;
    
                fetch("../../PHP/OD-update_status.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${orderId}&status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Lấy trạng thái hiện tại khi đang lọc
                        alert(`Trạng thái của đơn hàng ${orderId} đã được cập nhật!`);
                        const currentFilter = document.getElementById("filter-status").value;
    
                        // Nếu trạng thái có thay đổi thì refetch lại bảng
                        if (currentFilter !== "0") {
                            fetch("../../PHP/OD-Manager.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: `status=${currentFilter}`
                            })
                            .then(response => response.text())
                            .then(html => {
                                const tableBody = document.querySelector(".order-table tbody");
                                tableBody.innerHTML = html;
                                updateStatusColorEffect();
                            });
                        } else {
                            alert(`Trạng thái của đơn hàng ${orderId} đã được cập nhật!`);
                        }
                    } else {
                        alert("Lỗi khi cập nhật trạng thái: " + data.message);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
            }
        });
    
        // Gán màu trạng thái ban đầu
        const statusElements = document.querySelectorAll(".order-status");
        statusElements.forEach(select => {
            select.addEventListener("change", ChangeStatus);
            ChangeStatus({ target: select });
        });
    });
    

    //Màu của select trạng thái
    function ChangeStatus(event) {
        let select = event.target;
        let value = select.value;
        switch (value) {
            case "1": 
                select.style.boxShadow = "0 0 5px 1px #ff9800 ";
                break;
            case "2":
                select.style.boxShadow = "0 0 5px 1px #90EE90 ";
                break;
            case "3": 
                select.style.boxShadow = "0 0 5px 1px #2196f3 ";
                break;
            case "4": 
                select.style.boxShadow = "0 0 5px 1px #006400 ";
                break;
            case "5": 
                select.style.boxShadow = "0 0 5px 1px #f44336 ";
                break;
            default:
                select.style.boxShadow = "none";
        }
    }


