    // Thống kê
    const filterFormST = document.getElementById("filter-form-statistic");
    const tableBodyST = document.querySelector(".statistic-table tbody");

    filterFormST.addEventListener("submit", function (event) {
        event.preventDefault();

        const title = document.querySelector(".statistic-title");
        const startDate = document.getElementById("statistic-start-date").value;
        const endDate = document.getElementById("statistic-end-date").value;
        const count = document.getElementById("customer-number").value;
        const sort_statistic = document.getElementById("statistic-sort").value;

        if (count) {
            title.innerText = `${count} khách hàng có tổng mua hàng cao nhất`;
            title.style.display = "block";
        } else {
            title.style.display = "none";
        }
        
        const formData = new URLSearchParams();
        formData.append("start_date", startDate);
        formData.append("end_date", endDate);
        formData.append("sort", sort_statistic);
        formData.append("count", count);

        fetch("../../PHP/ST-Manager.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData.toString()
        })
        .then(response => response.text())
        .then(html => {
            tableBodyST.innerHTML = html;
            updateStatusColorEffect();
        })
        .catch(error => console.error("Lỗi thống kê:", error));
    });

    // Hiện chi tiết đơn hàng khi click vào link, clone bên đơn hàng qua
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector(".statistic-table");
        const filterForm = document.getElementById("filter-form-statistic");
        const detailContainer = document.querySelector(".order-detail-container1");
        const title = document.querySelector(".statistic-title");

        document.addEventListener("click", function (event) {
            let target = event.target;

            if (target.classList.contains("order-info")) {
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
                    filterForm.style.display = "none";
                    title.style.display = "none";
                })
                .catch(error => console.error("Lỗi khi tải chi tiết đơn hàng:", error));
            }
            if (target.classList.contains("back-orderdetail")) {
                    detailContainer.style.display = "none";
                    table.style.display = "table";
                    filterForm.style.display = "flex";
                    title.style.display = "block";
                }
        });
    });