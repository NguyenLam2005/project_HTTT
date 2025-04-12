<?php
    include '../PHP/config.php';

    if (isset($_POST['adminLogin-form'])) {
        $adminName = $_POST['lg-adminName'];
        $password = $_POST['lg-adminPassword'];

        $sql = "SELECT * FROM admin_accounts WHERE admin_name = '$adminName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($password == $row['password']) {
                // Đăng nhập thành công
                echo json_encode(['status' => 'success']);
                // session_start();
                // $_SESSION['admin'] = $adminName;
                // header("Location: dashboard.php");
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Sai mật khẩu']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không tồn tại người dùng']);
        }
    }
?>
