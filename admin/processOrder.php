<?php
session_start();
require 'adminFunction.php';
if(isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
if (isset($_SESSION['account'])) {
    $uid = $_SESSION['account']['userID'];
    $role = $_SESSION['account']['userRole'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = connect();
    $orderID = $_POST['orderID'];
    $orderStatus = $_POST['orderStatus'];

    //Check if the current order has been processed by someone or not
    if ($orderStatus != 'pending') {
        //if the order was not processed by the current user:
        $checkID = $conn->query("SELECT staffID FROM orders WHERE staffID = '$uid' AND orderID = '$orderID'");
        if ($checkID->num_rows == 0 ) {
            if($role != 1) {
                $_SESSION['error'] = "Warning: Unauthorized operation!\\nThe current order was processed by someone else, you must be an administrator to change it status.";
                header ("location: admin_panel.php?page=home");
                exit();
            }
        }
    }
    if (isset($_POST['success'])) {
        $sql = "UPDATE orders SET orderStatus = 'success', staffID = '$uid' WHERE orderID ='$orderID'";
        $conn->query($sql);
    }
    if (isset($_POST['cancel'])) {
        $sql = "UPDATE orders SET orderStatus = 'cancel', staffID = '$uid' WHERE orderID ='$orderID'";
        $conn->query($sql);
    }
    $conn->close();
    header("location: admin_panel.php?page=home");
}
