<?php
include __DIR__ . '/config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product-id'];
    $name = $_POST['product-name'];
    $price = $_POST['product-price'];
    $category_id = $_POST['product-category'];
    $supplier_id = $_POST['product-supplier'];
    $brand_id = $_POST['product-brand'];

    $noneIMG = "/project_HTTT/Html/img/Default.jpg";
    $target_file = $noneIMG;

    // Kiểm tra nếu có ảnh mới
    if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['product-image']['name'];
        $target_dir = realpath(__DIR__ . "/project_HTTT/Html/img/product") . "/";
        $target_file = $target_dir . basename($image);

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['product-image']['tmp_name'], $target_file)) {
            $target_file = "/project_HTTT/Html/img/product" . basename($image);
        } else {
            $response = ["success" => false, "message" => "Lỗi khi tải ảnh lên."];
            echo json_encode($response);
            exit();
        }
    } else {
        // Nếu không có ảnh mới, lấy ảnh cũ
        $sql = "SELECT image FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($old_image);
        $stmt->fetch();
        $target_file = $old_image;
        $stmt->close();
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

    $stmt = $conn->prepare("SELECT quantity FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($currentquantity);
    $stmt->fetch();
    $stmt->close();

    $sql = "UPDATE products SET name = ?, category_id = ?,brand_id = ?, price = ?, image = ?, supplier_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiisii", $name, $category_id, $brand_id, $price, $target_file,$supplier_id ,$id);

    
    if ($stmt->execute()) {
        $response = [
            "success" => true,
            "message" => "Sản phẩm đã được cập nhật thành công!",
            "product" => [
                "id" => $id,
                "image" => $target_file,
                "name" => $name,
                "category_name" => $category_name,
                "category_id" => $category_id,
                "brand_name" => $brand_name,
                "brand_id" => $brand_id,
                "quantity" => $currentquantity,
                "price" => number_format($price, 0, ',', '.') . " VND"
            ]
        ];
    } else {
        $response = ["success" => false, "message" => "Lỗi: " . $stmt->error];
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
