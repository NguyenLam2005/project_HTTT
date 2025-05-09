<?php
include '../database.php';

// Load dữ liệu
$brands = $conn->query("SELECT id, name FROM brand ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$genders = $conn->query("SELECT id, name FROM genders ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

// Tạo HTML
$navbarHTML = '';
$navbarHTML .= '<li class="nav-item active" id = "home_product"><a><i class="fa-solid fa-house-chimney"></i></a></li>';
// Thương hiệu
$navbarHTML .= '<li class="nav-item brand-item"><a>Thương hiệu</a><ul class="dropdown-brand">';
foreach ($brands as $brand) {
    $navbarHTML .= '<li class="brand-option" data-id="' . $brand['id'] . '">' . $brand['name'] . '</li>';
}
$navbarHTML .= '</ul></li>';

// Giới tính
foreach ($genders as $gender) {
    $navbarHTML .= '<li class="nav-item gender-item" data-id="'. $gender['id'] .'"><a>Đồng hồ '. $gender['name'] .'</a></li> ';
}

// Loại đồng hồ
$navbarHTML .= '<li class="nav-item" id = "news_watch"><a href="https://vnexpress.net/tag/dong-ho-257904">Tin tức</a></li>';

// Trả về dưới dạng JSON
$response = [
    'html' => $navbarHTML
];

header('Content-Type: application/json');
echo json_encode($response);
?>
