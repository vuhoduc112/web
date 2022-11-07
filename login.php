<?php
session_start();
require "admin/adminFunction.php"

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <!-- way point plugin-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <!-- count up plugin (fixed bug decrease counting number when scroll to counting section agqain)-->
    <script src="vendor/counter up/jquery.counterup.js"></script>
    <!-- swiper.js-->
    <script src="vendor/swiper/swiper.min.js"></script>
    <!-- import fonts-->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
     -->
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- font awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">
    <!-- swiper-->
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <!--customer stylesheet-->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/dangnhap.css">

    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/ScrollToTop.js"></script>
</head>

<body>
    <div id="page">
        <div id="nav">
            <!--begin nav-->
            <!-- responsive -->
            <button class="hamburger">
                <span></span>
            </button>

            <div id="menu">
                <div id="logo">
                    <a href="index.php#about"><img src="imgs/logo.png" alt="logo"></a>
                </div>

                <a href="index.php">Trang chủ</a>
                <div class="dropdown-item">
                    <a href="#" id="drop">Sản Phẩm <span class="cheveron"></span></a>
                    <div class="subitem">
                        <?php
                        $conn = connect();
                        $prd = $conn->query("SELECT * FROM category WHERE status = 1");
                        while ($row = $prd->fetch_assoc()) {
                            echo "
                                    <a href='product.php?id={$row['categoryID']}#prd'>{$row['categoryName']}</a>
                                ";
                        }
                        $conn->close();
                        ?>
                    </div>
                </div>
                <a href="contact.php">Liên Hệ</a>
                <a href="gallery.php">Thử Viện Ảnh</a>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) { ?>
                    <a href="logout.php"><?= $_SESSION['name'] ?>. Đăng Xuất</a>
                <?php } else { ?>
                    <a href="login.php#page-title">Đăng nhập</a>
                <?php } ?>
            </div>
            <!-- Search  -->
            <div id="search-box">
                <input type="text" name="search-text" placeholder="Type to search">
                <a href="#" id="search-btn">
                    <i class="fas fa-search"></i>
                </a>
            </div>

        </div><!-- end nav-->

    </div>
    <!--End head-->
    <div id="content">
        <div id="page-title">
            <h2>Đăng Nhập</h2>
            <span class="separator"></span>
        </div>
        <div id="main" class="container">
            <div class="row">
                <div id="login" class="col-md-9">
                    <form action="login_logic.php" id="login-form" class="myform" method="post">
                        <label for="username">Email:</label>
                        <input type="text" name="email" id="email" required="required" placeholder="Nhập email" value="<?= isset($_GET['email']) ? $_GET['email'] : '' ?>">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" name="pass" id="password" required="required" placeholder="Nhập mật khẩu">
                        <input type="submit" name='login' value="Đăng nhập">
                    </form>
                    <p class="create-acc">Tài khoản của khách hàng cho phép chúng tôi theo dõi đơn đặt hàng của bạn để có những dịch vụ tốt nhất. </p>
                    <p class="create-acc">Nếu bạn chưa có tài khoản, vui lòng <a href="create-account.php">Tạo tài khoản.</a></p>
                </div>
            </div><!-- /row-->
        </div>
        <!--/main-->
    </div>
    <!--/content-->
    </div>
    <!--End page-->
</body>

</html>
<?php
if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>alert('{$_SESSION['error']}')</script>";
    unset($_SESSION['error']);

}
?>