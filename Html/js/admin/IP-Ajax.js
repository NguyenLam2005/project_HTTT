
// Lọc phiếu nhập theo ngày 
document.addEventListener("DOMContentLoaded", function () {
    let importFilterForm  = document.getElementById("filter-form-import");
    let tableBodyimport = document.querySelector("#import-table-body");
   
    console.log("Form:", importFilterForm);
    importFilterForm.addEventListener("submit", function (event) {
        event.preventDefault();
        let startDate = document.getElementById("import-start-date").value;
        let endDate = document.getElementById("import-end-date").value;
        
   
        let formData = new URLSearchParams();
        formData.append("start_date", startDate);
        formData.append("end_date", endDate);
   
        fetch("/project_HTTT/Html/PHP/IP-Manager.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData.toString()
        })
        .then(response => response.text())
        .then(html => {
           tableBodyimport.innerHTML = html;
        })
        .catch(error => console.error("Lỗi lọc sản phẩm:", error));
    });
   });


// Xử lý combobox nhập hàng
document.addEventListener('DOMContentLoaded', function() {
    const supplierSelect = document.getElementById('supplier-ip');
    const productTableBody = document.querySelector('.import-table-show tbody');
    let totalAmount = 0;

    // Load danh sách nhà cung cấp
    fetch('/project_HTTT/Html/PHP/IP-getSuppliers.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                data.suppliers.forEach(sup => {
                    supplierSelect.innerHTML += `<option value="${sup.id}">${sup.name}</option>`;
                });
            }
        });

    // Khi chọn nhà cung cấp
    supplierSelect.addEventListener('change', function() {
        const supplierId = this.value;
        productTableBody.innerHTML = '';
        if (supplierId) {
            fetch(`/project_HTTT/Html/PHP/IP-getProductsByCategoryAndSupplier.php?supplier_id=${supplierId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        data.products.forEach(product => {
                            const formattedPrice = parseFloat(product.price)
                            .toLocaleString('vi-VN', {
                                maximumFractionDigits: 0
                            }) + 'VNĐ';

                            // Thêm sản phẩm vào bảng
                            productTableBody.innerHTML += `
                                <tr data-product-id="${product.id}">
                                    <td>${product.name}</td>
                                    <td><img src="${product.image}" alt="" style="max-width:60px;max-height:60px;"></td>
                                    <td>${product.category_name}</td>
                                    <td>${formattedPrice}</td>
                                    <td>${product.quantity}</td>
                                </tr>
                            `;
                        });
                    }
                });
        }
    });

    // Xử lí chọn sản phẩm
    let selectedProduct = null;
    let selectedProductId = null;

    // Khi click vào row sản phẩm
    productTableBody.addEventListener('click', function(e) {
        let row = e.target.closest('tr');
        if (!row) return;
        // Lấy thông tin sản phẩm từ row
        const cells = row.children;
        const priceText = cells[3].textContent;
        const price = parseFloat(priceText.replace(/\D/g, '')); // Loại bỏ dấu phân cách và chuyển thành số
        selectedProduct = {
            name: cells[0].textContent,
            image: cells[1].querySelector('img').src,
            category: cells[2].textContent,
            price: price
        };
        // Lấy product_id 
        selectedProductId = row.getAttribute('data-product-id');
        // Đánh dấu row được chọn
        Array.from(productTableBody.children).forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');
        // Reset các input
        document.getElementById('quantity').value = '';
        document.getElementById('import-price').value = '';
        document.getElementById('profit-percent').value = '';
    });

    // Tính lãi
    const importPriceInput = document.getElementById('import-price');
    const profitPercent = document.getElementById('profit-percent');

    // Hàm lấy số nguyên thô từ chuỗi có định dạng tiền tệ
    function getRawPrice(value) {
        return parseFloat(value.replace(/\D/g, '')) || 0;
    }

    // Định dạng tiền khi người dùng nhập
    importPriceInput.addEventListener('input', function () {
        let raw = this.value.replace(/\D/g, '');
        if (!raw) {
            this.value = '';
            return;
        }
        this.value = Number(raw).toLocaleString('vi-VN') + ' VNĐ';
    });

    // Chọn toàn bộ khi click vào input để dễ sửa
    importPriceInput.addEventListener('focus', function () {
        setTimeout(() => {
            this.select();
        }, 0);
    });

    // Tính phần trăm lợi nhuận khi rời khỏi ô nhập
    importPriceInput.addEventListener('blur', function () {
        const importPrice = getRawPrice(this.value);
        if (selectedProduct && importPrice > 0) {
            if (importPrice > selectedProduct.price) {
                console.log(importPrice);
                console.log(selectedProduct.price);
                alert('Giá nhập không được lớn hơn giá bán!');
                setTimeout(() => {
                    this.focus();
                }, 0);
                return;
            }
            const percent = ((selectedProduct.price - importPrice) / importPrice) * 100;
            profitPercent.value = percent.toFixed(2);
        } else {
            profitPercent.value = '';
        }
    });

    

    // Khi click nút thêm sản phẩm
    document.getElementById('add-product-btn-ip').addEventListener('click', function(e) {
        e.preventDefault();
        if (!selectedProduct) {
            alert('Vui lòng chọn sản phẩm!');
            return;
        }
        const quantity = document.getElementById('quantity').value;
        const importPrice = document.getElementById('import-price').value;
        const profitPercent = document.getElementById('profit-percent').value;
        if (!quantity || !importPrice) {
            alert('Vui lòng nhập đủ số lượng và giá nhập!');
            return;
        }
        // Tính thành tiền
        const total = (parseFloat(importPrice) * parseInt(quantity)).toFixed(0);
        totalAmount = totalAmount + parseFloat(total);

        // Thêm vào bảng sản phẩm trong phiếu nhập
        const importListBody = document.querySelector('.imported-product-list-section tbody');
        const newRow = document.createElement('tr');
        newRow.setAttribute('data-product-id', selectedProductId);
        newRow.innerHTML = `
            <td>${selectedProduct.name}</td>
            <td>${quantity}</td>
            <td>${importPrice}</td>
            <td>${profitPercent}%</td>
            <td>${total}</td>
            <td style='text-align: center; vertical-align: middle;'><i class='fa-solid fa-trash' style='cursor:pointer'></i></td>
        `;
        document.getElementById('total-price-ip').textContent = totalAmount.toLocaleString('vi-VN') + ' VND';
        importListBody.appendChild(newRow);
        // Reset chọn sản phẩm và input
        Array.from(productTableBody.children).forEach(r => r.classList.remove('selected'));
        selectedProduct = null;
        selectedProductId = null;
        document.getElementById('quantity').value = '';
        document.getElementById('import-price').value = '';
        document.getElementById('profit-percent').value = '';
    });

    // Xử lý xóa sản phẩm khỏi bảng sản phẩm trong phiếu
    document.querySelector('.imported-product-list-section tbody').addEventListener('click', function(e) {
        if (e.target.classList.contains('fa-trash')) {
            const row = e.target.closest('tr');
            if (row) {
                const totalCell = row.querySelector('td:nth-child(5)');
                if (totalCell) {
                    totalAmount -= parseFloat(totalCell.textContent);
                    document.getElementById('total-price-ip').textContent = totalAmount.toLocaleString('vi-VN') + ' VND';
                }
                row.remove();
            }
        }
    });

    // Khi click nút 'Thêm phiếu nhập'
    document.getElementById('submit-import-btn').addEventListener('click', function(e) {
        e.preventDefault();
        // Lấy employee_id từ session
        const employee_id = window.adminInfo?.userName;
        if (!employee_id) {
            alert('Vui lòng đăng nhập lại!');
            return;
        }

        const supplier_id = supplierSelect.value;
        const importListBody = document.querySelector('.imported-product-list-section tbody');
        const rows = importListBody.querySelectorAll('tr');

        // Kiểm tra dữ liệu đầu vào
        if (!supplier_id || rows.length === 0) {
            alert('Vui lòng chọn nhà cung cấp và thêm ít nhất một sản phẩm!');
            return;
        }

        // Lấy danh sách sản phẩm và kiểm tra dữ liệu
        const products = [];
        let hasError = false;

        rows.forEach(row => {
            const tds = row.querySelectorAll('td');
            const product_id = row.getAttribute('data-product-id');
            const quantity = parseInt(tds[1].textContent);
            const import_price = parseFloat(tds[2].textContent);

            // Kiểm tra số lượng và giá nhập
            if (isNaN(quantity) || quantity <= 0) {
                alert('Số lượng phải lớn hơn 0!');
                hasError = true;
                return;
            }

            if (isNaN(import_price) || import_price <= 0) {
                alert('Giá nhập phải lớn hơn 0!');
                hasError = true;
                return;
            }

            products.push({ 
                product_id, 
                quantity, 
                import_price 
            });
        });

        if (hasError) return;

        // Gửi AJAX
        fetch('/project_HTTT/Html/PHP/IP-Add.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                employee_id, 
                supplier_id, 
                products 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Thêm dòng mới vào bảng import-table
                const importTableBody = document.getElementById('import-table-body');
                const currentRowCount = importTableBody.querySelectorAll('tr').length;
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', data.import.id);
                newRow.innerHTML = `
                    <td>${currentRowCount + 1}</td>
                    <td>${data.import.id}</td>
                    <td>${data.import.employee_id}</td>
                    <td>${data.import.importDate}</td>
                    <td><select class='import-status' data-id='${data.import.id}' data-current-status='1'>
                        <option value='1' selected>Chưa duyệt</option>
                        <option value='2'>Đã duyệt</option>
                    </select></td>
                    <td style='text-align: center; vertical-align: middle;'>
                          <i class='fa-solid fa-circle-info import-detail' data-id='${data.import.id}' style='cursor:pointer'></i>
                    </td>
                    <td>
                       <div class='fix-import' style='justify-content: center;'>
                            <i class='fa-solid fa-trash delete-btn-import' style='cursor:pointer'></i>
                       </div>
                    </td>
                `;
                // Thêm vào cuối bảng thay vì đầu bảng
                importTableBody.appendChild(newRow);
                setImportStatusColor(newRow.querySelector('.import-status'));
                
                // Xử lí việc xóa phiếu đuoc ngay sau khi thêm
                newRow.querySelector('.delete-btn-import').addEventListener('click', function() {
                    const row = this.closest('tr');
                    const importId = row.getAttribute('data-id');
                    
                    document.getElementById('delete-overlay-import').style.display = 'block';
                    
                    document.getElementById('delete-acp-import').onclick = function() {
                        fetch('/project_HTTT/Html/PHP/IP-Delete.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `id=${importId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Xóa row khỏi bảng
                                row.remove();
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                            // Ẩn overlay
                            document.getElementById('delete-overlay-import').style.display = 'none';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi xóa phiếu nhập!');
                            document.getElementById('delete-overlay-import').style.display = 'none';
                        });
                    };
                    
                    // Xử lý khi click nút hủy
                    document.getElementById('cancel-import').onclick = function() {
                        document.getElementById('delete-overlay-import').style.display = 'none';
                    };
                });

                // Reset bảng sản phẩm trong phiếu nhập
                importListBody.innerHTML = '';
                // Reset combobox và tổng tiền
                supplierSelect.value = '';
                productTableBody.innerHTML = '';
                totalAmount = 0;
                document.getElementById('total-price-ip').textContent = '0 VND';
                alert('Thêm phiếu nhập thành công!');
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Lỗi:', err);
            alert('Có lỗi xảy ra khi kết nối server!');
        });
    });

    // Hàm set màu viền cho trạng thái phiếu nhập
    function setImportStatusColor(select) {
        if (select.value == "2") {
            select.style.boxShadow = "0 0 5px 1px rgb(47, 218, 70)";
        } else {
            select.style.boxShadow = "0 0 5px 1px #ff9800";
        }
    }
    // Áp dụng cho tất cả combobox trạng thái phiếu nhập khi trang load
    document.querySelectorAll('.import-status').forEach(setImportStatusColor);
});

// Hiển thị chi tiết phiếu nhập
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('import-detail')) {
        const importId = e.target.getAttribute('data-id');
        
        document.querySelector('.import-table').style.display = 'none';
        
        const detailContainer = document.querySelector('.import-detail-container');
        detailContainer.style.display = 'block';
        
        // Lấy thông tin chi tiết từ server
        fetch(`/project_HTTT/Html/PHP/IP-getImportDetail.php?id=${importId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const importInfo = data.import;
                    const infoRows = detailContainer.querySelectorAll('.info-row-ip');
                    
                    infoRows[0].innerHTML = `
                        <span><strong>Mã phiếu nhập:</strong> ${importInfo.id}</span>
                        <span><strong>Mã nhân viên:</strong> ${importInfo.employee_id}</span>
                    `;
                    
                    infoRows[1].innerHTML = `
                        <span><strong>Ngày nhập:</strong> ${importInfo.importDate}</span>
                        <span><strong>Trạng thái:</strong> ${importInfo.status == 1 ? 'Chưa duyệt' : 'Đã duyệt'}</span>
                    `;
                    
                    infoRows[2].innerHTML = `
                        <span><strong>Tổng tiền:</strong> ${importInfo.total_amount.toLocaleString('vi-VN')} VNĐ</span>
                    `;
                    
                    const tbody = detailContainer.querySelector('.imported-product-list-section table tbody');
                    tbody.innerHTML = '';
                    
                    // Chỉ hiển thị sản phẩm của phiếu nhập hiện tại
                    if (data.details && data.details.length > 0) {
                        data.details.forEach(detail => {
                            const profitPercent = ((detail.product_price - detail.unitPrice) / detail.unitPrice * 100).toFixed(2);
                            tbody.innerHTML += `
                                <tr>
                                    <td>${detail.product_name}</td>
                                    <td>${detail.quantity}</td>
                                    <td>${detail.unitPrice.toLocaleString('vi-VN')}VNĐ</td>
                                    <td>${profitPercent}%</td>
                                    <td>${detail.subtotal.toLocaleString('vi-VN')}VNĐ</td>
                                </tr>
                            `;
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Không có sản phẩm nào</td></tr>';
                    }
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(err => {
                console.error('Lỗi:', err);
                alert('Có lỗi xảy ra khi lấy thông tin chi tiết!');
            });
    }
});

// Thay đổi trạng thái phiếu nhập bằng AJAX
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('import-status')) {
        const select = e.target;
        const importId = select.getAttribute('data-id');
        const newStatus = select.value;
        // Nếu trạng thái hiện tại là Đã duyệt thì không cho chuyển về Chưa duyệt
        if (select.getAttribute('data-current-status') === '2' && newStatus === '1') {
            select.value = '2';
            alert('Không thể thay đổi trạng thái!');
            return;
        }
        fetch('/project_HTTT/Html/PHP/IP-update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `import_id=${encodeURIComponent(importId)}&status=${encodeURIComponent(newStatus)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                select.style.boxShadow = newStatus == "2"
                    ? "0 0 5px 1px rgb(47, 218, 70)"
                    : "0 0 5px 1px #ff9800";
                // Cập nhật lại data-current-status
                select.setAttribute('data-current-status', newStatus);
                alert('Cập nhật trạng thái thành công!');
            } else {
                alert(data.message || 'Cập nhật trạng thái thất bại!');
            }
        })
        .catch(() => {
            alert('Có lỗi khi kết nối server!');
        });
    }
});

// Xóa phiếu nhập
document.querySelectorAll('.delete-btn-import').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        const importId = row.getAttribute('data-id');
        
        document.getElementById('delete-overlay-import').style.display = 'block';
        
        document.getElementById('delete-acp-import').onclick = function() {
            fetch('/project_HTTT/Html/PHP/IP-Delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${importId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Xóa row khỏi bảng
                    row.remove();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
                // Ẩn overlay
                document.getElementById('delete-overlay-import').style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa phiếu nhập!');
                document.getElementById('delete-overlay-import').style.display = 'none';
            });
        };
        
        // Xử lý khi click nút hủy
        document.getElementById('cancel-import').onclick = function() {
            document.getElementById('delete-overlay-import').style.display = 'none';
        };
    });
});

