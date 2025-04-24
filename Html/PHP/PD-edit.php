<?php
include __DIR__ . '/config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product-id'];
    $name = $_POST['product-name'];
    $quantity = $_POST['product-quantity'];
    $price = $_POST['product-price'];
    $category_id = $_POST['product-category'];

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

    $sql = "UPDATE products SET name = ?, category_id = ?, quantity = ?, price = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siidsi", $name, $category_id, $quantity, $price, $target_file, $id);

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
                "quantity" => $quantity,
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
