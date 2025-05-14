<?php
require_once __DIR__ . '/../database.php';  
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';

    // Kiểm tra số điện thoại có bị trùng
    if ($action === 'check_sdt') {
        $sdt = $_POST['sdt'] ?? '';
        $stmt = $conn->prepare("SELECT id FROM customers WHERE phoneNumber = ?");
        $stmt->bind_param("s", $sdt);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["exists" => TRUE]);
        } else {
            echo json_encode(["exists" => FALSE]);
        }
        exit;
    }
    // Kiểm tra email có bị trùng
    if ($action === 'check_email') {
        $email = $_POST['email'] ?? '';
        $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["exists" => TRUE]);
        } else {
            echo json_encode(["exists" => FALSE]);
        }
        exit;
    }
    // Kiểm tra tên đăng nhập có bị trùng
    if ($action === 'check_username') {
        $username = $_POST['userName'] ?? '';
        $stmt = $conn->prepare("SELECT id FROM customers WHERE userName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["exists" => TRUE]);
        } else {
            echo json_encode(["exists" => FALSE]);
        }
        exit;
    }

    // Đăng ký khách hàng
    if ($action === 'register_customer') {
        $fullname = $_POST['fullname'] ?? '';
        $phone = $_POST['std'] ?? '';
        $username = $_POST['userName'] ?? '';
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';
        

        if (empty($fullname) || empty($phone) || empty($email) || empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Vui lòng nhập đầy đủ thông tin!']);
            exit;
        }

        if (!preg_match('/^0\d{9}$/', $phone)) {
            echo json_encode(['success' => false, 'error' => 'Số điện thoại không hợp lệ']);
            exit;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Email không hợp lệ']);
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
        $stmt = $conn->prepare("INSERT INTO customers (fullName, phoneNumber, userName, password, email, status) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssss", $fullname, $phone, $username, $hashedPassword, $email);

        if ($stmt->execute()) {
            $customer_id = $stmt->insert_id;

            // $stmt_cart = $conn->prepare("INSERT INTO carts (customer_id, createdAt) VALUES (?, NOW())");
            // $stmt_cart->bind_param("i", $customer_id);
            // $stmt_cart->execute();

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
        $stmt->close();
    
        if ($user) {
            if ((int)$user['status'] === 0) {
                // Tài khoản bị khóa
                echo json_encode(['exists' => false, 'blocked' => true]);
                exit;
            }
    
            if (password_verify($password, $user['password'])) {
                $district_id = $user['district_id'] ?? null;
                $province_name = '';
                $district_name = '';
    
                if ($district_id !== null) {
                    $sqlAddress = "SELECT provinces.name AS province_name, districts.name AS district_name
                                   FROM provinces
                                   INNER JOIN districts ON districts.province_id = provinces.id
                                   WHERE districts.id = ?";
                    $stmt = $conn->prepare($sqlAddress);
                    $stmt->bind_param("i", $district_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $rowAddress = $result->fetch_assoc();
                    $stmt->close();
    
                    if ($rowAddress) {
                        $province_name = $rowAddress["province_name"] ?? '';
                        $district_name = $rowAddress["district_name"] ?? '';
                    }
                }
    
                $addressDetail = $user['addressDetail'];
                $fullAddress = ($addressDetail !== null && $addressDetail !== '')
                    ? $addressDetail . ", " . $district_name . ", " . $province_name
                    : "Chưa có";
    
                // Lưu vào session
                $_SESSION['customer'] = [
                    'id' => $user['id'],
                    'username' => $user['userName'],
                    'name' => $user['fullName'],
                    'email' => $user['email'],
                    'phone' => $user['phoneNumber'],
                    'addressDetail' => $user['addressDetail'],
                    'province_id' => $user['province_id'],
                    'district_id' => $user['district_id'],
                    'address' => $fullAddress
                ];
    
                echo json_encode(['exists' => true, 'customer' => $_SESSION['customer']]);
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