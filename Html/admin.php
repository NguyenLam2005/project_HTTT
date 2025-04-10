<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopDongHo</title>
  <link rel="stylesheet" href="../Html/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <div class="sidebar">
    <h2 id="admin">Admin</h2>
    <a href="#">Thống kê</a>
    <a href="#" id="admin-oder">Đơn hàng</a>
    <a href="#" id="admin-product">Sản phẩm</a>
    <a href="#" id="admin-customer">Khách hàng</a>
    <a href="#" id="admin-account">Quản lí tài khoản</a>
    <a href="#" id="admin-role">Quản lí quyền</a>

    <img src="../Html/img/logo-icon.png" alt="hahaha" />
  </div>

  <div class="admin-main">
    <div class="admin-header">
      <div class="profile">
        <span>Admin 1</span>
        <img src="../Html/img/account-logo.png" alt="" id="profile" />
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
        <!-- <img src="../../assest/admin.jpg" alt="" class="avatar" /> -->
        <div class="user-info">
          <h2>Admin 1</h2>
        </div>
      </div>
      <ul class="menu-profile">
        <li><a href="#">Thông tin cá nhân</a></li>
        <li>
          <a href="#">Quyền hạn: <span>Admin</span></a>
        </li>
        <li><a href="#">Lịch sử hoạt động</a></li>
        <li><a href="#">Quản lý quyền</a></li>
      </ul>
      <button class="logout-btn-admin">Đăng xuất</button>
    </div>
  </div>

  <div class="oder-part">
    <div class="order-table-container">
      <table class="order-table">
        <thead>
          <tr>
            <th>Tên KH</th>
            <th>Mã KH</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
            <th>Xem chi tiết</th>
            <th>Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td>Nguyễn</td>
            <td>01</td>
            <td>2</td>
            <td>500,000 VND</td>
            <td><i class="fa-solid fa-circle-info"></i></td>
            <td>Đã xử lý</td>
          </tr>
          <tr>
            <td>Mai</td>
            <td>02</td>
            <td>3</td>
            <td>150,000 VND</td>
            <td><i class="fa-solid fa-circle-info"></i></td>
            <td>Chưa xử lý</td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
  <!-- ----------------------------PRODUCT----------------------------- -->
  <div class="product-part">
    <div class="product-table-container">
      <div id="product-plus">Thêm sản phẩm</div>
      <table class="product-table">
        <thead>
          <tr>
            <th style="text-align: center">Hình ảnh sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Loại</th>
            <th>Số lượng</th>
            <th>Giá tiền</th>
            <th>Cài đặt</th>
          </tr>
        </thead>
        <tbody id="product-table-body">
          <!-- <?php include '../../PHP/PD-Manager.php'; ?> -->
        </tbody>
      </table>

      <form class="add-form-product" action="../../PHP/PD-Add.php" method="POST" enctype="multipart/form-data">
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
          <label for="product-type" class="form-label">Loại sản phẩm</label>
          <select id="product-type" name="product-type" class="form-select">
            <option value="">-- Chọn loại sản phẩm --</option>
            <option value="cake">Bánh kem</option>
            <option value="bread">Bánh mì</option>
            <option value="cookie">Cookies</option>
          </select>
        </div>

        <div class="form-group">
          <label for="product-quantity" class="form-label">Số Lượng</label>
          <input type="number" id="product-quantity" name="product-quantity" placeholder="Nhập số lượng"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-price" class="form-label">Giá Tiền (VNĐ)</label>
          <input type="number" id="product-price" name="product-price" placeholder="Nhập giá tiền" class="form-input" />
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
          <input type="file" id="product-image" onchange="uploadImg(this)" name="product-image" class="form-input" accept="image/*" />
        </div>

        <div class="form-group">
          <label for="product-name" class="form-label">*Tên sản phẩm</label>
          <input type="text" id="product-nameFIX" name="product-name" placeholder="Nhập tên sản phẩm" class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-type" class="form-label">*Loại sản phẩm</label>
          <select id="product-typeFIX" name="product-type" class="form-select">
            <option value="">-- Chọn loại sản phẩm --</option>
            <option value="cake">Bánh kem</option>
            <option value="bread">Bánh mì</option>
            <option value="cookie">Cookies</option>
          </select>
        </div>

        <div class="form-group">
          <label for="product-quantity" class="form-label">*Số Lượng</label>
          <input type="number" id="product-quantityFIX" name="product-quantity" placeholder="Nhập số lượng"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-price" class="form-label">*Giá Tiền (VNĐ)</label>
          <input type="number" id="product-priceFIX" name="product-price" placeholder="Nhập giá tiền" class="form-input" />
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
            <!-- <th>Email</th>
            <th>Địa chỉ</th> -->
            <th>Cài đặt</th>
          </tr>
        </thead>
        <tbody id="customer-table-body">
          <!-- <?php include '../../PHP/CU-Manager.php'?> -->
        </tbody>
      </table>

      


      <!-- <form class="add-form-customer">
        <i class="fa-solid fa-rotate-left back-customer"></i>

        <div class="form-group">
          <label for="product-id" class="form-label">Mã khách hàng</label>
          <input type="text" id="customer-id" name="customer-id" placeholder="Nhập mã KH" class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-name" class="form-label">Tên khách hàng</label>
          <input type="text" id="customer-name" name="customer-name" placeholder="Nhập tên khách hàng"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="product-phone" class="form-label">Số điện thoại</label>
          <input type="text" id="customer-phone" name="customer-phone" placeholder="Nhập SĐT khách hàng"
            class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-email" class="form-label">Email</label>
          <input type="email" id="customer-email" name="customer-email" placeholder="Nhập email" class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-address" class="form-label">Địa chỉ</label>
          <input type="text" id="custommer-address" name="customer-address" placeholder="Nhập địa chỉ"
            class="form-input" />
        </div>

        <div class="form-group text-center">
          <button type="submit" class="form-button">Thêm Khách Hàng</button>
        </div>
      </form> -->

      <form class="fix-form-customer" id="fix-form-customer" enctype="multipart/form-data">
        <i class="fa-solid fa-rotate-left back-customer"></i>

        <div class="form-group">
          <label for="customer-id" class="form-label">Mã khách hàng</label>
          <input type="text" id="customer-id" name="customer-id" placeholder="Nhập mã KH" class="form-input" />
        </div>

        <div class="form-group">
          <label for="customer-uname" class="form-label">Tên đăng nhập</label>
          <input type="text" id="customer-uname-f" name="customer-uname" placeholder="Nhập tên đăng nhập" class="form-input" />
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
            <th>Email</th>
            <th>Trạng thái</th>
            <th>Quyền</th>
            <th>Cài đặt</th>
          </tr>
        </thead>
        <tbody id="account-table-body">
          
          <?php
          // include '../../PHP/AC-Manager.php';
          ?>
        </tbody>
      </table>

      <div id="role-popup">
        <div>Chức năng 1</div>
        <div>Chức năng 2</div>
        <div>Chức năng 3</div>
        <div class="popup-arrow">
        </div>
      </div>






      <form class="add-form-account" action="../../PHP/AC-Add.php" method="POST" enctype="multipart/form-data">
    <i class="fa-solid fa-rotate-left back-account"></i>
    <div class="form-group">
        <label for="account-name" class="form-label">Tên đăng nhập</label>
        <input type="text" id="account-name" name="account-name" placeholder="Nhập tên" class="form-input" required />
    </div>

    <div class="form-group">
        <label for="account-pass" class="form-label">Mật khẩu</label>
        <input type="password" id="account-pass" name="account-pass" placeholder="Nhập mật khẩu" class="form-input" required />
    </div>

    <div class="form-group">
        <label for="account-email" class="form-label">Email</label>
        <input type="email" id="account-email" name="account-email" placeholder="Nhập email" class="form-input" required />
    </div>

    <div class="form-group">
        <label for="account-role" class="form-label" style="color: red;">Cấp quyền</label>
        <div class="role-container">
            <?php
            require_once '../../PHP/AC-Manager.php'; // Kết nối database

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


      <form class="fix-form-account" id="fix-form-account" action="../../PHP/AC-Edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="account-id-f" name="account-id">
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
          <label for="account-email" class="form-label">Email</label>
          <input type="text" id="account-email-f" name="account-email" placeholder="Nhập email" class="form-input" />
        </div>

        <div class="form-group">
          <label for="account-role" class="form-label" style = "color: red;">Cập nhật quyền</label>
          <div class = role-container>
          <?php
            require_once '../../PHP/AC-Manager.php'; // Kết nối database

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

  <!-- ROLEEEEEEEEEEEEEEEEEEEEEEEEEEE -->

  <div class="role-part">
    <div class="role-table-container">
    <!-- <div id="account-overlay-role">
        <div class="account-role-container">
          <img src="../../assest/Chevron down.png" alt="">
          <div class="list-user-role">
            <div class="user-role">user1</div>
            <div class="user-role">user2</div>
            <div class="user-role">user4</div>
            <div class="user-role">user5</div>
            <div class="user-role">user6</div>
            <div class="user-role">user7</div>
            <div class="user-role">user8</div>
            <div class="user-role">user9</div>
            <div class="user-role">usera</div>
            <div class="user-role">userb</div>
            <div class="user-role">userc</div>
            <div class="user-role">userd</div>
            <div class="user-role">usere</div>
            <div class="user-role">userf</div>
            <div class="user-role">userg</div>
            <div class="user-role">userh</div>
            <div class="user-role">userj</div>
          </div>
        </div> -->
      <!-- </div> -->
      
     <div id="role-plus">Thêm quyền</div>

      <table class="role-table">
        <thead>
          <tr>
            <th style="text-align: center">Quyền</th>
            <th>Chức năng</th>
            <th>Số lượng TK</th>
            <th>Danh sách tài khoản</th>
            <th>Cài đặt</th>
          </tr>
        </thead>
        <tbody id="role-table-body">
          <?php
            // include '../../PHP/PM-Manager.php';
           ?>
        </tbody>
      </table>

     

      <form class="add-form-role" id="add-form-role" action="../../PHP/PM-Add.php" method="POST" enctype="multipart/form-data">
    <i class="fa-solid fa-rotate-left back-role"></i>
    <div class="form-group">
        <label for="role-name" class="form-label">Tên quyền</label>
        <input type="text" id="role-name" name="role-name" placeholder="Nhập tên" class="form-input" required />
    </div>

    <!-- Danh sách chức năng -->
    <div class="form-group">
        <label for="account-role" class="form-label" style="color: red;">Chức năng</label>
        <div class="role-container">
            <?php
            require_once '../../PHP/PM-Manager.php'; // Kết nối database

            // Lấy  chức năng từ database
            $sql = "SELECT id, name FROM functions ORDER BY id ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='check-role'>
                        <input type='checkbox' class='permission-checkbox' value='{$row['id']}' name='permissions[]'>
                        <label>{$row['name']}</label>
                    </div>";
                }
            } else {
                echo "<p>Không có chức năng nào!</p>";
            }
            ?>
        </div>
    </div>

    <!-- Nút thêm quyền -->
    <div class="form-group text-center">
        <button type="submit" class="form-button">Thêm quyền</button>
    </div>
</form>




<form id="fix-form-role" class="fix-form-role" action="../../PHP/PM-Edit.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="role-id-f" name="role-id">
    <i class="fa-solid fa-rotate-left back-role"></i>
    <div class="form-group">
        <label for="role-name" class="form-label">Tên quyền</label>
        <input type="text" id="role-name-f" name="role-name" placeholder="Nhập tên" class="form-input" />
    </div>
    <div class="form-group">
        <label for="account-role" class="form-label" style="color: red;">Chức năng</label>
        <div class="role-container">
            <?php
            require_once '../../PHP/PM-Manager.php'; // Kết nối database
            // Lấy chức năng từ database
            $sql = "SELECT id, name FROM functions ORDER BY id ASC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='check-role'>
                        <input type='checkbox' class='permission-checkbox' value='{$row['id']}' name='permissions[]'>
                        <label>{$row['name']}</label>
                    </div>";
                }
            } else {
                echo "<p>Không có chức năng nào!</p>";
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


  <script src="../Html/js/admin/admin.js"></script>
  <!-- <script src="../../JS/PD-editAjax"></script> -->
  <!-- <script src="../../JS/admin/PD-Ajax.js"></script>
  <script src="../../JS/admin/PM-Ajax.js"></script>
  <script src="../../JS/admin/AC-Ajax.js"></script>
  <script src="../../JS/admin/CU-Ajax.js"></script> -->



</body>

</html>