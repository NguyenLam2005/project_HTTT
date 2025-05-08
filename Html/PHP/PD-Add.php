<?php
include __DIR__ . '/config.php';

$response = []; // Mảng chứa phản hồi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product-name'] ?? null;
    $category_id = $_POST['product-category'] ?? null;
    $price = $_POST['product-price'] ?? null;
    $supplier_id = $_POST['product-supplier'] ?? null;
    $brand_id = $_POST['product-brand'] ?? null;
    $quantity = 0;

    $noneIMG = "/project_HTTT/Html/img/Default.jpg";

if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] == UPLOAD_ERR_OK) {
    $image = time() . "_" . basename($_FILES['product-image']['name']);
    $target_dir = __DIR__ . "/../img/product/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file_full = $target_dir . $image; // đường dẫn vật lý
    if (move_uploaded_file($_FILES['product-image']['tmp_name'], $target_file_full)) {
        $target_file = "/project_HTTT/Html/img/product/" . $image; // đường dẫn web
    } else {
        error_log("Lỗi không thể ghi file vào: " . $target_file_full);
        $target_file = $noneIMG;
    }
} else {
    $target_file = $noneIMG;
}


    $sql = "SELECT categories.name AS category_name
    FROM categories
    WHERE categories.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
    $category_name = $row["category_name"];
    }
    $stmt->close();

    $sql = "SELECT brand.name AS brand_name
    FROM brand
    WHERE brand.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
    $brand_name = $row["brand_name"];
    }
    $stmt->close();


    $sql = "INSERT INTO products (name,image,category_id, brand_id,quantity, supplier_id, price) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiiii", $name,$target_file,$category_id, $brand_id ,$quantity,$supplier_id ,$price);

    if ($stmt->execute()) {
        $response = [
            "success" => true,
            "message" => "Sản phẩm đã được thêm thành công!",
            "product" => [
                "id" => $conn->insert_id,
                "image" => $target_file,
                "name" => $name,
                "category_name" => $category_name,
                "category_id" => $category_id,
                "brand_name" => $brand_name,
                "brand_id" => $brand_id,
                "quantity" => $quantity,
                "price" => number_format($price, 0, ',', '.') . " VND"
            ]
        ];
    } else {
        $response = ["success" => false, "message" => "Lỗi: " . $stmt->error];
    }

    $stmt->close();

    // Đóng kết nối và trả kết quả JSON
    $conn->close();
    echo json_encode($response);
    exit();
}
?>