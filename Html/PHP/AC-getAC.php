<?php
include 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];  

    $sql = "SELECT u.*, p.name AS permission_name 
            FROM employeeaccount u 
            LEFT JOIN permissions p ON u.permission_id = p.id 
            WHERE u.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Liên kết tham số và thực thi câu truy vấn
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        echo json_encode($user);
    } else {
        echo json_encode(["error" => "Tài khoản không tồn tại"]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "ID không hợp lệ"]);
}

mysqli_close($conn);
?>
