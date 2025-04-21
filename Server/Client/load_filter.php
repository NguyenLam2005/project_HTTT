<?php
include '../database.php';

// Load dữ liệu
$brands = $conn->query("SELECT id, name FROM brand ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$genders = $conn->query("SELECT id, name FROM genders ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
$categories =  $conn->query("SELECT id, name FROM categories ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

$filterHTML = '';
$filterHTML .= '
                <div class="filter__item">
                    <label for="muc_gia">Mức giá</label>
                    <select name="muc_gia" id="muc_gia">
                        <option value="">Tất cả</option>
                        <option value= "1" >Dưới 1.000.000VNĐ</option>
                        <option value= "2" >Từ 1.000.000VND đến 2.500.000VNĐ</option>
                        <option value= "3" >Từ 2.500.000VNĐ đến 5.000.000VNĐ</option>
                        <option value= "4" >Trên 5.000.000VNĐ</option>
                    </select>
                </div>
            ';
$filterHTML .= '
        <div class="filter__item">
                <label for="thuong_hieu">Thương hiệu</label>
                <select name="thuong_hieu" id="thuong_hieu">
                <option value="">Tất cả </option>
';

foreach($brands as $brand){
    $filterHTML .= '<option value="'. $brand['id'] .'">' .$brand['name'] . '</option>';
}

$filterHTML .= '</select>
                </div>';

$filterHTML .= '
    <div class="filter__item">
                    <label for="gioi_tinh">Giới tính</label>
                    <select name="gioi_tinh" id="gioi_tinh"> 
                    <option value="">Tất cả</option>
';

foreach($genders as $gender){
    $filterHTML .= '<option value="'. $gender['id'] .'">' .$gender['name'] . '</option>';
}

$filterHTML .= '</select>
                </div>';

$filterHTML .= '
    <div class="filter__item">
                    <label for="loai">Loại đồng hồ</label>
                    <select name="loai" id="loai">      
                    <option value="">Tất cả</option> 
';

foreach($categories as $category){
    $filterHTML .= '<option value="'. $category['id'] .'">' .$category['name'] . '</option>';
}

$filterHTML .= '</select>
                </div>';

$response = [
        'html' => $filterHTML
    ];

header('Content-Type: application/json');
echo json_encode($response);
?>