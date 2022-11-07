<?php
    session_start();
    require 'adminFunction.php';
    if(isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['error1'])) {
        unset($_SESSION['error1']);
    }
    if(isset($_SESSION['error2'])) {
        unset($_SESSION['error2']);
    }

    if(isset($_POST['addUser'])) {
        $uname = $_POST['uname'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];

        $result = admin_addUser($uname, $email, $pass, $repass, $role);

        if($result === TRUE) {
            $_SESSION['success'] = "Đã thêm tài khoản mới.";
        } elseif ($result === FALSE) {
            $_SESSION['error1'] = "Không thể thêm tài khoản.";
        } else {
            $_SESSION['error2'] = $result;
        }
        header ("location: admin_panel.php?page=user");
    }
?>