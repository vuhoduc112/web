<?php
    session_start();
    require 'adminFunction.php';
    if (isset($_POST['login'])) {
        if (empty($_POST['uname']) || empty($_POST['pass'])) {
            $_SESSION['error'] = "You must enter username and password.";
            header ("location: index.php");
        } else {
            $uname = $_POST['uname'];
            $pass = $_POST['pass'];
            $login = adminLogin($uname, $pass);
            if(empty($login['error'])) {
                $_SESSION['account'] = $login;
                header("location: admin_panel.php");
            } else {
                $_SESSION['error'] = $login['error'];
                header ("location: index.php");
            }
        }
    }
?>