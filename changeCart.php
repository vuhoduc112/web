<?php
session_start();
//change quantity
if(isset($_GET['qtt']) && isset($_GET['id'])){
    $cid = $_GET['id'];
    if($_GET['qtt'] <= 0) { //force quantity to be atleast 1
        $_GET['qtt'] = 1;
    }
    $_SESSION['customerCart'][$cid]['qtt'] = $_GET['qtt'];
    $_SESSION['customerCart'][$cid]['subtotal'] = $_GET['qtt']*$_SESSION['customerCart'][$cid]['price'];
    if(isset($_GET['sum'])){
        $_SESSION['totalCart'] = $_GET['sum'];
    }
}
//remove item
if(isset($_GET['removeID'])){
    $rid = $_GET['removeID'];
    $_SESSION['totalCart'] = $_SESSION['totalCart'] - $_SESSION['customerCart'][$rid]['subtotal'];
    unset($_SESSION['customerCart'][$rid]);
}
