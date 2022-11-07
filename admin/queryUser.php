<?php
session_start();
$currentID = $_SESSION['account']['userID']; //the id of current logged in user
require 'adminFunction.php';
$conn = connect();
if (isset($_POST['user'])) {
    $uID = $conn->real_escape_string($_POST['user']);
    $sql = "SELECT s.staffID, s.userName, s.status, sr.roleName, sr.roleDetail, s.email, s.status, s.roleID
    FROM staff as s INNER JOIN staffrole as sr ON s.roleID = sr.roleID
    WHERE s.staffID = '$uID'";
    $data = '';
    $user = [];
    $selectRole = '';
    $readonly = '';
    $findUser = $conn->query($sql);
    while ($row = $findUser->fetch_assoc()) {
        $user = $row;
    }
    $result = $conn->query("SELECT * FROM staffrole WHERE roleName != '{$user['roleName']}'");
    $role = $result->fetch_object();
    if ($currentID == 1) { //check if the rootadmin is logged in
        if ($user['staffID'] == 1) {
            $currentStatus = "<option value='1'>Hoạt động</option>";
            $selectStatus = '';
            $selectRole = '';
            $readonly = ''; 
        } else {
            $readonly = '';
            $selectRole .= "<option value = '{$role->roleID}'>{$role->roleName}</option>";

            switch ($user['status']) {
                case 1:
                    $currentStatus = "<option value='1'>Hoạt động</option>";
                    $selectStatus = "<option value='0'>Thôi việc</option>";
                    break;
                case 0:
                    $currentStatus = "<option value='0'>Thôi việc</option>";
                    $selectStatus = "<option value='1'>Hoạt động</option>";
                    break;
            }
        }
    } else {
        if ($user['staffID'] == 1) { //lock rootadmin from being edited
            $currentStatus = "<option value='1'>Hoạt động</option>";
            $selectStatus = '';
            $readonly = 'readonly'; //lock rootadmin input field
        } else {
            $readonly = '';
            $selectRole .= "<option value = '{$role->roleID}'>{$role->roleName}</option>";
            switch ($user['status']) {
                case 1:
                    $currentStatus = "<option value='1'>Hoạt động</option>";
                    $selectStatus = "<option value='0'>Thôi việc</option>";
                    break;
                case 0:
                    $currentStatus = "<option value='0'>Thôi việc</option>";
                    $selectStatus = "<option value='1'>Hoạt động</option>";
                    break;
            }
        }
    }

    $data .= "
        <div class='input-group mb-3'>
            <span class='input-group-text' style='max-width:5%'>ID:</span>
            <input type='text' class='form-control' name='uid' value='{$user['staffID']}' style='max-width:5%' readonly>
            <span class='input-group-text' style='max-width:15%'>Tên tài khoản:</span>
            <input type='text' id='uname' class='form-control' name='uname' value='{$user['userName']}' aria-label='uname' required {$readonly}>
            <span class='input-group-text'>Tình trạng:</span>
            <select style='max-width:13%;' class='form-select' name='status' id='status'>
                {$currentStatus}
                {$selectStatus}
            </select>
            <span class='input-group-text'>Loại tài khoản:</span>
            <select style='max-width:13%;' class='form-select' name='role' id='role'>
                <option value='{$user['roleID']}'>{$user['roleName']}</option>
                {$selectRole}
            </select>
        </div>
        <div class='input-group mb-3'>
            <span class='input-group-text' style='max-width:25%'>Email:</span>
            <input type='text' id='email' class='form-control' name='email' value='{$user['email']}' aria-label='email' required {$readonly}>
        </div>
        <div class='input-group mb-3'>
            <span class='input-group-text'>Đặt lại mật khẩu:</span>
            <input type = 'password' class='form-control' id='resetpass' name='resetpass' aria-label='resetpass' {$readonly}>
            <span class='input-group-text'>Nhập lại mật khẩu:</span>
            <input type = 'password' class='form-control' id='confirmpass' name='confirmpass' aria-label='confirmpass' {$readonly}>
        </div>
    ";

    $conn->close();
    echo $data;
}
