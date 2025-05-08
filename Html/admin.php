<?php
session_start();
if (!isset($_SESSION['adminInfo'])) {
  header("Location: login_admin.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bakery admin</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/notificationRegist.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    #ad-menu a {
      display: none;
    }
    /* .disabled {
      pointer-events: none;
      opacity: 0.5;
    } */
  </style>
</head>

<body>
  

  <div class="sidebar">
    <h2 id="admin">Admin</h2>
    <div id="ad-menu">
      <a href="#" id="admin-statistic">Thống kê</a>
      <a href="#" id="admin-oder">Đơn hàng</a>
      <a href="#" id="admin-product">Sản phẩm</a>
      <a href="#" id="admin-customer">Khách hàng</a>
      <a href="#" id="admin-employee">Nhân viên</a>
      <a href="#" id="admin-account">Quản lí tài khoản</a>
      <a href="#" id="admin-role">Quản lí quyền</a>
      <a href="#" id="admin-import">Nhập hàng</a>
      <a href="#" id="admin-supplier">Nhà cung cấp</a>
      <a href="#" id="admin-inventory">Quản lí tồn kho</a>
    </div>
    <img src="img/logo-icon.png" alt="hahaha" />
  </div>

  <div class="admin-main">
    <div class="admin-header">
      <div class="profile">
        <span><?php echo $_SESSION['adminInfo']['fullName']; ?></span>
        <img src="img/account-logo.png" alt="" id="profile" />
      </div>
    </div>
    <div class="business-process">
      <div class="card">
        <h3>Số đơn hàng</h3>
        <p>0</p>
      </div>
      <div class="card">
        <h3>Doanh thu</h3>
        <p>0</p>
      </div>
      <div class="card">
        <h3>Tỷ lệ tăng trưởng</h3>
        <p>0</p>
      </div>
    </div>
  </div>

  <div class="profile-part">
    <div class="profile-container">
      <div class="profile-header">
        <img src="img/account-logo.png" alt="" class="avatar" />
        <div class="user-info">
          <h2><?php echo $_SESSION['adminInfo']['fullName']; ?></h2>
        </div>
      </div>
      <ul class="menu-profile">
        <li>
          <a href="#">Quyền hạn: <span><?php echo $_SESSION['adminInfo']['permission_name']; ?></span></a>
        </li>
        <li>
          <a href="#">Địa chỉ mail: <span><?php echo $_SESSION['adminInfo']['email']; ?></span></a>
        </li>
        <li>
          <a href="#">Số điện thoại: <span><?php echo $_SESSION['adminInfo']['phoneNumber']; ?></span></a>
        </li>
        <li>
          <a href="#">Địa chỉ: <span><?php echo $_SESSION['adminInfo']['address']; ?></span></a>
        </li>
      </ul>
      <button class="logout-btn-admin">Đăng xuất</button>
    </div>
  </div>

  <div class="statistic-part">
    <div class="statistic-table-container">
      <h1 style="text-align: center;">THỐNG KÊ</h1>
      <div class="form-group">
        <label for="statistic-choice">Lựa chọn:</label>
        <select id="statistic-choice" name="statistic-choice" class="form-select" require style="width: 260px;">
          <option value="">Lựa chọn thống kê</option>
          <option value="1">Thống kê khách hàng</option>
          <option value="2">Thống kê sản phẩm</option>
        </select>
      </div>

      <!-- Thống kê khách hàng -->
      <div id="statistic-customer" style="display: none;">
      <h3 style="text-align: left; margin-bottom: 10px;">Thống kê các khách hàng mua nhiều nhất:</h3>
      <form id="filter-form-customer" style="margin-bottom: 10px; display: flex; gap: 5px;">
          <div class="form-group">
              <label for="fromDate">Số lượng khách hàng:</label><br>
              <input type="number" id="customer-number" name="count" class="form-input" placeholder="Nhập số khách hàng" min="1">
          </div>

          <div class="form-group">
              <label for="fromDate">Từ ngày:</label><br>
              <input type="date" id="statistic-start-date-customer" name="start_date" class="form-input">
          </div>

          <div class="form-group">
              <label for="toDate">Đến ngày:</label><br>
              <input type="date" id="statistic-end-date-customer" name="end_date" class="form-input">
          </div>

          <div class="form-group">
              <label for="sort">Sắp xếp:</label><br>
              <select id="statistic-sort-customer" name="sort" class="form-select" require>
                  <option value="1">Tăng dần</option>
                  <option value="2">Giảm dần</option>
              </select>
          </div>
          
          <div class="form-group">
          <label></label><br>
            <button type="submit" class="form-button">Thống kê</button>
          </div>
      </form>
        <h3 style="text-align:center; display: none" class="statistic-title-customer"></h3>
        <table class="statistic-customer-table statistic-table">
          <thead>
            <tr>
              <th>STT</th>
              <th>Mã khách hàng</th>
              <th>Tên khách hàng</th>
              <th>Tổng tiền mua</th>
              <th>Các đơn hàng</th>
            </tr>
          </thead>
          <tbody>
            <?php include 'PHP/ST-customer_Manager.php' ?>
          </tbody>
        </table>
        <div class="order-detail-container1" style="display: none;"></div>
      </div>
        
      <!-- Thống kê sản phẩm -->
      <div id="statistic-product" style="display: none;">
      <h3 style="text-align: left; margin-bottom: 10px;">Thống kê các sản phẩm bán chạy nhất:</h3>
      <form id="filter-form-product" style="margin-bottom: 10px; display: flex; gap: 5px;">
          <div class="form-group">
              <label for="fromDate">Số sản phẩm:</label><br>
              <input type="number" id="product-number" name="count" class="form-input" placeholder="Nhập số sản phẩm" min="1">
          </div>

          <div class="form-group">
              <label for="fromDate">Từ ngày:</label><br>
              <input type="date" id="statistic-start-date-product" name="start_date" class="form-input">
          </div>

          <div class="form-group">
              <label for="toDate">Đến ngày:</label><br>
              <input type="date" id="statistic-end-date-product" name="end_date" class="form-input">
          </div>

          <div class="form-group">
              <label for="sort">Sắp xếp:</label><br>
              <select id="statistic-sort-product" name="sort" class="form-select" require>
                  <option value="1">Tăng dần</option>
                  <option value="2">Giảm dần</option>
              </select>
          </div>
          
          <div class="form-group">
          <label></label><br>
            <button type="submit" class="form-button">Thống kê</button>
          </div>
      </form>
        <h3 style="text-align:center; display: none" class="statistic-title-product"></h3>
        <table class="statistic-product-table statistic-table">
          <thead>
            <tr>
              <th>STT</th>
              <th>Mã sản phẩm</th>
              <th>Tên sản phẩm</th>
              <th>Giá bán</th>
              <th>Số lượng bán</th>
              <th>Tổng tiền</th>
              <th>Thông tin chi tiết</th>
            </tr>
          </thead>
          <tbody>
            <?php include 'PHP/ST-product_Manager.php' ?>
          </tbody>
        </table>
        
      </div>

    </div>
  </div>

  <div class="order-part">
    <div class="order-table-container">
      <form id="filter-form-order" style="margin-bottom: 10px; display: flex; gap: 5px;">
        <div class="form-group">
          <label for="filter-status">Trạng thái:</label>
          <?php include 'PHP/OD-get_status.php' ?>
        </div>
       
        <div class="form-group">
            <label for="province">Tỉnh/Thành phố:</label><br>
            <select name="order-province" class="form-select" id="order-province">;
              <option value="">Chọn tỉnh/thành phố</option>";
              <?php include 'PHP/OD-get_province.php' ?>
        </div>

        <div class="form-group">
            <label for="district">Huyện/Quận:</label><br>
            <select id="order-district" name="order-district" class="form-select">
                <option value="">Chọn huyện/quận</option>
                <?php include 'PHP/OD-get_district.php' ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fromDate">Từ ngày:</label><br>
            <input type="date" id="order-start-date" name="start_date" class="form-input">
        </div>

        <div class="form-group">
            <label for="toDate">Đến ngày:</label><br>
            <input type="date" id="order-end-date" name="end_date" class="form-input">
        </div>
        
        <div class="form-group">
        <label></label><br>
          <button type="submit" class="form-button"><img src="img/Filter.png" style="height: 17px;"> Lọc</button>
        </div>
      </form>

      <table class="order-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Xem chi tiết</th>
            <th>Trạng thái</th>
          </tr>
        </thead>
        <tbody id="order-table-body">
        <?php include 'PHP/OD-Manager.php' ?>
        </tbody>
      </table>
      <div class="order-detail-container" style="display: none; margin-top: 20px;"></div>
    </div>
  </div>
  
  <div class="product-part">
    <div class="product-table-container">
      <div id="product-plus">Thêm sản phẩm</div>
      <table class="product-table">
        <thead>
          <tr>
            <th style="text-align: center">Hình ảnh sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Thương hiệu</th>
            <th>Thể loại</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
            <th id="setting-pro">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="product-table-body">
          <?php include 'PHP/PD-Manager.php'; ?>
        </tbody>
      </table>

      <form class="add-form-product" action="PHP/PD-Add.php" method="POST" enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-product"></i>
        <div class="form-group">
          <label for="product-image" class="form-label">Ảnh sản phẩm</label>
          <input type="file" id="product-image" name="product-image" class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-name" class="form-label">Tên sản phẩm</label>
          <input type="text" id="product-name" name="product-name" placeholder="Nhập tên sản phẩm" class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-brand" class="form-label">Thương hiệu</label>
          <select name="product-brand" id="product-brand" class="form-select" required>
          <?php
            include 'PHP/config.php';
            $sql = "SELECT id, name FROM brand";
            $result = $conn->query($sql);
            echo "  <option value=''>-- Chọn thương hiệu --</option>";
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } else {
                echo "<option value=''>Không có thương hiệu nào!</option>";
            }
          ?>
        </select>
        </div>

        <div class="form-group">
        <label for="category" class="form-label">Thể loại sản phẩm</label>
        <?php 
          include 'PHP/PD-getCategory.php';
        ?>
        </div>

        <div class="form-group">
          <label for="product-gender" class="form-label">Giới tính</label>
          <select name="product-gender" id="product-gender" class="form-select" required>
          <?php
            include 'PHP/config.php';
            $sql = "SELECT id, name FROM genders";
            $result = $conn->query($sql);
            echo "  <option value=''>-- Chọn giới tính --</option>";
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } else {
                echo "<option value=''>Không có giới tính nào!</option>";
            }
          ?>
        </select>
        </div>

        <div class="form-group">
          <label for="product-supplier" class="form-label">Nhà cung cấp</label>
          <select name="product-supplier" id="product-supplier" class="form-select" required>
            <?php
              include '../../PHP/config.php';
              $sql = "SELECT id, name FROM suppliers ORDER BY id ASC";
              $result = $conn->query($sql);
              echo "  <option value=''>-- Chọn nhà cung cấp --</option>";
              if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
              } else {
                echo "<option value=''>Không nhà cung cấp nào!</option>";
              }
              ?>
            </select>  
        </div>

        <div class="form-group">
          <label for="product-price" class="form-label">Giá bán(VNĐ)</label>
          <input type="number" id="product-price" name="product-price" placeholder="Nhập giá" class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-description" class="form-label">Mô tả</label>
          <input type="text" id="product-description" name="product-description" placeholder="Nhập mô tả" class="form-input" />
        </div>

        <div class="form-group text-center">
          <button type="submit" class="form-button" id="accept-addPD">Thêm Sản Phẩm</button>
        </div>
      </form>

      <form class="fix-form-product" id="update-form-product" enctype="multipart/form-data">
        <input type="hidden" id="product-id" name="product-id">
        <i class="fa-solid fa-rotate-left back-product"></i>
        <div class="form-group">
          <label for="product-image" class="form-label">*Ảnh sản phẩm</label>
          <img id="preview-image" src="" alt="Ảnh sản phẩm" style="width: 150px; height: auto; margin-bottom: 10px;">
          <input type="file" id="product-image" onchange="uploadImg(this)" name="product-image" class="form-input"
            accept="image/*" />
        </div>

        <div class="form-group">
          <label for="product-name" class="form-label">*Tên sản phẩm</label>
          <input type="text" id="product-nameFIX" name="product-name" placeholder="Nhập tên sản phẩm"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-brand" class="form-label">*Thương hiệu</label>
          <select name="product-brand" id="product-brandFIX" class="form-select" required>
          <?php
            include 'PHP/config.php';
            $sql = "SELECT id, name FROM brand";
            $result = $conn->query($sql);
            echo "  <option value=''>-- Chọn thương hiệu --</option>";
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } else {
                echo "<option value=''>Không có thương hiệu nào!</option>";
            }
          ?>
        </select>
        </div>

        <div class="form-group">
        <label for="category" class="form-label">*Thể loại sản phẩm</label>
        <select name="product-category" id="product-categoryFIX" class="form-select" required>
        <?php
            include 'PHP/config.php';
            $sql = "SELECT id, name FROM categories";
            $result = $conn->query($sql);
            echo "  <option value=''>-- Chọn thể loại sản phẩm --</option>";
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } else {
                echo "<option value=''>Không có thể loại nào!</option>";
            }
          ?>
        </select>
        </div>

        <div class="form-group">
          <label for="product-gender" class="form-label">*Giới tính</label>
          <select name="product-gender" id="product-genderFIX" class="form-select" required>
          <?php
            include 'PHP/config.php';
            $sql = "SELECT id, name FROM genders";
            $result = $conn->query($sql);
            echo "  <option value=''>-- Chọn giới tính --</option>";
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
            } else {
                echo "<option value=''>Không có giới tính nào!</option>";
            }
          ?>
        </select>
        </div>

        <div class="form-group">
          <label for="product-supplier" class="form-label">*Nhà cung cấp</label>
          <select name="product-supplier" id="product-supplierFIX" class="form-select" required>
            <?php
              include 'PHP/config.php';
              $sql = "SELECT id, name FROM suppliers ORDER BY id ASC";
              $result = $conn->query($sql);
              echo "  <option value=''>-- Chọn nhà cung cấp --</option>";
              if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
              } else {
                echo "<option value=''>Không nhà cung cấp nào!</option>";
              }
              ?>
            </select>  
        </div>

        <div class="form-group">
          <label for="product-price" class="form-label">*Giá bán (VNĐ)</label>
          <input type="number" id="product-priceFIX" name="product-price" placeholder="Nhập giá"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-description" class="form-label">*Mô tả</label>
          <input type="text" id="product-descriptionFIX" name="product-description" placeholder="Nhập mô tả" class="form-input" />
        </div>

        <div class="form-group text-center">
          <button type="submit" id="accept-fixPD" class="form-button">Hoàn tất</button>
        </div>
      </form>

    </div>
  </div>

  <div class="customer-part">
    <div class="customer-table-container">
      <!-- <div id="customer-plus">Thêm khách hàng</div> -->
      <table class="customer-table">
        <thead>
          <tr>
            <th>Mã KH</th>
            <th>Tên KH</th>
            <th>Trạng thái tài khoản</th>
            <th>Chi tiết tài khoản</th>
            <th>Lịch sử đơn hàng</th>
            <!-- <th>Email</th>
            <th>Địa chỉ</th> -->
            <th id="setting-cus">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="customer-table-body">
          <?php include 'PHP/CU-Manager.php'; ?>
        </tbody>
      </table>

      <div class="history-order-container">
         <i class="fa-solid fa-rotate-left back-customer2"></i>

      </div>

      <form class="fix-form-customer" id="fix-form-customer" enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-customer"></i>

        <div class="form-group">
          <label for="customer-id" class="form-label">Mã khách hàng</label>
          <input type="text" id="customer-id" name="customer-id" placeholder="Nhập mã KH" class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-uname" class="form-label">Tên đăng nhập</label>
          <input type="text" id="customer-uname-f" name="customer-uname" placeholder="Nhập tên đăng nhập"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-pass" class="form-label">Password</label>
          <input type="text" id="customer-pass-f" name="customer-pass" placeholder="Nhập mật khẩu" class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-name" class="form-label">Tên khách hàng</label>
          <input type="text" id="customer-name-f" name="customer-name" placeholder="Nhập tên khách hàng"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-phone" class="form-label">Số điện thoại</label>
          <input type="text" id="customer-phone-f" name="customer-phone" placeholder="Nhập SĐT khách hàng"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-email" class="form-label">Email</label>
          <input type="email" id="customer-email-f" name="customer-email" placeholder="Nhập email" class="form-input" />
        </div>

        <!-- <div class="form-group">
          <label for="customer-address" class="form-label">Địa chỉ</label>
          <input type="text" id="customer-address-f" name="customer-address" placeholder="Nhập địa chỉ"
            class="form-input" />
        </div> -->

        <div class="form-group text-center">
          <button type="submit" class="form-button">Hoàn tất</button>
        </div>
      </form>

    </div>
  </div>

  <div class="account-part">
    <div class="account-table-container">
      <div id="account-plus">Thêm tài khoản</div>
      <table class="account-table">
        <thead>
          <tr>
            <th style="text-align: center">Tên đăng nhập</th>
            <!-- <th>Mật khẩu</th> -->
            <th>Tên nhân viên</th>
            <th>Trạng thái</th>
            <th>Quyền</th>
            <th id="setting-ac">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="account-table-body">
            <?php include 'PHP/AC-Manager.php'?>
        </tbody>
      </table>

      <div id="role-popup">
        <div>Chức năng 1</div>
        <div>Chức năng 2</div>
        <div>Chức năng 3</div>
        <div class="popup-arrow">
        </div>
      </div>






      <form class="add-form-account" action="PHP/AC-Add.php" method="POST" enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-account"></i>
        <div class="form-group">
          <label for="account-name" class="form-label">Tên đăng nhập</label>
          <input type="text" id="account-name" name="account-name" placeholder="Nhập tên" class="form-input" required />
        </div>

        <div class="form-group">
          <label for="account-pass" class="form-label">Mật khẩu</label>
          <input type="password" id="account-pass" name="account-pass" placeholder="Nhập mật khẩu" class="form-input"
            required />
        </div>

        <div class="form-group">
          <label for="account-role" class="form-label" style="color: red;">Cấp quyền</label>
          <div class="role-container">
          <?php
            include 'PHP/config.php'; // Kết nối database
            // Lấy danh sách quyền từ bảng permissions
            $sql = "SELECT id, name FROM permissions ORDER BY id ASC";
            $result = $conn->query($sql);

            echo "<select name='permission_id' class='permission-select' id='permissionSelect' required>";
            echo "<option value=''>Chọn quyền</option>"; // Chọn giá trị mặc định
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
            } else {
              echo "<option value=''>Không có quyền nào!</option>"; // Nếu không có dữ liệu
            }
            echo "</select>";
            ?>
          </div>
        </div>

        <div class="form-group text-center">
          <button type="submit" class="form-button">Thêm tài khoản</button>
        </div>
      </form>


      <form class="fix-form-account" id="fix-form-account" action="PHP/AC-Edit.php" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" id="account-id" name="account-id">
        <i class="fa-solid fa-rotate-left back-account"></i>
        <div class="form-group">
          <label for="account-name" class="form-label">Tên đăng nhập</label>
          <input type="text" id="account-name-f" name="account-name" placeholder="Nhập tên" class="form-input" />
        </div>

        <div class="form-group">
          <label for="account-pass" class="form-label">Mật khẩu</label>
          <input type="text" id="account-pass-f" name="account-pass" placeholder="Nhập mật khẩu" class="form-input" />
        </div>

        <div class="form-group">
          <label for="account-role" class="form-label" style="color: red;">Cập nhật quyền</label>
          <div class=role-container>
            <?php
            include 'PHP/config.php'; // Kết nối database
            
            // Lấy danh sách quyền từ bảng permissions
            $sql = "SELECT id, name FROM permissions ORDER BY id ASC";
            $result = $conn->query($sql);

            echo "<select name='permission_id' class='permission-select' id='permissionSelect-f' required>";
            echo "<option value=''>Chọn quyền</option>";
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
            } else {
              echo "<option value=''>Không có quyền nào!</option>";
            }
            echo "</select>";
            ?>
          </div>
        </div>

        <div class="form-group text-center">
          <button type="submit" class="form-button">Hoàn tất</button>
        </div>
      </form>



    </div>
  </div>



  <div class="role-part">
    <div class="role-table-container">
      <div id="role-plus">Thêm quyền</div>

      <table class="role-table">
        <thead>
          <tr>
            <th style="text-align: center">Quyền</th>
            <th>Số lượng chức năng</th>
            <th>Số lượng tài khoản</th>
            <th>Danh sách tài khoản</th>
            <th id="setting-pm">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="role-table-body">
          <?php
          include 'PHP/PM-Manager.php';
          ?>
        </tbody>
      </table>



      <form class="add-form-role" id="add-form-role" action="PHP/PM-Add.php" method="POST"
        enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-role"></i>
        <div class="form-group">
          <label for="role-name" class="form-label">Tên quyền</label>
          <input type="text" id="role-name" name="role-name" placeholder="Nhập tên" class="form-input" />
        </div>

        <!-- Danh sách chức năng -->
        <div class="form-group">
          <label class="form-label" style="color: red;">Chức năng</label>
          <div class="role-container">

            <!-- Tiêu đề cột -->
            <div class="role-header">
              <div class="role-item">Tên chức năng</div>
              <?php
                include 'PHP/config.php';
                $actions_result = $conn->query("SELECT ActionID, ActionNameVN FROM action");
                $actions = [];
                while ($row = $actions_result->fetch_assoc()) {
                  $actions[] = $row;
                  echo "<div class='permission'>" . htmlspecialchars($row['ActionNameVN']) . "</div>";
                }
              ?>
            </div>

            <?php
              $functions_result = $conn->query("SELECT id, name FROM functions");
              while ($func = $functions_result->fetch_assoc()) {
                echo "<div class='role-row'>";
                echo "<div class='role-item'>" . htmlspecialchars($func['name']) . "</div>";
                
                foreach ($actions as $action) {
                  if ($func['name'] == "Thống kê" && $action['ActionID'] != 'AC1') {
                    continue; // bỏ qua các action khác
                }
                  // Checkbox value là dạng "functionId_actionId"
                  $checkboxValue = $func['id'] . "_" . $action['ActionID'];
                  echo "<div class='permission'>
                          <input type='checkbox' name='permissions[]' value='{$checkboxValue}'>
                        </div>";
                }

                echo "</div>";
              }
            ?>
          </div>
        </div>


        <!-- Nút thêm quyền -->
        <div class="form-group text-center">
          <button type="submit" class="form-button">Thêm quyền</button>
        </div>
      </form>




      <form id="fix-form-role" class="fix-form-role" action="PHP/PM-Edit.php" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" id="role-id-f" name="role-id">
        <i class="fa-solid fa-rotate-left back-role"></i>
        <div class="form-group">
          <label for="role-name" class="form-label">Tên quyền</label>
          <input type="text" id="role-name-f" name="role-name" placeholder="Nhập tên" class="form-input" />
        </div>
                <!-- Danh sách chức năng -->
                <div class="form-group">
          <label class="form-label" style="color: red;">Chức năng</label>
          <div class="role-container">

            <!-- Tiêu đề cột -->
            <div class="role-header">
              <div class="role-item">Tên chức năng</div>
              <?php
                include 'PHP/config.php';
                $actions_result = $conn->query("SELECT ActionID, ActionNameVN FROM action");
                $actions = [];
                while ($row = $actions_result->fetch_assoc()) {
                  $actions[] = $row;
                  echo "<div class='permission'>" . htmlspecialchars($row['ActionNameVN']) . "</div>";
                }
              ?>
            </div>

            <?php
              $functions_result = $conn->query("SELECT id, name FROM functions");
              while ($func = $functions_result->fetch_assoc()) {
                echo "<div class='role-row'>";
                echo "<div class='role-item'>" . htmlspecialchars($func['name']) . "</div>";
                
                foreach ($actions as $action) {
                if ($func['name'] == "Thống kê" && $action['ActionID'] != 'AC1') {
                    continue; // bỏ qua các action khác
                }
                  // Checkbox value là dạng "functionId_actionId"
                  $checkboxValue = $func['id'] . "_" . $action['ActionID'];
                  echo "<div class='permission'>
                          <input type='checkbox' class = 'permission-checkbox' name='permissions[]' value='{$checkboxValue}'>
                        </div>";
                }

                echo "</div>";
              }
            ?>
          </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="form-button">Hoàn tất</button>
        </div>
      </form>

      <div id="delete-overlay-role">
        <div class="delete-container">
          <span>Bạn muốn xóa quyền này?</span>
          <button id="delete-acp-role">Xác nhận</button>
          <button id="cancel-role">Hủy</button>
        </div>
      </div>



    </div>
  </div>

  
  <div class="employee-part">
    <div class="employee-table-container">
      <div id="employee-plus">Thêm nhân viên</div>
      <table class="employee-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã nhân viên</th>
            <th>Họ tên</th>
            <th>Chức vụ</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th id="setting-emp">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="employee-table-body">
            <?php include 'PHP/EP-Manager.php'?>
        </tbody>
      </table>

      <form class="add-form-employee" action="PHP/PD-Add.php" method="POST" enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-employee"></i>

        <div class="form-group">
          <label for="employee-name" class="form-label">Họ tên nhân viên</label>
          <input type="text" id="employee-name" name="employee-name" placeholder="Nhập tên nhân viên" class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-email" class="form-label">Email</label>
          <input type="text" id="employee-email" name="employee-email" placeholder="Nhập email" class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-phone" class="form-label">Số điện thoại</label>
          <input type="number" id="employee-phone" name="employee-phone" placeholder="Nhập số điện thoại" class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-address" class="form-label">Địa chỉ</label>
          <input type="text" id="employee-address" name="employee-address" placeholder="Nhập địa chỉ" class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-position" class="form-label" style="color: red;">Chức vụ</label>
          <div class="role-container">
            <?php
            include 'PHP/config.php'; 
            // Lấy danh sách chức vụ từ bảng positions
            $sql = "SELECT id, name FROM positions ORDER BY id ASC";
            $result = $conn->query($sql);

            echo "<select name='position_id' class='position_id-select' id='positionSelect' required>";
            echo "<option value=''>Chọn chức vụ</option>"; 
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
            } else {
              echo "<option value=''>Không có chức vụ nào!</option>"; 
            }
            echo "</select>";
            ?>
          </div>
        </div>

        <div class="form-group text-center">
          <button type="submit" class="form-button" id="accept-addEP">Thêm Nhân Viên</button>
        </div>
      </form>

      <form class="fix-form-employee" id="fix-form-employee" enctype="multipart/form-data">
      <input type="hidden" id="employee-id" name="employee-id">  
      <i class="fa-solid fa-rotate-left back-employee"></i>
        <div class="form-group">
          <label for="employee-name" class="form-label">Họ tên nhân viên</label>
          <input type="text" id="employee-nameFIX" name="employee-name" placeholder="Nhập tên nhân viên"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-email" class="form-label">Email</label>
          <input type="text" id="employee-emailFIX" name="employee-email" placeholder="Nhập email" class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-address" class="form-label">Địa chỉ</label>
          <input type="text" id="employee-addressFIX" name="employee-address" placeholder="Nhập địa chỉ"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-phone" class="form-label">Số điện thoại</label>
          <input type="number" id="employee-phoneFIX" name="employee-phone" placeholder="Nhập số điện thoại"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="employee-position" class="form-label" style="color: red;">Chức vụ</label>
          <div class="role-container">
            <?php
            include 'PHP/config.php'; 
            // Lấy danh sách chức vụ từ bảng positions
            $sql = "SELECT id, name FROM positions ORDER BY id ASC";
            $result = $conn->query($sql);

            echo "<select name='position_id' class='position_id-select' id='positionSelectFIX' required>";
            echo "<option value=''>Chọn chức vụ</option>"; 
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
            } else {
              echo "<option value=''>Không có chức vụ nào!</option>"; 
            }
            echo "</select>";
            ?>
          </div>
        </div>

        <div class="form-group text-center">
          <button type="submit" id="accept-fixEP" class="form-button">Hoàn tất</button>
        </div>
      </form>
    </div>
  </div>

   <!-- Nhà cung cấp -->
   <div class="supplier-part">
    <div class="supplier-table-container">
      <div id="supplier-plus">Thêm nhà cung câp</div>
      <table class="supplier-table">
        <thead>
          <tr>
            <th>Mã nhà cung cấp</th>
            <th>Tên nhà cung cấp</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th id="setting-emp">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="supplier-table-body">
            <?php include 'PHP/SP-Manager.php'?>
        </tbody>
      </table>

      <form class="add-form-supplier" action="../../PHP/SP-Add.php" method="POST" enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-supplier"></i>

        <div class="form-group">
          <label for="supplier-name" class="form-label">Tên nhà cung cấp</label>
          <input type="text" id="supplier-name" name="supplier-name" placeholder="Nhập tên nhà cung cấp"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="supplier-phone" class="form-label">Số điện thoại</label>
          <input type="number" id="supplier-phone" name="supplier-phone" placeholder="Nhập số điện thoại"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="supplier-address" class="form-label">Địa chỉ</label>
          <input type="text" id="supplier-address" name="supplier-address" placeholder="Nhập địa chỉ"
            class="form-input" />
        </div>

        <div class="form-group text-center">
          <button type="submit" class="form-button" id="accept-addEP">Thêm nhà cung cấp</button>
        </div>
      </form>

      <form class="fix-form-supplier" id="fix-form-supplier" enctype="multipart/form-data">
        <input type="hidden" id="supplier-id" name="supplier-id">
        <i class="fa-solid fa-rotate-left back-supplier"></i>
        <div class="form-group">
          <label for="supplier-name" class="form-label">Tên nhà cung cấp</label>
          <input type="text" id="supplier-nameFIX" name="supplier-name" placeholder="Nhập tên nhà cung cấp"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="supplier-phone" class="form-label">Số điện thoại</label>
          <input type="number" id="supplier-phoneFIX" name="supplier-phone" placeholder="Nhập số điện thoại"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="supplier-address" class="form-label">Địa chỉ</label>
          <input type="text" id="supplier-addressFIX" name="supplier-address" placeholder="Nhập địa chỉ"
            class="form-input" />
        </div>

        <div class="form-group text-center">
          <button type="submit" id="accept-fixSP" class="form-button">Hoàn tất</button>
        </div>
      </form>
    </div>
  </div>

  <!--import-involces-part-->

  <div class="import-part">
    <div class="import-table-container">
      <div id="import-plus" >Thêm phiếu nhập</div>
      <table class="import-table">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã phiếu nhập</th>
            <th>Mã nhân viên</th>
            <th>Ngày nhập</th>
            <th>Trạng thái</th>
            <th>Xem chi tiết</th>
            <th id="setting-ip">Cài đặt</th>
          </tr>
        </thead>
        <tbody id="import-table-body">
        <?php include 'PHP/IP-Manager.php'?>
        </tbody>
      </table>

      <div class="import-receipt-container">
        <i class="fa-solid fa-rotate-left back-import"></i>
        <h2 class="receipt-title">Phiếu nhập hàng</h2>

        <!-- Tổng tiền -->
        <div class="total-section-ip">
          <label for="total-price-ip">Tổng tiền:</label>
          <span id="total-price-ip">0 VND</span>
        </div>

        <!-- Combobox Nhà cung cấp, Loại-->
        <div class="filter-section-ip">
          <select id="supplier-ip" class="form-select">
            <option value="">Chọn nhà cung cấp</option>
          </select>
        </div>

        <!-- Bảng sản phẩm -->
        <div class="product-table-section-ip">
          <table class="import-table-show">
            <thead>
              <tr>
                <th>Tên SP</th>
                <th>Ảnh sản phẩm</th>
                <th>Thể loại</th>
                <th>Giá bán</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>

        <!-- Nhập số lượng, giá nhập, % lãi -->
        <div class="selected-product-input-ip">
          <label for="quantity">Số lượng:</label>
          <input type="number" id="quantity" class="form-input" placeholder="Nhập số lượng" />

          <label for="import-price">Giá nhập:</label>
          <input type="number" id="import-price" class="form-input" placeholder="Nhập giá nhập" />

          <label for="profit-percent">% Lãi:</label>
          <input type="number" id="profit-percent" class="form-input" placeholder="" readonly/>

          <button id="add-product-btn-ip" class="form-button">Thêm sản phẩm</button>
        </div>

        <!-- Bảng sản phẩm đã được thêm vào phiếu nhập -->
        <div class="imported-product-list-section">
          <h3>Sản phẩm trong phiếu nhập</h3>
          <table class="import-table">
            <thead>
              <tr>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Giá nhập</th>
                <th>% Lãi</th>
                <th>Thành tiền</th>
                <th>Xóa</th>
              </tr>
            </thead>
            <tbody>
      
            </tbody>
          </table>
        </div>

        <!-- Nút thêm phiếu nhập -->
        <div class="submit-section-ip text-center">
          <button id="submit-import-btn"  class="form-button">Thêm phiếu nhập</button>
        </div>
      </div>

      <div id="delete-overlay-import">
        <div class="delete-container">
          <span>Bạn muốn xóa phiếu nhập?</span>
          <button id="delete-acp-import">Xác nhận</button>
          <button id="cancel-import">Hủy</button>
        </div>
      </div>

      <div class="import-detail-container">
        <i class="fa-solid fa-rotate-left back-import"></i>
        <h3 style="margin-bottom: 10px;">Chi tiết</h3>
        <div class="import-info">
          <div class="info-row-ip">
            <span><strong>Mã phiếu nhập:</strong></span>
            <span><strong>Mã nhân viên:</strong></span>
          </div>
          <div class="info-row-ip">
            <span><strong>Ngày nhập:</strong></span>
            <span><strong>Trạng thái:</strong></span>
          </div>
          <div class="info-row-ip">
            <span><strong>Tổng tiền:</strong></span>
          </div>
        </div>

        <div class="imported-product-list-section">
          <h4>Sản phẩm trong phiếu nhập</h4>
          <table class="import-table">
            <thead>
              <tr>
                <th>Tên SP</th>
                <th>Số lượng</th>
                <th>Giá nhập</th>
                <th>% Lãi</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <tr>
          
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- inventory part -->
  <div class="inventory-part">
    <div class="inventory-table-container">
      <table class="inventory-table">
        <thead>
          <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Mã phiếu nhập</th>
            <th>Ngày nhập</th>
            <th>Serial</th>
          </tr>
        </thead>
        <tbody id="inventory-table-body">
          <?php include 'PHP/IV-Manager.php'?>
        </tbody>
      </table>
    </div>
  </div>


  <script src="js/admin/admin.js"></script>
  <script src="js/admin/PD-Ajax.js"></script>
  <script src="js/admin/PM-Ajax.js"></script>
  <script src="js/admin/AC-Ajax.js"></script>
  <script src="js/admin/CU-Ajax.js"></script>
  <script src="js/admin/EP-Ajax.js"></script>
  <script src="js/admin/Logout_admin.js"></script>
  <script src="js/admin/PD-getCategory_ajax.js"></script>
  <script src="js/admin/OD-ajax.js"></script>
  <script src="js/admin/OD-getAddress_ajax.js"></script>
  <script src="js/admin/ST-ajax.js"></script>
  <script src="js/admin/SP-ajax.js"></script>
  <script src="js/admin/IP-ajax.js"></script>

  <script>
  window.adminInfo = <?php echo json_encode($_SESSION['adminInfo']); ?>;
  console.log('Admin Info:', window.adminInfo);

  const functionsMap = window.adminInfo.functions_map;
  console.log('Admin Functions Map:', functionsMap);

  // Mapping tên chức năng -> ID menu tương ứng
  const functionToMenuId = {
      "Thống kê": "admin-statistic",
      "Đơn hàng": "admin-oder",
      "Sản phẩm": "admin-product",
      "Khách hàng": "admin-customer",
      "Nhân viên": "admin-employee",
      "Quản lí tài khoản": "admin-account",
      "Quản lí quyền": "admin-role",
      "Nhập hàng": "admin-import",
      "Nhà cung cấp": "admin-supplier",
      "Quản lí tồn kho": "admin-inventory"
  };

  // Mapping chức năng -> tiền tố id
  const functionPrefix = {
      "Nhân viên": "employee",
      "Sản phẩm": "product",
      "Đơn hàng": "order",
      "Khách hàng": "customer",
      "Quản lí tài khoản": "account",
      "Quản lí quyền": "role",
      "Nhập hàng": "import",
      "Nhà cung cấp": "supplier",
      "Quản lí tồn kho": "inventory"
  };

  document.addEventListener("DOMContentLoaded", () => {
      for (const [functionName, actions] of Object.entries(functionsMap)) {
          console.log(`Function: ${functionName}`);
          console.log(`Actions: ${actions.join(', ')}`);

          // Hiển thị module nếu có bất kỳ quyền nào (AC1, AC2, AC3, AC4)
          if (actions.includes("AC1") || actions.includes("AC2") || actions.includes("AC3") || actions.includes("AC4")) {
              const menuId = functionToMenuId[functionName];
              if (menuId) {
                  document.getElementById(menuId)?.style.setProperty("display", "inline-block");
              }
          }

          // Xử lý các quyền còn lại
          const prefix = functionPrefix[functionName];
          if (prefix) {
            // AC2: Add
            const addBtn = document.getElementById(`${prefix}-plus`);
            if (addBtn) {
                addBtn.style.display = actions.includes("AC2") ? "block" : "none";
            }

            // AC3: Edit
            const editBtns = document.getElementsByClassName(`fix-btn-${prefix}`);
            for (let btn of editBtns) {
                btn.style.display = actions.includes("AC3") ? "inline-block" : "none";
            }

            // AC4: Delete
            const deleteBtns = document.getElementsByClassName(`delete-btn-${prefix}`);
            for (let btn of deleteBtns) {
                btn.style.display = actions.includes("AC4") ? "inline-block" : "none";
            }
          }
      }
  });
  // document.getElementById("admin-account").style.display = "block";
  // document.getElementById("admin-role").style.display = "block";

</script>


</body>

</html>