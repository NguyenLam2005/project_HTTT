<?php
include 'config.php';

if (isset($_POST['province_id'])) {
    $province_id = intval($_POST['province_id']);
    $sql = "SELECT id, name FROM districts WHERE province_id = ? ORDER BY name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $province_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<option value=''>Chọn huyện/quận</option>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>" . htmlspecialchars($row['name']) . "</option>";
        }
    } else {
        echo "<option value=''>Không có quận/huyện</option>";
    }
}
?>
