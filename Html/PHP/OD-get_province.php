<?php
     include 'config.php';
     $sql = "SELECT id, name FROM provinces ORDER BY id ASC";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
         echo "<option value='{$row['id']}'>{$row['name']}</option>";
       }
     } else {
       echo "<option value=''>Không có trạng thái nào!</option>"; 
     }
     echo "</select>";
?>