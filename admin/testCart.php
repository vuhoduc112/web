<?php
session_start();
if(!isset($_SESSION['cart1'])){
    $_SESSION['cart1'] = array();
}
$count = count($_SESSION['cart1']);

if($_SERVER['REQUEST_METHOD']=='GET'){
    $_SESSION['cart1'][$_GET['id']]['id'] = $_GET['id'];
    $_SESSION['cart1'][$_GET['id']]['qtt'] = $_GET['qtt'];
    echo "
    <table>
    <thead>
    <tr>
        <td>ID</td>
        <td>Quantity</td>
    </tr>
    </thead>
    ";
    foreach($_SESSION['cart1'] as $item){
        echo "
        <tbody>
        <tr>
            <td>{$item['id']}</td>
            <td>{$item['qtt']}</td>
        </tr>
        </tbody>
        ";
    }
    echo "</table>";
    echo "<hr>";
    print_r($_SESSION['cart1']);
}
?>