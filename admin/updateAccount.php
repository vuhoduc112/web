<?php
session_start();
require_once "adminFunction.php";

if (isset($_SESSION['account'])) {
    $user = $_SESSION['account'];
}
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}

if (isset($_POST['upemail'])) {
    $result = user_updateEmail($user['userID'], $_POST['email']);
    if ($result === TRUE) {
        $_SESSION['success'] = "Email updated!";
        header("location: admin_panel.php?page=account");
    } else {
        $_SESSION['error'] = $result;
        header("location: admin_panel.php?page=account");
    }
}

if (isset($_POST['uppass'])) {
    $result = user_changePass($user['userID'], $_POST['oldpass'], $_POST['newpass'], $_POST['repass']);
    if ($result === TRUE) {
        $_SESSION['success'] = "Password updated!";
        header("location: admin_panel.php?page=account");
    } else {
        $_SESSION['error'] = $result;
        header("location: admin_panel.php?page=account");
    }
}
