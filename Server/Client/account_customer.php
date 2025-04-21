<?php
require_once __DIR__ . '/../database.php';  
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Kiểm tra số điện thoại có bị trùng
    if ($action === 'check_sdt') {
        $sdt = $_POST['sdt'] ?? '';
        $stmt = $conn->prepare("SELECT id FROM customers WHERE phoneNumber = ?");
        $stmt->bind_param("s", $sdt);
        $stmt->execute();
        $stmt->store_result();
        echo json_encode(['exists' => $stmt->num_rows > 0]);
        exit;
    }

    // Kiểm tra tên đăng nhập có bị trùng
    if ($action === 'check_username') {
        $username = $_POST['userName'] ?? '';
        $stmt = $conn->prepare("SELECT id FROM customers WHERE userName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        echo json_encode(['exists' => $stmt->num_rows > 0]);
        exit;
    }

    // Đăng ký khách hàng
    if ($action === 'register_customer') {
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['std'] ?? '';
        $address = $_POST['dia_chi'] ?? '';
        $username = $_POST['userName'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($fullname) || empty($phone) || empty($address) || empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Vui lòng nhập đầy đủ thông tin!']);
            exit;
        }

        if (!preg_match('/^0\d{9}$/', $phone)) {
            echo json_encode(['success' => false, 'error' => 'Số điện thoại không hợp lệ']);
            exit;
        }
        
        if (!preg_match('/^[a-zA-Z0-9]{6,}$/', $username)) {
            echo json_encode(['success' => false, 'error' => 'Tên đăng nhập không hợp lệ']);
            exit;
        }

        // Kiểm tra trùng username hoặc phoneNumber ở server
        $stmt = $conn->prepare("SELECT id FROM customers WHERE userName = ? OR phoneNumber = ?");
        $stmt->bind_param("ss", $username, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(['success' => false, 'error' => 'Tên đăng nhập hoặc số điện thoại đã tồn tại']);
            exit;
        }

        // Hash mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Thêm khách hàng
        $stmt = $conn->prepare("INSERT INTO customers (fullName, phoneNumber, userName, password, address, status) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssss", $fullname, $phone, $username, $hashedPassword, $address);
        if ($stmt->execute()) {
            $customer_id = $stmt->insert_id;

            // Tạo giỏ hàng mới
            $stmt_cart = $conn->prepare("INSERT INTO carts (customer_id, createdAt) VALUES (?, NOW())");
            $stmt_cart->bind_param("i", $customer_id);
            $stmt_cart->execute();

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        exit;
    }

    if ($action === 'login_customer') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
    
        if ($username === '' || $password === '') {
            echo json_encode(['exists' => false]);
            exit;
        }
    
        $stmt = $conn->prepare("SELECT * FROM customers WHERE userName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if ((int)$user['status'] === 0) {
                // Tài khoản bị khóa
                echo json_encode(['exists' => false, 'blocked' => true]);
            } elseif (password_verify($password, $user['password'])) {
                // Đăng nhập thành công
                $_SESSION['customer'] = [
                    'id' => $user['id'],
                    'username' => $user['userName'],
                    'name' => $user['fullName']
                ];
                echo json_encode(['exists' => true]);
            } else {
                // Sai mật khẩu
                echo json_encode(['exists' => false]);
            }
        } else {
            // Không tìm thấy người dùng
            echo json_encode(['exists' => false]);
        }
    }
    
    //Dăng xuất
    if ($action === 'logout_customer') {
        session_unset();
        session_destroy();
        echo json_encode(['success' => true]);
        exit;
    }
    

}