<?php
session_start();
if (isset($_SESSION['errUpdate'])) {
    unset($_SESSION['errUpdate']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}

require 'adminFunction.php';
if (isset($_POST['save'])) {
    $conn = connect();
    $pid = $_POST['pid'];
    $pname = filter_var($_POST['pname'], FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $price = $_POST['price'];
    $detail = $_POST['detail'];
    $status = $_POST['status'];
    
    $imgURL = '';
    $errorImg = 0;
    $file = $_FILES['avatar'];
    if ($file['name'] == '') {
        $imgURL = '';
        $errorImg = 0;
    } else {
        $findExt = explode('.', $file['name']);
        $ext = strtolower(end($findExt));
        $allowExt = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowExt)) {
            $errorImg = 'Invalid file type. The image format must be JPG, PNG or GIF.';
        } elseif($file['size'] > 5000000) {
            $errorImg = 'File is too large. Please reduce file size less than 5MB.';
        } else {
            $errorImg = 0;
            $pathUpload = "../imgs/";
            $path = "imgs/";
            $fileName = uniqid().$file['name']; //generate an unique name for the file uploaded
            $tmp_name = $file['tmp_name'];
            move_uploaded_file($tmp_name, $pathUpload . $fileName);
            $imgURL = $path . $fileName;
        }
        // echo $errorImg.'<br>';
        // echo $ext.'<br>';
        // echo $file['name'].'<br>';
        // echo $file['error'].'<br>';
        // echo $file['size'].'<br>';
    }

    // exit();
    //Return true if success or an array of errors
    $updateResult = admin_updateProduct($pid, $pname, $price, $category, $detail, $imgURL, $status);

    if ($errorImg === 0) {
        if ($updateResult === true) {
            $_SESSION['success'] = 'Sản phẩm được cập nhập thành công.';
            header("location: admin_product.php");
        } else if ($updateResult !== true) {
            $_SESSION['errUpdate'] = array_merge_recursive($updateResult);
        }
    } else {
        if ($updateResult === true) {
            $_SESSION['errUpdate']['img'] = $errorImg;
        } else {
            $_SESSION['errUpdate'] = array_merge_recursive($updateResult);
            array_push($_SESSION['errUpdate'], $errorImg);
        }
    }
    // print_r ($_SESSION['errUpdate']);
    header("location: admin_panel.php?page=product");
}
//OK