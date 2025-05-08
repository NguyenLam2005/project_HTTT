<?php
include __DIR__ . '/config.php';

$sql = "SELECT * FROM suppliers";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $spId = $row['id']; 
        echo "<tr data-id='$spId'>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phoneNumber']) . "</td>";
        echo "<td>
                <div class='fix-supplier'>
                    <i class='fa-solid fa-pen-to-square fix-btn-supplier' data-id='$spId'></i> 
                    <i class='fa-solid fa-trash delete-btn-supplier' data-id='$spId'></i> 
                </div>
              </td>";
        echo "</tr>";
        $temp=$temp+1;
    }
} else {
    echo "<tr><td colspan='5' style='text-align: center'>Không có nhà cung cấp</td></tr>";
}
?>
    <div id="delete-overlay-supplier">
        <div class="delete-container">
          <span>Bạn muốn xóa nhà cung cấp?</span>
          <button id="delete-acp-supplier">Xác nhận</button>
          <button id="cancel-supplier">Hủy</button>
        </div>
    </div>