<?php
require_once __DIR__ . '/../database.php';  


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if($action === 'loadBrandSearch'){
        $sql = "SELECT * FROM brand";
        $stmt =  $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $html = '<div class="name_thuoc_tinh">Thương hiệu</div>';
        if ($result->num_rows > 0) {
            while ($brand = $result->fetch_assoc()) {
                $html .= '<div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="brand" value="'.htmlspecialchars($brand['id']).'" id="thuonghieu'.htmlspecialchars($brand['id']).'">
                            <label for="thuonghieu'.htmlspecialchars($brand['id']).'">'.htmlspecialchars($brand['name']).'</label>
                        </div>';
            }
        }
        else{
            $htmt .='<div>Lỗi/div>';
        }

        echo($html);
    }

    if($action === 'loadGenderSearch'){
        $sql = "SELECT * FROM genders";
        $stmt =  $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $html = '<div class="name_thuoc_tinh">Giới tính</div>';
        if ($result->num_rows > 0) {
            while ($gender = $result->fetch_assoc()) {
                $html .= '<div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="gender" value="'.htmlspecialchars($gender['id']).'" id="gioitinh'.htmlspecialchars($gender['id']).'">
                            <label for="gioitinh'.htmlspecialchars($gender['id']).'">'.htmlspecialchars($gender['name']).'</label>
                        </div>';
            }
        }
        else{
            $htmt .='<div>Lỗi/div>';
        }

        echo($html);
    }

    if($action === 'loadCategorySearch'){
        $sql = "SELECT * FROM categories";
        $stmt =  $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $html = '<div class="name_thuoc_tinh">Loại đồng hồ</div>';
        if ($result->num_rows > 0) {
            while ($cate = $result->fetch_assoc()) {
                $html .= '<div class="filter__pair">
                            <input type="checkbox" class="item_filter_search" data-type="category" value="'.htmlspecialchars($cate['id']).'" id="loai'.htmlspecialchars($cate['id']).'">
                            <label for="loai'.htmlspecialchars($cate['id']).'">'.htmlspecialchars($cate['name']).'</label>
                        </div>';
            }
        }
        else{
            $htmt .='<div>Lỗi/div>';
        }

        echo($html);
    }

   
    if ($action === 'searchProduct') {
        // Lấy dữ liệu từ form
        $keyword = $_POST['keyword'] ?? '';
        $startPrice = $_POST['startPrice'] ?? '';
        $endPrice = $_POST['endPrice'] ?? '';
        $brandFilter = $_POST['brands'] ?? [];
        $categoryFilter = $_POST['categories'] ?? [];
        $genderFilter = $_POST['genders'] ?? [];

        // Khởi tạo câu truy vấn cơ bản
        $sql = "SELECT * FROM products WHERE quantity > 0";
        
        // Biến lưu trữ các tham số cho bind_param
        $params = [];
        $types = "";  // Loại kiểu dữ liệu tham số, ví dụ: 's' cho chuỗi, 'd' cho số thực

        // Thêm điều kiện tìm kiếm theo từ khóa (nếu có)
        if (!empty($keyword)) {
            $sql .= " AND name LIKE ?";
            $params[] = "%" . $keyword . "%";
            $types .= "s";  // 's' cho chuỗi
        }

        // Thêm điều kiện lọc theo giá (nếu có)
        if (!empty($startPrice) && is_numeric($startPrice)) {
            $sql .= " AND price >= ?";
            $params[] = $startPrice;
            $types .= "d";  // 'd' cho số thực
        }
        if (!empty($endPrice) && is_numeric($endPrice)) {
            $sql .= " AND price <= ?";
            $params[] = $endPrice;
            $types .= "d";  // 'd' cho số thực
        }

        // Thêm điều kiện lọc theo thương hiệu (nếu có)
        if (!empty($brandFilter)) {
            $brandIds = implode(',', array_map('intval', $brandFilter));
            $sql .= " AND brand_id IN ($brandIds)";
        }

        // Thêm điều kiện lọc theo loại đồng hồ (nếu có)
        if (!empty($categoryFilter)) {
            $categoryIds = implode(',', array_map('intval', $categoryFilter));
            $sql .= " AND category_id IN ($categoryIds)";
        }

        // Thêm điều kiện lọc theo giới tính (nếu có)
        if (!empty($genderFilter)) {
            $genderIds = implode(',', array_map('intval', $genderFilter));
            $sql .= " AND gender_id IN ($genderIds)";
        }
        // Chuẩn bị câu truy vấn
        $stmt = $conn->prepare($sql);

        // Kiểm tra nếu có tham số và bind tham số vào câu truy vấn
        if (!empty($types)) {
            // Bind các tham số vào câu truy vấn
            $stmt->bind_param($types, ...$params);
        }

        // Thực thi câu truy vấn
        $stmt->execute();
        $result = $stmt->get_result();

        // Trả về kết quả tìm kiếm
        if ($result->num_rows > 0) {
            while ($product = $result->fetch_assoc()) {
                // Hiển thị sản phẩm
                echo '<div class="product__search_item" data-id="' . $product['id'] . '">
                        <div class="search__product__img"><img src="' . $product['image'] . '" alt=""></div>
                        <div class="search__product__infor">
                            <h3 class="s-product__name">' . htmlspecialchars($product['name']) . '</h3>
                            <h3 class="s-product__price">' . number_format($product['price'], 0, ',', '.') . ' VND</h3>
                        </div>
                    </div>';
            }
        } else {
            echo '<div>Không có sản phẩm nào phù hợp.</div>';
        }
    }
}
?>

    
    


