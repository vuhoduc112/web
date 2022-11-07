<?php
session_start();
require_once "adminFunction.php";
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_SESSION['errUpdate'])) {
    unset($_SESSION['errUpdate']);
}
if(isset($_POST['add'])){
    if($_FILES['picture']['name'] == ''){
        $_SESSION['error'] = "You must choose an image";
        header("location: admin_panel.php?page=gallery");
    } else {
        $file = $_FILES['picture'];
        $findExt = explode('.',$file['name']);
        $ext = strtolower(end($findExt));
        $allowExt = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowExt)) {
            $_SESSION['error'] = "Invalid image file type.";
            header("location: admin_panel.php?page=gallery");
        } else {
            $pathUpload = "../imgs/gallery/";
            $path = "imgs/gallery/";
            $fileName = uniqid().$file['name']; #generate unique file name
            $tmp_name = $file['tmp_name'];
            $fileErr = $file['error'];
            
            move_uploaded_file($tmp_name, $pathUpload.$fileName);
            $imgURL = $path.$fileName;
            $category = $_POST['category'];

            $result = admin_updateGallery($imgURL, $category);
            
            if($result === true) {
                $_SESSION['success'] = "Gallery updated successfully.";
            } else {
                $_SESSION['errUpdate'] = $result;
            }
            header ("location: admin_panel.php?page=gallery");
        }
    }
}
?>