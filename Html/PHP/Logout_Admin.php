<?php
session_start();
unset($_SESSION['adminInfo']); // Xóa biến session
session_destroy();             // Hủy toàn bộ session

echo json_encode(['status' => 'success']);
exit();
?>
