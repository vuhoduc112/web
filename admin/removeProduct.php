<?php
    session_start();
    include 'adminFunction.php';
    if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 1) {
        if(isset($_GET['id'])) {
            $pid = $_GET['id'];
            admin_removeProduct($pid);
            $_SESSION['success'] = "Product removed.";
            header ("location: admin_panel.php");
        }
    } else {

    }
?>
