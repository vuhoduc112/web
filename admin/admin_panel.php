<?php
session_start();
require 'adminFunction.php';

if (isset($_SESSION['account'])) {
    $user = $_SESSION['account'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="../js/admin.js"></script>
        <link rel="stylesheet" href="..//css//adminCP.css">
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    </head>

    <body>
        <div class="container-fluid">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4><i class="fa fa-star-o icon" aria-hidden="true"></i>STAR ORGANIC</h4>
                </div>
                <ul class="menu">
                    <a href="?page=account">
                        <li class="account">
                            <div class='user-account'>
                                <span class="icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                                <span class="text">User#<?= $user['userID'] ?>: <?= $user['userName'] ?></span>
                            </div>
                        </li>
                    </a>
                    <a href="?page=home">
                        <li class='adminItem <?= $_GET['page'] == "home" ? "adminItemActive" : "" ?>'>
                            <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                            <span class="text">Trang chủ</span>
                        </li>
                    </a>
                    <a href="?page=product">
                        <li class='adminItem <?= $_GET['page'] == "product" ? "adminItemActive" : "" ?>'>
                            <span class="icon"><i class="fa fa-product-hunt" aria-hidden="true"></i></span>
                            <span class="text">Quản lý sản phẩm</span>
                        </li>
                    </a>
                    <?php if ($user['userRole'] === 1) : ?>
                        <a href="?page=category">
                            <li class='adminItem <?= $_GET['page'] == "category" ? "adminItemActive" : "" ?>'>
                                <span class="icon"><i class="fa fa-folder-open" aria-hidden="true"></i></span>
                                <span class="text">Quản lý danh mục</span>
                            </li>
                        </a>
                    <?php endif ?>
                    <a href="?page=gallery">
                        <li class='adminItem <?= $_GET['page'] == "gallery" ? "adminItemActive" : "" ?>'>
                            <span class="icon"><i class="fa fa-camera-retro" aria-hidden="true"></i></span>
                            <span class="text">Thư Viện Ảnh</span>
                        </li>
                    </a>
                    <?php if ($user['userRole'] === 1) : ?>
                        <a href="?page=user">
                            <li class='adminItem <?= $_GET['page'] == "user" ? "adminItemActive" : "" ?>'>
                                <span class="icon"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>
                                <span class="text">Quản lý User</span>
                            </li>
                        </a>
                    <?php endif ?>
                    <a href="?page=feedback">
                        <li class='adminItem <?= $_GET['page'] == "feedback" ? "adminItemActive" : "" ?>'>
                            <span class="icon"><i class="fa fa-commenting" aria-hidden="true"></i></i></span>
                            <span class="text">Phản hổi của khách hàng</span>
                        </li>
                    </a>
                    <a href="?page=customerinfo">
                        <li class='adminItem <?= $_GET['page'] == "customerinfo" ? "adminItemActive" : "" ?>'>
                            <span class="icon"><i class="fa fa-address-book-o" aria-hidden="true"></i></span>
                            <span class="text">Thông tin khách hàng</span>
                        </li>
                    </a>
                    <a href="logout.php" onclick="return confirm('Do you want to log out?')">
                        <li class="logout">
                            <span class="icon"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                            <span class="text">ĐĂNG XUẤT</span>
                        </li>
                    </a>
                </ul>
            </div>

            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'home':
                        include_once "admin_home.php";
                        break;
                    case 'product':
                        include_once "admin_product.php";
                        break;
                    case 'category':
                        include_once "admin_Category.php";
                        break;
                    case 'gallery':
                        include_once "admin_gallery.php";
                        break;
                    case 'user':
                        include_once "admin_User.php";
                        break;
                    case 'feedback':
                        include_once "admin_contact.php";
                        break;
                    case "account":
                        include_once "admin_account.php";
                        break;
                    case "customerinfo":
                        include_once "admin_CustomerInfo.php";
                        break;
                    default:
                        include_once "admin_home.php";
                }
            } else {
                include_once "admin_home.php";
            }
            ?>

        </div>
    </body>

    </html>
<?php
} else {
    header("location: index.php");
}
?>