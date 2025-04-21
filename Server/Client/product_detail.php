<?php
include '../database.php';

$product_id = $_POST['product_id'] ?? 0;

$sql = "SELECT p.*, b.name AS brand_name, g.name AS gender_name, c.name AS category_name
        FROM products p
        JOIN brand b ON p.brand_id = b.id
        JOIN genders g ON p.gender_id = g.id
        JOIN categories c ON p.category_id = c.id
        WHERE p.id = ? AND p.quantity > 0";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if ($product):
?>
<div class="product__detail-card">
    <button  class ="exit_product_detail" id="exit_product_detail">X</button>
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    <p><strong>Thương hiệu:</strong> <?= htmlspecialchars($product['brand_name']) ?></p>
    <p><strong>Giới tính:</strong> <?= htmlspecialchars($product['gender_name']) ?></p>
    <p><strong>Loại:</strong> <?= htmlspecialchars($product['category_name']) ?></p>
    <p><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.') ?>₫</p>
    <p><strong>Số lượng:</strong> <?= $product['quantity'] ?></p>
    <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
</div>
<?php else: ?>
<div class="product__detail-card">
    <p>Sản phẩm không tồn tại hoặc đã hết hàng.</p>
</div>
<?php endif; ?>
