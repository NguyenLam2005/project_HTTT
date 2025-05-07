<?php
require_once './config.php';
session_start();

if (isset($_POST['admin-login'])) {
    $userName = $_POST['admin-username'];
    $passwd = $_POST['admin-password'];

    $userName = mysqli_real_escape_string($conn, $userName);

    $sqlAccount = "SELECT * FROM employeeaccount WHERE userName = ?";
    $stmtAcc = $conn->prepare($sqlAccount);
    $stmtAcc->bind_param("s", $userName);
    $stmtAcc->execute();
    $resultAcc = $stmtAcc->get_result();

    if ($resultAcc->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Tài khoản không tồn tại']);
        exit;
    }

    $accountRow = $resultAcc->fetch_assoc();
    $hashedPassword = $accountRow['password'];
    $status = $accountRow['status'];

    // Kiểm tra mật khẩu
    if (!password_verify($passwd, $hashedPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Sai mật khẩu']);
        exit;
    }
    if ($status == 2){
        echo json_encode(['status' => 'error', 'message' => 'Tài khoản đã bị khóa']);
        exit;
    }


    $sql = "SELECT ea.*, e.fullName, e.email, e.phoneNumber, e.address,pf.function_id, pf.ActionID, f.name AS function_name, p.name AS permission_name
            FROM employeeaccount ea
            JOIN employees e ON ea.userName = e.id
            JOIN permissions p ON ea.permission_id = p.id
            JOIN permission_function pf ON p.id = pf.permission_id
            JOIN functions f ON pf.function_id = f.id
            WHERE ea.userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    $adminInfo = null;
    $functions_map = [];

    while ($row = $result->fetch_assoc()) {
        if (!$adminInfo) {
            $adminInfo = [
                'adminID' => $row['id'],
                'userName' => $row['userName'],
                'permission_id' => $row['permission_id'],
                'fullName' => $row['fullName'],
                'permission_name' => $row['permission_name'],
                'email' => $row['email'],
                'phoneNumber' => $row['phoneNumber'],
                'address' => $row['address'],
                'status' => $row['status'],
            ];
        }

        $fname = $row['function_name'];
        $action = $row['ActionID'];

        if (!isset($functions_map[$fname])) {
            $functions_map[$fname] = [];
        }

        $functions_map[$fname][] = $action;
    }

    if ($adminInfo) {
        $_SESSION['adminInfo'] = $adminInfo + ['functions_map' => $functions_map];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không lấy được phân quyền']);
    }
}
?>
