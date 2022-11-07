<?php
    require_once 'adminFunction.php';
    if(isset($_GET['pic'])){
        $id = $_GET['pic'];
        $conn = connect();
        $result = $conn->query("SELECT * FROM gallery WHERE id = '$id'");
        $img = $result->fetch_object();
        //delete image:
        unlink('../'.$img->imgURL);
        $conn->query("DELETE FROM gallery WHERE id = '$id'");
        $conn->close();
        header("location: admin_panel.php?page=gallery");
    }
?>