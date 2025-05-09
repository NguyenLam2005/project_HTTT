<?php include '../../Layout/Client/headpage.php'; ?>
<?php include '../../Layout/Client/header.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HighTech</title>

    <!-- Thư viện -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="http://localhost/project_HTTT/Js/Client/cart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../../Css/base.css">
    <link rel="stylesheet" href="../../Css/Client/payment.css">
    <link rel="stylesheet" href="../../Css/Client/headpages.css">
    <link rel="stylesheet" href="../../Css/Client/navbar.css">
    <link rel="stylesheet" href="../../Css/Client/footer.css">
    <link rel="stylesheet" href="../../Css/Client/loginCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/product_detail.css">
    <link rel="stylesheet" href="../../Css/Client/registerCustomer.css">
    <link rel="stylesheet" href="../../Css/Client/cart.css">
    <link rel="stylesheet" href="../../Css/Client/customerInfo.css">
</head>
    <?php
    include("../../Server/database.php");

    // Lấy ID sản phẩm từ URL (ví dụ: ?id=25)
    $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($product_id <= 0) {
        die("Sản phẩm không hợp lệ.");
    }

    // Truy vấn lấy thông tin sản phẩm (có thể thêm điều kiện status nếu cần)
    $sql = "SELECT * FROM products WHERE id = $product_id LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        die("Sản phẩm không tồn tại.");
    }
    $product = $result->fetch_assoc();
    $brand_id = $product['brand_id'];
    $category_id = $product['category_id'];
    $gender_id = $product['gender_id'];

    $sql2 = "SELECT * FROM brand WHERE id = $brand_id";
    $result2 = $conn->query($sql2);
    $brand = $result2->fetch_assoc();

    $sql3 = "SELECT * FROM categories WHERE id = $category_id";
    $result3 = $conn->query($sql3);
    $category = $result3->fetch_assoc();

    $sql4 = "SELECT * FROM genders WHERE id = $gender_id";
    $result4 = $conn->query($sql4);
    $gender = $result4->fetch_assoc();


    ?>
<div class = "product_detail_wrapper">
    <div class = "product_detail_container">
    <div class = "back__home" id = "back_home"><i class="fa-solid fa-arrow-left"></i></div>
            <div class = "product_detail_img">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product_detail_content">
                <div class = "product_detail_infor">
                    <h1 class = "product_detail_name"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class = "product_detail_price">Giá: <span><?php echo number_format($product['price'], 0, ',', '.') . 'VNĐ'; ?></span></p>
                    <p class = "product_detail_gender">Đồng hồ: <?php echo htmlspecialchars($gender['name']); ?></p>
                    <p class = "product_detail_brand">Hãng sản xuất: <?php echo htmlspecialchars($brand['name']); ?></p>
                    <p class = "product_detail_category">Loại sản phẩm: <?php echo htmlspecialchars($category['name']); ?></p>
                    <p class = "product_detail_description">Mô tả: <br> <?php echo htmlspecialchars($product['description']); ?></p>
                </div>
                <div class = "product_detail_infor_footer">
                    <div class="add_to_cart_from_detail" onclick="addToCart(<?php echo $product['id']; ?>)">Thêm vào giỏ hàng</div>
                    <div class = "pay_from_detail" onclick="addToCartAndPaying(<?php echo $product['id']; ?>)">Thanh toán</div>
                </div>
            </div>
            
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#back_home').click(function() {
                window.history.back();
            });
        });
    </script>


<?php include '../../Layout/Client/footer.php'; ?>