    // Lọc đơn hàng
    const filterForm = document.getElementById("filter-form-order");
    const tableBody = document.querySelector(".order-table tbody");

    filterForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const status = document.getElementById("filter-status").value;
        const province = document.getElementById("order-province").value;
        const district = document.getElementById("order-district").value;
        const startDate = document.getElementById("order-start-date").value;
        const endDate = document.getElementById("order-end-date").value;

        const formData = new URLSearchParams();
        formData.append("status", status);
        formData.append("province_id", province);
        formData.append("district_id", district);
        formData.append("start_date", startDate);
        formData.append("end_date", endDate);

        fetch("/project_HTTT/Html/PHP/OD-Manager.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData.toString()
        })
        .then(response => response.text())
        .then(html => {
            tableBody.innerHTML = html;
            updateStatusColorEffect();
        })
        .catch(error => console.error("Lỗi lọc đơn hàng:", error));
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
        const filterForm = document.getElementById("filter-form-order");
        const detailContainer = document.querySelector(".order-detail-container");

        document.addEventListener("click", function (event) {
            let target = event.target;

            if (target.classList.contains("order-detail")) {
                const orderId = target.getAttribute("data-id");

                table.style.display = "none";

                fetch("/project_HTTT/Html/PHP/OD-get_order_detail.php", {
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
                    filterForm.style.display = "none";
                })
                .catch(error => console.error("Lỗi khi tải chi tiết đơn hàng:", error));
            }

            if (target.classList.contains("back-orderdetail")) {
                    detailContainer.style.display = "none";
                    table.style.display = "table";
                    filterForm.style.display = "flex";
                }
        });
    });

    //Thay đổi trạng thái đơn hàng
    document.addEventListener("DOMContentLoaded", function () {
        document.addEventListener("change", function (event) {
            if (event.target.classList.contains("order-status")) {
                let orderId = event.target.getAttribute("data-id");
                let newStatus = event.target.value;
                let currentStatus = event.target.getAttribute("data-old");

            // Không thể chuyển trạng thái về trạng thái bé hơn và không thể chuyển từ "đã giao" sang "đã hủy"
            if ((parseInt(newStatus) < parseInt(currentStatus)) || ( parseInt(newStatus)==5 && parseInt(currentStatus)==4)) {
                alert("Không thể thay đổi trạng thái");
                event.target.value=currentStatus;
                updateStatusColor(); 
                return;
            }

                fetch("/project_HTTT/Html/PHP/OD-update_status.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${orderId}&status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const currentFilter = document.getElementById("filter-status").value;
    
                        if (currentFilter !== "0") {
                            fetch("../PHP/OD-Manager.php", {
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
                                updateStatusColor(); 
                            });
                        } else {
                            event.target.setAttribute("data-old", newStatus);
                            alert(`Trạng thái của đơn hàng ${orderId} đã được cập nhật!`);
                            updateStatusColor(); 
                        }
                    } else {
                        alert("Lỗi khi cập nhật trạng thái: " + data.message);
                    }
                })
                .catch(error => console.error("Lỗi:", error));
            }
        });
    
        // Gán màu trạng thái ban đầu khi load trang
        updateStatusColor();
    });
    

    function updateStatusColor() {
        const statusElements = document.querySelectorAll(".order-status");
        statusElements.forEach(select => {
            ChangeStatus({ target: select }); 
        });
    }

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


