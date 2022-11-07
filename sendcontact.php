<?php
session_start();
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}

if(isset($_SESSION['errDB'])){
    unset($_SESSION['errDB']);
}

require_once 'admin/database.php';
if (isset($_POST['ok'])) {
    $error = [];
    $fname = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $lname = filter_var(trim($_POST['surname']), FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = htmlspecialchars($_POST['message']);
    
    if(empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($message) ){
        $error['empty'] = 'Vui lòng điền vào tất cả các trường bắt buộc.';
        header("location: contact.php?lname=$lname&fname=$fname&email=$email&phone=$phone&mess=$message");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Địa chỉ email không hợp lệ.';
        $email = '';
    }else {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    if(!preg_match('/^\+?[0-9]*$/', $phone)) {
        $error['phone'] = 'Số điện thoại không hợp lệ.';
        $phone = '';
    }
    if(strlen($phone) < 10) {
        $error['phone'] = 'Số điện thoại phải có ít nhất 10 chữ số.';
        $phone = '';
    }

    if(count($error)>0){
        $_SESSION['error'] = array();
        $_SESSION['error'] =  $error;
        header("location: contact.php?lname=$lname&fname=$fname&email=$email&phone=$phone&mess=$message#ct");
    } else {
        $conn = connect();
        $sql = "INSERT INTO contact_us (first_name, last_name, email, phone, message) 
        VALUES (?,?,?,?,?)";
        $stm = $conn->prepare($sql);
        $stm->bind_param("sssss", $fname, $lname, $email, $phone, $message);
        if($stm->execute()){
            $_SESSION['success'] = 'Chúng tôi đã nhận được tin nhắn của bạn và sẽ sớm liên hệ với bạn. Cảm ơn bạn.';
            echo 'D';
        } else {
            $_SESSION['errDB'] = 'Không thể kết nối với cơ sở dữ liệu.';
            echo 'E';
        }
        $conn->close();
        header("location: contact.php#ct");
    }
}
?>