<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';
header('Content-Type: application/json');
$response = [];

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Phương thức không hợp lệ");
    }

    if (!$conn) {
        throw new Exception("Không thể kết nối database");
    }

    $name = trim($_POST['product-name'] ?? '');
    $category_id = $_POST['category_id'] ?? null;
    $subcategory_id = $_POST['subcategory_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $image = $_FILES['product-image'] ?? null;

    // Validation
    if (empty($name)) {
        throw new Exception("Vui lòng nhập tên sản phẩm!");
    }

    if (strlen($name) > 100) {
        throw new Exception("Tên sản phẩm quá dài (tối đa 100 ký tự)");
    }

    if (!$category_id) {
        throw new Exception("Vui lòng chọn danh mục!");
    }

    if (!$subcategory_id) {
        throw new Exception("Vui lòng chọn danh mục con!");
    }

    if ($quantity < 0) {
        throw new Exception("Số lượng không hợp lệ!");
    }

    if ($price <= 0) {
        throw new Exception("Giá sản phẩm không hợp lệ!");
    }

    if (!$image || $image['error'] != 0) {
        throw new Exception("Vui lòng chọn ảnh sản phẩm!");
    }

    // Kiểm tra định dạng ảnh
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowed_types)) {
        throw new Exception("Định dạng ảnh không hợp lệ. Chỉ chấp nhận JPG, PNG, GIF");
    }

    // Kiểm tra kích thước ảnh (tối đa 5MB)
    if ($image['size'] > 5 * 1024 * 1024) {
        throw new Exception("Kích thước ảnh quá lớn (tối đa 5MB)");
    }

    // Upload ảnh
    $upload_dir = '../assest/product/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $file_name = uniqid() . '.' . $file_extension;
    $target_path = $upload_dir . $file_name;

    if (!move_uploaded_file($image['tmp_name'], $target_path)) {
        throw new Exception("Không thể upload ảnh!");
    }

    // Lấy tên danh mục và danh mục con
    $stmt = $conn->prepare("SELECT c.name as category_name, s.name as subcategory_name 
                           FROM categories c 
                           JOIN subcategories s ON c.id = s.category_id 
                           WHERE c.id = ? AND s.id = ?");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $stmt->bind_param("ii", $category_id, $subcategory_id);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh SQL");
    }

    $result = $stmt->get_result();
    if (!$row = $result->fetch_assoc()) {
        throw new Exception("Danh mục không hợp lệ!");
    }
    $stmt->close();

    // Thêm sản phẩm vào database
    $stmt = $conn->prepare("INSERT INTO products (pd_name, category_id, subcategory_id, quantity, price, image) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
    }

    $image_path = 'assest/product/' . $file_name;
    $stmt->bind_param("siiids", $name, $category_id, $subcategory_id, $quantity, $price, $image_path);
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thêm sản phẩm: " . $conn->error);
    }

    $response = [
        "success" => true,
        "message" => "Thêm sản phẩm thành công!",
        "product" => [
            "id" => $conn->insert_id,
            "name" => $name,
            "category_name" => $row['category_name'],
            "subcategory_name" => $row['subcategory_name'],
            "quantity" => $quantity,
            "price" => $price,
            "image" => $image_path
        ]
    ];

} catch (Exception $e) {
    $response = [
        "success" => false,
        "message" => $e->getMessage()
    ];
} finally {
    if (isset($conn)) {
        $conn->close();
    }
    echo json_encode($response);
    exit();
}
?>