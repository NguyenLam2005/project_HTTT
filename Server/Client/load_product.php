<?php
include '../database.php';

$brand_id = $_POST['brand'] ?? '';
$gender_id = $_POST['gender'] ?? '';
$category_id = $_POST['category'] ?? '';
$sort = $_POST['sort'] ?? '';
$price = $_POST['gia'] ?? '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM products WHERE quantity > 0";
$params = [];
$types = "";



if($price !== ""){
    switch($price){
        case "1":
            $sql .= " AND price < 1000000";
            break;
        case "2":
            $sql .= " AND price >= 1000000 AND price < 2500000";
            break;
        case "3":
            $sql .= " AND price >= 2500000 AND price < 5000000";
            break;
        case "4":
            $sql .= " AND price >= 5000000 ";
            break;         
    }
}

if ($brand_id !== '') {
    $sql .= " AND brand_id = ?";
    $params[] = $brand_id;
    $types .= "i";
}
if ($gender_id !== '') {
    $sql .= " AND gender_id = ?";
    $params[] = $gender_id;
    $types .= "i";
}
if ($category_id !== '') {
    $sql .= " AND category_id = ?";
    $params[] = $category_id;
    $types .= "i";
}

// Sort
switch ($sort) {
    case "1":
        $sql .= " ORDER BY name ASC";
        break;
    case "2":
        $sql .= " ORDER BY price ASC";
        break;
    case "3":
        $sql .= " ORDER BY price DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
        break;
}

// Đếm tổng
$count_sql = "SELECT COUNT(*) as total FROM ($sql) AS temp";
$stmt = $conn->prepare($count_sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);
$stmt->close();

// Lấy sản phẩm phân trang
$sql .= " LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$product_html = '';

while ($row = $result->fetch_assoc()) {
    $product_html .= '
    <div class="product__card" data-id="' . $row['id'] . '">
        <img src="' . $row['image'] . '" alt="' . htmlspecialchars($row['name']) . '">
        <div class="product__card-content">
            <h3>' . htmlspecialchars($row['name']) . '</h3>
            <div class="price">' . number_format($row['price'], 0, ',', '.') . '₫</div>
        </div>
        <button class="product__card-add-btn" onclick ="addToCart(\'' . $row['id'] . '\')">Thêm sản phẩm</button>
    </div>';
}

if ($result->num_rows === 0) {
    $product_html = '<p class="no-products">Không có sản phẩm nào phù hợp.</p>';
}

$stmt->close();

// Phân trang
$pagination_html = '';
if ($totalPages > 1) {
    $pagination_html .= '<button class="prev-page">«</button>';
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = ($i == $page) ? 'active' : '';
        $pagination_html .= '<button class="page-num ' . $active . '">' . $i . '</button>';
    }
    $pagination_html .= '<button class="next-page">»</button>';
}

echo json_encode([
    'products' => $product_html,
    'pagination' => $pagination_html
]);
?>
