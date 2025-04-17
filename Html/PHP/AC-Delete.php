<?php
    include 'config.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST'&&isset($_POST['id'])){
        $id = $_POST['id'];
        $AC_delete=("DELETE FROM employeeaccount where id = $id");
        if ($conn->query($AC_delete) === TRUE) {
            echo json_encode(["success" => true]);
            
        } else {
            echo json_encode(["success" => false]); 
        }
        $conn->close();
        exit;
    }

?>