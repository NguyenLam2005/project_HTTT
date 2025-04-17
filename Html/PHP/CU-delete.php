<?php
    include 'config.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST'&&isset($_POST['id'])){
        $id = $_POST['id'];
        $CU_delete=("DELETE FROM customers where id = $id");
        if ($conn->query($CU_delete) === TRUE) {
            echo json_encode(["success" => true]);
            
        } else {
            echo json_encode(["success" => false]); 
        }
        $conn->close();
        exit;
    }

?>