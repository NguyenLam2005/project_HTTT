<?php
include __DIR__ . '/config.php';
session_start();

if (isset($_POST['admin-login'])) {
    $userName = trim($_POST['admin-username']);
    $passwd = trim($_POST['admin-password']);

    error_log("Login attempt for username: " . $userName);
    error_log("Raw password input: " . $passwd);
    error_log("Password length: " . strlen($passwd));
    error_log("Password encoding: " . mb_detect_encoding($passwd));

    $userName = mysqli_real_escape_string($conn, $userName);

    // Lấy thông tin của tài khoản nhân viên và danh sách các chức năng.
    $sql = "SELECT ea.*, e.fullName, GROUP_CONCAT(pf.function_id) AS function_ids
        FROM employeeaccount ea
        JOIN employees e ON ea.userName = e.id
        JOIN permissions p ON ea.permission_id = p.id
        JOIN permission_function pf ON p.id = pf.permission_id
        WHERE ea.userName = '$userName'
        GROUP BY ea.id";
    
    error_log("SQL query: " . $sql);
    
    $result = $conn->query($sql);
    
    if ($result) {
        error_log("Query executed successfully");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            error_log("Found user: " . json_encode($row));
            error_log("Stored hashed password: " . $row['password']);
            
            if (password_verify($passwd, $row['password'])) {
                error_log("Password verified successfully");
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
                error_log("Password verification failed");
                echo json_encode(['status' => 'error', 'message' => 'Sai mật khẩu']);
            }
        } else {
            error_log("No user found with username: " . $userName);
            echo json_encode(['status' => 'error', 'message' => 'Không tồn tại tài khoản admin']);
        }
    } else {
        error_log("Query failed: " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
    }

    exit();
}
?>
