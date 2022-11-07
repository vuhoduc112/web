<?php
    session_start();
    if(isset($_SESSION['error1'])){
        unset($_SESSION['error1']);
    }
    if(isset($_SESSION['error2'])){
        unset($_SESSION['error2']);
    }
    if(isset($_SESSION['success'])){
        unset($_SESSION['success']);
    }
    $result = '';
    require 'adminFunction.php';
    if(isset($_POST['save'])){
        $uid = $_POST['uid'];
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $pass = $_POST['resetpass'];
        $repass = $_POST['confirmpass'];
        $role = $_POST['role'];
        $status = $_POST['status'];
        if($_SESSION['account']['userID'] != 1 && $uid == 1) {
            $_SESSION['error1'] = "You dont have permission to update the root admin account.";
            header ("location: admin_panel.php?page=user");
        } else {
            $result = admin_updateUser($uid, $uname, $email, $pass, $repass, $role, $status);
        }
        
        if($result===TRUE){
            $_SESSION['success'] = "User account update successfully.";
            header ("location: admin_panel.php?page=user"); 
        } else {
            $_SESSION['error2'] = $result;
            header ("location: admin_panel.php?page=user");
        }
    }

?>