<?php
include __DIR__ . '/config.php';

$sql = "SELECT e.*, p.name AS position_name 
        FROM employees e
        JOIN positions p ON e.position_id = p.id
        ORDER BY e.id ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $temp=1;
    while ($row = $result->fetch_assoc()) {
        $empId = $row['id']; 
        echo "<tr data-id='$empId'>";
        echo "<td>" . $temp . "</td>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fullName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['position_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phoneNumber']) . "</td>";
        echo "<td>
                <div class='fix-employee'>
                    <i class='fa-solid fa-pen-to-square fix-btn-employee' data-id='$empId'></i> 
                    <i class='fa-solid fa-trash delete-btn-employee' data-id='$empId'></i> 
                </div>
              </td>";
        echo "</tr>";
        $temp=$temp+1;
    }
} else {
    echo "<tr><td colspan='7'>Không có tài khoản nào</td></tr>";
}
?>
    <div id="delete-overlay-employee">
        <div class="delete-container">
          <span>Bạn muốn xóa nhân viên?</span>
          <button id="delete-acp-employee">Xác nhận</button>
          <button id="cancel-employee">Hủy</button>
        </div>
    </div>