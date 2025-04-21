<?php
            include '../Html/PHP/config.php';
            $sql = "SELECT id, name FROM orderstatus ORDER BY id ASC";
            $result = $conn->query($sql);
            echo "<select name='order-status' class='orderstatus-select' id='filter-status' required>";
            echo "<option value='0'>Tất cả</option>";
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
              }
            } else {
              echo "<option value=''>Không có trạng thái nào!</option>"; 
            }
            echo "</select>";
          ?> 



<?php
            require_once '../Html/PHP/AC-Manager.php'; // Kết nối database
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



<?php
            require_once '../Html/PHP/PM-Manager.php'; // Kết nối database
            
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



<?php
            require_once '../Html/PHP/EP-Manager.php'; 
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