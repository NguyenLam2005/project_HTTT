<?php
    include 'config.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST'&&isset($_POST['id'])){
        $id = $_POST['id'];
        $drop_IMGPD = ("SELECT image FROM products where id =$id");
        $drop_IMGPD = $conn->query($drop_IMGPD);
        $row = $drop_IMGPD->fetch_assoc();
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . $row['image'];
        $PD_delete=("DELETE FROM products where id = $id");
        if ($conn->query($PD_delete) === TRUE) {
            if ($row['image'] != "/Dolce-bakery/assest/PD-Manager/Default.jpg") {
                unlink($imagePath);
            }            
            
            echo json_encode(["success" => true]);
    
        } else {
            echo json_encode(["success" => false]); 
        }
        $conn->close();
        exit;
    }

?>