document.addEventListener("DOMContentLoaded", function () {
    fetch("/project_HTTT/Html/PHP/bussiness-process.php")
        .then(response => response.json())
        .then(data => {
            document.querySelector(".order-count").textContent = data.totalOrders + " đơn";
            document.querySelector(".revenue + p").textContent = data.totalRevenue;
            document.querySelector(".profit").textContent = data.totalProfit;
        })
        .catch(error => {
            console.error("Lỗi khi tải dữ liệu thống kê:", error);
        });
});