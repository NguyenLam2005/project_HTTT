<?php
include __DIR__ . '/config.php';

$sql = "SELECT ip.*, e.fullName AS employee_name, s.name AS supplier_name FROM importreceipts ip
        LEFT JOIN employees e ON ip.employee_id = e.id
        LEFT JOIN suppliers s ON ip.supplier_id = s.id
        ORDER BY ip.importDate ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $stt = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-id='{$row['id']}'>";
        echo "<td>" . $stt++ . "</td>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['employee_id']) . "</td>";
        echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['importDate']))) . "</td>";
        echo "<td>"
            . "<select class='import-status' data-id='" . htmlspecialchars($row['id']) . "' data-current-status='" . htmlspecialchars($row['status']) . "'>"
            . "<option value='1'" . ($row['status'] == 1 ? ' selected' : '') . ">Chưa duyệt</option>"
            . "<option value='2'" . ($row['status'] == 2 ? ' selected' : '') . ">Đã duyệt</option>"
            . "</select>"
            . "</td>";
        echo "<td style='text-align: center; vertical-align: middle;'><i class='fa-solid fa-circle-info import-detail' data-id='" . htmlspecialchars($row['id']) . "' style='cursor:pointer'></i></td>";
        echo "<td>
                <div class='fix-import' style='justify-content: center;'>
                    <i class='fa-solid fa-trash delete-btn-import' style='cursor:pointer'></i>
                </div>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7' style='text-align: center;'>Không có phiếu nhập nào</td></tr>";
}
$conn->close();
?>
