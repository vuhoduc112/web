<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- import fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

    <!-- font awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">

    <!--customer stylesheet-->
    <link rel="stylesheet" href="css/create-account.css">
    <!-- customer javascript-->
    <title>Tạo tài khoản</title>
    <style>
        form {
            width: 280px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
        }

        form h1 {
            width: 300px;
            text-align: center;
            /* clear: both; */
            font-size: 40px;
            border-bottom: 5px solid #BB0000;
            margin-bottom: 50px;
            padding: 13px 0;
        }

        form a {
            color: blueviolet;
        }

        body {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <form action="register.php" method="post" id="create-account">
        <h1>Tạo tài khoản</h1>
        <div class="textbox">
            <i class="fas fa-user"></i>
            <input type="text" name="name" placeholder="Tên của bạn" value="<?=isset($_GET['name']) ? $_GET['name']:'' ?>">
        </div>
        <div class="textbox">
            <i class="fas fa-envelope"></i>
            <input type="text" name="email" placeholder="Email" value="<?=isset($_GET['email']) ? $_GET['email']:'' ?>">
        </div>
        <div class="textbox">
            <i class="fas fa-phone-alt"></i>
            <input type="text" name="phone" placeholder="Số điện thoại" value="<?=isset($_GET['phone']) ? $_GET['phone']:'' ?>">
        </div>
        <div class="textbox">
            <i class="fas fa-lock"></i>
            <input type="password" name="pass" placeholder="Mật khẩu">
        </div>

        <div class="textbox">
            <i class="fas fa-lock"></i>
            <input type="password" name="repass" placeholder="Nhập lại mật khẩu">
        </div>

        <input name="submit" type="submit" value="Tạo tài khoản"><br><br>
        <p>Nếu bạn đã có tài khoản,<a href="login.php#page-title"> Đăng nhập tại đây</a></p>
    </form>

</body>

</html>
<?php
if(isset($_SESSION['error'])){
    echo "<script>alert('{$_SESSION['error']}')</script>";
    unset($_SESSION['error']);
}
if(isset($_SESSION['error1'])){
    echo "<script>alert('Đăng kí thất bại. Vui lòng kiểm tra vấn đề sau(s):\\n";
    foreach ($_SESSION['error1'] as $value){
        echo " - $value"."\\n";
    }
    echo "')</script>";
    unset($_SESSION['error1']);
}

?>