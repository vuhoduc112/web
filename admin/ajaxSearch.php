<?php
require 'adminFunction.php';

if(isset($_REQUEST['searchvalue'])){
    $search = $_REQUEST['searchvalue'];
    $conn = connect();
    $data = "";
    $sql = "SELECT pd.imgURL, pd.productID, pd.productName, ct.categoryName, pd.productDetail, pd.unitPrice, pd.stock 
    FROM product as pd 
    INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
    WHERE pd.productName LIKE CONCAT('%', '$search', '%') OR ct.categoryName LIKE CONCAT('%', '$search', '%')
    ORDER by ct.categoryName
    ";
    $list = $conn->query($sql);
    if($list->num_rows>0) {
        $data.="
        <table class='tbl table table-striped table-hover'>
                <tr class='head'>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Chi tiết sản phẩm</th>
                    <th>Giá</th>
                    <th>Trong kho</th>
                    <th colspan='2'>Quản lý</th>
                    
                </tr>
        ";
        while($item = $list->fetch_assoc()){
            $data .= "
                <tr>
                    <td><img src=\"..\\{$item['imgURL']}\" alt=\"image\" style=\"width:50px; height:50px;\"></td>
                    <td>{$item['productName']}</td>
                    <td>{$item['categoryName']}</td>
                    <td>{$item['productDetail']}</td>
                    <td>{$item['unitPrice']}</td>
                    <td>{$item['stock']}</td>
                    <td class='edit'><button class='item-list btn btn-success edit-product' data-bs-toggle='modal' data-id='{$item['productID']}' data-bs-target='#editPanel'>Thay đổi</button></td>
                </tr>
            
            ";
        }
        echo $data;
    }
}   
?>