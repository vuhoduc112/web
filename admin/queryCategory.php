<?php
session_start();
if(isset($_SESSION['account'])){
    $user = $_SESSION['account'];
}
$currentID = $user['userID']; //the id of current logged in user
require 'adminFunction.php';
$conn = connect();
if (isset($_REQUEST['ctg'])) {
    $id = $_REQUEST['ctg'];
    $id = $conn->real_escape_string($id);
    $sql = "SELECT * FROM category WHERE categoryID = '$id'";
    $data = '';
    $ctg = $conn->query($sql);
    $ctgValue = $ctg->fetch_object();
    switch ($ctgValue->status){
        case 1:
            $currentStt = "<option value='1'>Hoạt động</option>";
            $changeStt = "<option value='0'>Không hoạt động</option>";
            break;
        case 0:
            $currentStt = "<option value='0'>Hoạt động</option>";
            $changeStt = "<option value='1'>Không hoạt động</option>";
            break;
    }
    $data = '';
    foreach ($ctg as $value) {
        $data .= "
        <div class='input-group mb-3'>
            <input type='hidden' name='cid' value='{$value['categoryID']}'>
            <span class='input-group-text' style='max-width:25%'>Danh mục:</span>
            <input type='text' id='name' class='form-control' name='name' value='{$value['categoryName']}' aria-label='name'>
            <span class='input-group-text' style='max-width:25%'>Đơn vị:</span>
            <input type='text' id='unit' class='form-control' name='unit' value='{$value['unit']}' aria-label='unit'>
            <span class='input-group-text'>Tình trạng:</span>
            <Select class='form-select' name ='status'>
                {$currentStt}
                {$changeStt}
            </Select>
        </div>
        <div class='input-group mb-3'>
            <span class='input-group-text' style='max-width:25%'>Miêu tả:</span>
            <textarea rows='6' type='text' id='detail' class='form-control' name='detail' aria-label='detail'>{$value['categoryDetail']}</textarea>
        </div>
        ";
    }
    $conn->close();
    echo $data;
}
