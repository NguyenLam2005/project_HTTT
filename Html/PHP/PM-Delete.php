<?php
    include __DIR__ . '/config.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST'&&isset($_POST['id'])){
        $id = $_POST['id'];
        $PM_delete=("DELETE FROM permissions where id = $id");
        if ($conn->query($PM_delete) === TRUE) {
            echo json_encode(["success" => true]);

        } else {
            echo json_encode(["success" => false]); 
        }
        $conn->close();
        exit;
    }

?>