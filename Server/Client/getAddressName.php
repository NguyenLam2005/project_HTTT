<?php
require_once __DIR__ . '/../database.php';  

$provinceId = $_POST['province'];
$districtId = $_POST['district'];

// Truy vấn tên tỉnh/thành phố
$sql = "SELECT 
            p.name AS province_name, 
            d.name AS district_name 
        FROM districts d
        JOIN provinces p ON d.province_id = p.id
        WHERE d.id = ? AND p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $districtId, $provinceId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "status" => "success",
        "provinceName" => $row['province_name'],
        "districtName" => $row['district_name']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Không tìm thấy tên tỉnh hoặc quận/huyện."
    ]);
}
?>
