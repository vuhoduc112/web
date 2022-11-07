<?php
session_start();
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
require 'adminFunction.php';
if (isset($_POST['add'])) {
    if (empty($_POST['pname'])) {
        $_SESSION['error'] = "You must enter product name.";
        header("location: admin_panel.php?page=product");
    }
    if ($_POST['category'] == 0) {
        $_SESSION['error'] = "You must choose a category.";
        header("location: admin_panel.php?page=product&pname={$_POST['pname']}");
    }
    if (empty($_POST['price'])) {
        $_SESSION['error'] = "You must enter unit price for the product.";
        header("location: admin_panel.php?page=product&pname={$_POST['pname']}&category={$_POST['category']}");
    }
    if ($_FILES['avatar']['name'] == '') {
        $_SESSION['error'] = "You must choose a picture for the product.";
        header("location: admin_panel.php?page=product&pname={$_POST['pname']}&category={$_POST['category']}&price={$_POST['price']}");
    } else {
        $findExt = explode('.', $_FILES['avatar']['name']); 
        $ext = strtolower(end($findExt));
        $allowExt = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $allowExt)) {
            $_SESSION['error'] = "Invalid image file type.";
            header("location: admin_panel.php?page=product&pname={$_POST['pname']}&category={$_POST['category']}&price={$_POST['price']}");
        } else {
            $pname = filter_var($_POST['pname'], FILTER_SANITIZE_STRING);
            $category = $_POST['category'];
            $price = $_POST['price'];
            $detail = $_POST['detail'];
            
            $file = $_FILES['avatar'];
            $pathUpload = "../imgs/";
            $path = "imgs/";
            $fileName = uniqid().$file['name'];
            $tmp_name = $file['tmp_name'];
            move_uploaded_file($tmp_name, $pathUpload.$fileName);
            $imgURL = $path.$fileName;
            $result = admin_AddProduct($pname, $price, $detail, $category, $imgURL);
            if($result === TRUE) {
                $_SESSION['success'] = "New product added.";
            } else {
                $_SESSION['error'] = $result;
            }
            header("location: admin_panel.php?page=product");
        } 
    }
}