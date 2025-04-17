<?php
require_once './config.php';
session_start();

if (isset($_POST['admin-login'])) {
    $userName = $_POST['admin-username'];
    $passwd = $_POST['admin-password'];

    $userName = mysqli_real_escape_string($conn, $userName);

    // Lấy thông tin của tài khoản nhân viên và danh sách các chức năng.
    $sql = "SELECT ea.*, e.fullName, GROUP_CONCAT(pf.function_id) AS function_ids
        FROM employeeaccount ea
        JOIN employees e ON ea.userName = e.id
        JOIN permissions p ON ea.permission_id = p.id
        JOIN permission_function pf ON p.id = pf.permission_id
        WHERE ea.userName = '$userName'
        GROUP BY ea.id";
    $result = $conn->query($sql);


    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($passwd, $row['password'])) {
            $functionIds = explode(',', $row['function_ids']);
            $_SESSION['adminInfo'] = [
                'adminID' => $row['id'],
                'userName' => $row['userName'],
                'permission_id' => $row['permission_id'],
                'fullName' => $row['fullName'],
                'function_ids' => $functionIds
            ];

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sai mật khẩu']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không tồn tại tài khoản admin']);
    }

    exit();
}
?>
