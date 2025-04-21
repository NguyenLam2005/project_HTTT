<?php
    include 'config.php';
    $sql = "SELECT id, name FROM orderstatus ORDER BY id ASC";
    $result = $conn->query($sql);
    echo "<select name='order-status' class='orderstatus-select form-select' id='filter-status' required >";
    echo "<option value='0'>Tất cả</option>";
    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    } else {
    echo "<option value=''>Không có trạng thái nào!</option>"; 
    }
    echo "</select>";
?>            