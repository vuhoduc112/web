<?php
require 'adminFunction.php';
$conn = connect();
if ($_REQUEST['product']) {
    $pid = $_REQUEST['product'];
    $pid = $conn->real_escape_string($pid);
    $sql = "SELECT pd.productID, pd.imgURL, pd.productID, pd.productName, pd.categoryID, ct.categoryName, pd.productDetail, pd.unitPrice, pd.status
        FROM product as pd 
        INNER JOIN category as ct ON pd.categoryID = ct.categoryID 
        WHERE pd.productID = '$pid'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) { //get the category name of the selected product
        $ct = $row['categoryName'];
        $currentStat = $row['status'];
    }

    switch ($currentStat) {
        case 1:
            $currentText = "Đang bán";
            $updateStat = 0;
            $updateText = "Ngừng";
            break;
        case 0:
            $currentText = "Ngừng";
            $updateStat = 1;
            $updateText = "Đang bán";
            break;
    }

    //find all category and exclude the selected product's category
    $list = $conn->query("SELECT categoryID, categoryName FROM category WHERE categoryName NOT LIKE '$ct'");

    //store all <option> tags with categories in a variable
    if ($list->num_rows > 0) {
        $cOption = '';
        $sOption = '';
        while ($item = $list->fetch_assoc()) {
            $cOption .= "<option value='{$item['categoryID']}'>{$item['categoryName']}</option>";
        }
    }
    //store status in a variable

    $result = $conn->query($sql);
    $data = '';
    while ($row = $result->fetch_assoc()) {
        $data .= "
                <div class='input-group mb-1'>
                    
                    <input style='max-width:6%;' type='text' id='pid' class='form-control' name='pid' aria-label='pid' value='{$row['productID']}' readonly>
                    <span class='input-group-text'>Tên sản phẩm:</span>
                    <input type='text' id='pname' class='form-control' name='pname' aria-label='pname' value='{$row['productName']}' required>

                    <input style='max-width:6%;' type='hidden' id='cid' class='form-control' name='cid' aria-label='cid' value='{$row['categoryID']}' readonly>
                    
                    
                </div>
                <div class='input-group mb-3'>
                    <span class='input-group-text'>Giá:</span>
                    <span class='input-group-text'>$</span>
                    <input type='text' style='max-width:10%' id='price' class='form-control' name='price' aria-label='price' value='{$row['unitPrice']}' required>
                    <span class='input-group-text'>Danh mục:</span>
                    <select class='form-select' name='category' id='ctg'>
                        <option value='{$row['categoryID']}' >{$row['categoryName']}</option>
                        {$cOption}
                    </select>
                    <span class='input-group-text'>Tình trạng:</span>
                    <select class='form-select' style='max-width:20%' name='status' id='stt'>
                        <option value='{$currentStat}'>{$currentText}</option>
                        <option value='{$updateStat}'>{$updateText}</option>
                    </select>
                </div>
                <div >
                    <div class='form-floating mb-3' style='position:relative; width:78%; float:left;'>
                        <textarea id='editdetail' style='height: 120px;' class='form-control' name='detail' aria-label='editdetail' required>{$row['productDetail']}</textarea>
                        <script>
                            CKEDITOR.replace('editdetail');
                        </script>
                    </div>
                    <div class='image' style='position: relative; float:right; width:20%; padding:3px; text-align:center; border:1px solid #dbdbdb; background: white; border-radius: 6px;'>
                        <img id='preview-change' src='../{$row['imgURL']}' alt='image' style='width:114px; height:114px'>
                    </div>
                </div>
                <div class='input-group mb-1'>Thêm ảnh mới:</span>
                    <input type='file' class='form-control' id='customFile' name='avatar' accept='.png, .jpg, .jpeg, .gif'/ onchange='loadFile2(event)';>
                </div>
                <div class='mb-1'>
                    <small id='imgHelp' class='form-text text-muted'>chỉ chọn file ảnh JPG, PNG và GIF.</small>
                </div>
            ";
    }
    $conn->close();
    echo $data;
}
