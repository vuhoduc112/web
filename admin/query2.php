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
    $list = $conn->query("SELECT categoryName FROM category WHERE categoryName NOT LIKE '$ct'"); 

    //store all <option> tags with categories in a variable
    if ($list->num_rows > 0) {
        $option = '';
        while ($item = $list->fetch_assoc()) {
            $option .= "<option value='{$item['categoryName']}'>{$item['categoryName']}</option>";
        }
    }
    
    $result = $conn->query($sql);
    $output = '';
    
    while ($row = $result->fetch_assoc()) {
        $output .="
                <div class='input-group mb-1'>
                    <span class='input-group-text'>Tên sản phẩm:</span>
                    <input type='text' id='pname' class='form-control' name='pname' placeholder='' aria-label='pname' value='{$row['productName']}' required>
                    <span class='input-group-text'>Danh mục:</span>
                    <select class='form-select' name='category' id='ctg'>
                        <option value='{$row['categoryName']}' >{$row['categoryName']}</option>
                        {$option}
                    </select>
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text'>Giá:</span>
                    <span class='input-group-text'>$</span>
                    <input type='text' id='price' class='form-control' name='price' aria-label='price' value='{$row['unitPrice']}' required>
                    <span class='input-group-text'>Trong kho:</span>
                    <input id='stock' type='text' class='form-control' name='stock' aria-label='stock' disabled value='{$row['stock']}'>
                    <span class='input-group-text'>Thêm vào kho:</span>
                    <input id='input' type='text' class='form-control' name='input' aria-label='input'>
                </div>
                <div >
                    <div class='form-floating mb-3' style='position:relative; width:78%; float:left;'>
                        <!-- <span class='input-group-text'>Miêu tả:</span> -->
                        <textarea id='detail' style='height: 120px;' class='form-control' name='detail' aria-label='detail' required>{$row['productDetail']}</textarea>
                        <label for='detail'>Chi tiết </label>
                    </div>
                    <div class='image' style='position: relative; float:right; width:20%; padding:3px; text-align:center; border:1px solid #dbdbdb; background: white; border-radius: 6px;'>
                        <img src='../{$row['imgURL']}' alt='image' style='width:114px; height:114px'>
                    </div>
                </div>
            ";
    }
    $conn->close();
    // $output .= '</table></div>';
    echo $output;

}
