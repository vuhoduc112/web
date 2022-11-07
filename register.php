<?php
session_start();
require 'admin/database.php';
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}
if(isset($_SESSION['error1'])){
    unset($_SESSION['error1']);
}
if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}

function customerRegister($name, $email, $phone, $pass, $repass) {
    $conn = connect();
    $error = [];
    //validate name:
    $name = filter_var(trim($name), FILTER_SANITIZE_STRING);
    //validate email:
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['email'] = 'địa chỉ email không hợp lệ'; //check email string
    } else {
        $checkEmail = $conn->query("SELECT * FROM customers WHERE customerEmail = '$email'");
        if($checkEmail->num_rows>0){ 
            $error['email'] = 'Email bạn nhập đã được đăng ký.'; //check duplicated email
        }
    }
    //Validate phone:
    if(!preg_match('/^\+?[0-9]*$/', $phone) || strlen($phone) < 9){
        $error['phone'] = 'Số điện thoại không hợp lệ'; //check phone string
    } else {
        $checkphone = $conn->query("SELECT * FROM customers WHERE customerPhone = '$phone'");
        if($checkphone->num_rows>0){
            $error['phone'] = 'Số điện thoại bạn nhập đã được đăng ký.'; //check duplicated phone
        }
    }
    //Check password:
    if(strcmp($pass,$repass)!=0){
        $error['pass'] = "Mật khẩu nhập lại không khớp.";
    } else {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
    }

    //insert:
    if(count($error)>0) {
        return $error;
    } else {
        $sql = "INSERT INTO customers (customerName, customerEmail, customerPhone, password)
        VALUES (?, ?, ?, ?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("ssss",$name, $email, $phone, $pass);
        $stm->execute();
        $stm->close();
        return true;
    }
    $conn->close;
}

if (isset($_POST['submit'])) {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['pass']) || empty($_POST['repass'])) {
        $_SESSION['error'] = 'You must enter all required fields.';
        header("location: create-account.php?name={$_POST['name']}&email={$_POST['email']}&phone={$_POST['phone']}");
    } else {
        $name = filter_var ($_POST['name'], FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $pass = $_POST['pass'];
        $repass = $_POST['repass'];
        
        $result = customerRegister($name, $email, $phone, $pass, $repass);
        if($result !== true){
            $_SESSION['error1'] = $result;
            // print_r($_SESSION['error1']);
            header ("location: create-account.php");
        } else {
            $_SESSION['success'] = 'Đăng ký thành công, bây giờ bạn có thể đăng nhập.';
            header ("location: login.php?email={$email}");
        }
    }
}

?>