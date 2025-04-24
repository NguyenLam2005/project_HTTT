    //Lựa chọn thống kê
    document.addEventListener("DOMContentLoaded", function () {
        const selectElement = document.getElementById("statistic-choice");
        const customerDiv = document.getElementById("statistic-customer");
        const productDiv = document.getElementById("statistic-product");
      
        selectElement.addEventListener("change", function () {
          const value = this.value;
      
          // Ẩn hết trước
          customerDiv.style.display = "none";
          productDiv.style.display = "none";
      
          // Hiện theo lựa chọn
          if (value === "1") {
            customerDiv.style.display = "block";
          } else if (value === "2") {
            productDiv.style.display = "block";
          } 
        });
      });    
    
    // Thống kê khách hàng
    const filterFormCustomer = document.getElementById("filter-form-customer");
    const tableBodyCustomer = document.querySelector(".statistic-customer-table tbody");

    filterFormCustomer.addEventListener("submit", function (event) {
        event.preventDefault();

        const startDate = document.getElementById("statistic-start-date-customer").value;
        const endDate = document.getElementById("statistic-end-date-customer").value;
        const count = document.getElementById("customer-number").value;
        const sort_statistic = document.getElementById("statistic-sort-customer").value;
        
        const formData = new URLSearchParams();
        formData.append("start_date", startDate);
        formData.append("end_date", endDate);
        formData.append("sort", sort_statistic);
        formData.append("count", count);

        fetch("/project_HTTT/Html/PHP/ST-customer_Manager.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData.toString()
        })
        .then(response => response.text())
        .then(html => {
            tableBodyCustomer.innerHTML = html;
        })
        .catch(error => console.error("Lỗi thống kê:", error));
    });

    // Thống kê sản phẩm
    const filterFormProduct = document.getElementById("filter-form-product");
    const tableBodyProduct = document.querySelector(".statistic-product-table tbody");

    filterFormProduct.addEventListener("submit", function (event) {
        event.preventDefault();

        const startDate = document.getElementById("statistic-start-date-product").value;
        const endDate = document.getElementById("statistic-end-date-product").value;
        const count = document.getElementById("product-number").value;
        const sort_statistic = document.getElementById("statistic-sort-product").value;
        
        const formData = new URLSearchParams();
        formData.append("start_date", startDate);
        formData.append("end_date", endDate);
        formData.append("sort", sort_statistic);
        formData.append("count", count);

        fetch("/project_HTTT/Html/PHP/ST-product_Manager.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData.toString()
        })
        .then(response => response.text())
        .then(html => {
            tableBodyProduct.innerHTML = html;
        })
        .catch(error => console.error("Lỗi thống kê:", error));
    });

    // Hiện chi tiết đơn hàng khi click vào link, clone bên đơn hàng qua
    document.addEventListener("DOMContentLoaded", function () {
        const filterForm1 = document.getElementById("filter-form-customer");
        const detailContainer = document.querySelector(".order-detail-container1");
        const table = document.querySelector(".statistic-customer-table");

        document.addEventListener("click", function (event) {
            let target = event.target;

            // Hiển thị danh sách đơn hàng
            if (target.classList.contains("order-toggle")) {
                const cusId = target.getAttribute("data-id");
                const detailDiv = document.getElementById("orders-" + cusId);
                const isCurrentlyVisible = detailDiv && detailDiv.style.display === "block";
            
                document.querySelectorAll(".order-detail-div").forEach(div => {
                    div.style.display = "none";
                });
            
                if (!isCurrentlyVisible && detailDiv) {
                    detailDiv.style.display = "block";
                }
            }
            
            // Hiển thị chi tiết đơn hàng
            if (target.classList.contains("order-info")) {
                const orderId = target.getAttribute("data-id");

                table.style.display = "none";
                filterForm1.style.display = "none";

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
                })
                .catch(error => console.error("Lỗi khi tải chi tiết đơn hàng:", error));
            }

            // Quay lại từ chi tiết đơn hàng
            if (target.classList.contains("back-orderdetail")) {
                detailContainer.style.display = "none";
                table.style.display = "table";
                filterForm1.style.display = "flex";
                
                // Ẩn tất cả các danh sách đơn hàng
                document.querySelectorAll(".order-detail-div").forEach(div => {
                    div.style.display = "none";
                });
            }
        });
    });