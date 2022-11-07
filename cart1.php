<?php
session_start();
require_once 'admin//adminFunction.php';
if(isset($_GET['id'])){ //the request sent by js retrieved here
    $productID = $_GET['id'];
    $conn = connect();
    $result = $conn->query("SELECT * FROM product WHERE productID = {$_GET['id']}");
    $product = $result->fetch_object();
    $conn->close();
    //initiate cart array if not exist:
    if(!isset($_SESSION['customerCart'])){
        $_SESSION['customerCart'] = array();
    }
    $_SESSION['customerCart'][$productID]['id'] = $productID;
    $_SESSION['customerCart'][$productID]['name'] = $product->productName;
    $_SESSION['customerCart'][$productID]['price'] = $product->unitPrice;
    $_SESSION['customerCart'][$productID]['qtt'] = 1;
    $_SESSION['customerCart'][$productID]['subtotal'] = $product->unitPrice * $_SESSION['customerCart'][$productID]['qtt'];
    $total = 0;
    foreach($_SESSION['customerCart'] as $item){
        $total += $item['subtotal'];
    }
    $_SESSION['totalCart'] = $total;
    //print the cart table, this will be returned to the product page by the ajax callback function:
    echo "
        <tr class='cart-row'>
            <td class='item-img'>
                <img src='{$product->imgURL}' alt='image'>
                <span class='item-name'>{$product->productName}</span>
                <input type='hidden' name='itemName' value='{$product->productName}'>
                <input type='hidden' name='itemId' value='{$product->productID}'>
            </td>
            <td>
                $<span class='item-price'>{$product->unitPrice}</span>
                <input type='hidden' name='itemPrice' class='price' value='{$product->unitPrice}'>
            </td>
            <td>
                <input style='max-width:50px' name='itemQuantity' type='number' min='1' step='1' value='1' class='quantity-input' data-id='{$productID}'>
            </td>
            <td>
                <input type='hidden' value='{$product->unitPrice}' class='subtotal'>
                $<span class='visible-subtotal'>{$_SESSION['customerCart'][$productID]['subtotal']}</span>
            </td>
            <td>
                <button data-id='{$product->productID}' class='remove btn btn-danger'>Xoá</button>
            </td>
        </tr>
    ";
    
}
?>