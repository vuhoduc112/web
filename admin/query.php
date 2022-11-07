<?php
require 'adminFunction.php';
$conn = connect();
if ($_REQUEST['product']) {
    $pid = $_REQUEST['product'];
    $sql = "SELECT img.imgURL, pd.productID, pd.productName, ct.categoryName, pd.productDetail, pd.unitPrice, pd.stock 
        FROM product as pd 
        INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
        INNER JOIN image as img ON pd.productID = img.productID
        WHERE pd.productID = '$pid'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){ //get the category name of the selected product
        $ct = $row['categoryName'];
    }
    
    //find all category and exclude the selected product's category
    $list = $conn->query("SELECT categoryName FROM category WHERE categoryName NOT LIKE '$ct'"); 

    //store all <option> tags with categories in a variable
    if ($list->num_rows > 0) {
        $option = '';
        while ($item = $list->fetch_assoc()) {
            $option .= "<option value=\"{$item['categoryName']}\">{$item['categoryName']}</option>";
        }
    }
    
    $result = $conn->query($sql);
    $output = '<div class="table-responsive">  
        <table class="table table-bordered">';
    
    while ($row = $result->fetch_assoc()) {
        $output .=
            "<tr>
                <td>Sản Phẩm</td>
                <td><input type='text' value='{$row['productName']}' class='form-control'></input></td>
            </tr>
            <tr>
                <td>Danh mục</td>
                <td>
                    <select class='form-select'>
                        <option value=\"{$row['categoryName']}\">{$row['categoryName']}</option>
                        {$option}
                    </select>
                </td>
            </tr>
            <tr>
                <td>Giá</td>
                <td><input type='text' value='{$row['unitPrice']}' class='form-control'></input></td>
            </tr>
            <tr>
                <td>Trong Kho</td>
                <td style='text-align:left;'>{$row['stock']}</td>
            </tr>
            <tr>
                <td>Thêm vào kho</td>
                <td><input type='text' class='form-control'></td>
            </tr>
            <tr>
                <td>Chi tiết sản phẩm</td>
                <td><textarea style=\"width:100%; height:150px; border:none\">{$row['productDetail']}</textarea></td>
            </tr>
            <tr>
                <td>Ảnh</td>
                <td style=\"text-align:center\"><img src='..\\{$row['imgURL']}' style=\"width:150px; height:150px;\"></td>
            </tr>
            ";
    }
    $conn->close();
    $output .= '</table></div>';
    echo $output;

}
