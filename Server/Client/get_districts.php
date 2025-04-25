<?php
require_once __DIR__ . '/../database.php';  

$province_id = $_POST['province_id'];
$stmt = $conn->prepare("SELECT * FROM districts WHERE province_id = ?");
$stmt->bind_param("i", $province_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<option value=''>Chọn quận/huyện</option>";
while($row = $result->fetch_assoc()){
    echo "<option value='".$row['id']."'>".$row['name']."</option>";
}
?>
