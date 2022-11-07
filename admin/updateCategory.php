<?php
session_start();
require_once "adminFunction.php";
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_SESSION['errUpdate'])) {
    unset($_SESSION['errUpdate']);
}
if(isset($_POST['save'])){
    $id = $_POST['cid'];
    $name = $_POST['name'];
    $detail = htmlspecialchars($_POST['detail']);
    $unit = htmlspecialchars($_POST['unit']);
    $status = $_POST['status'];
    $result = admin_updateCategory($id,$name, $detail, $unit, $status);
    
    if($result !== TRUE){
        $_SESSION['errUpdate'] = $result;
        print_r($result);
    } else {
        $_SESSION['success'] = "Category update successfully.";
    }
    header ("location: admin_panel.php?page=category");
}
?>