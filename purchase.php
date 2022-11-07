<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"> -->
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- font awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">
    <!-- swiper-->
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <!--customer stylesheet-->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/purchase.css">
    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/ScrollToTop.js"></script>

    <title>Thanh Toán</title>
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

                <a href="index.php">Trang Chủ</a>
                <div class="dropdown-item">
                    <a href="#" id="drop">Sản Phẩm<span class="cheveron"></span></a>
                    <div class="subitem">
                        <a href="product.php?id=2#prd">Gạo</a>
                        <a href="product.php?id=4#prd">Dầu Ăn</a>
                        <a href="product.php?id=1#prd">Hoa Quả</a>
                        <a href="product.php?id=3#prd">Gia Vị</a>
                    </div>
                </div>
                <a href="contact.php">Liên Hệ</a>
                <a href="gallery.php">Thư Viện Ảnh</a>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) { ?>
                    <a href="logout.php"><?= $_SESSION['name'] ?>. Đăng xuất</a>
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
        <!-- <div id="banner">
                <p class="welcome">Welcome to Star Organic farm</p>
                <img src="imgs/logo.png" alt="star-logo" id="logo-img">
                <h1 class="intro">A Happy Farm Make Healthy food</h1>
      
            </div> End banner -->
        <div id="content">
            <div id="page-title">
                <h2>Bước thanh toán cuối cùng</h2>
                <span class="separator"></span>
            </div>
            <div id="main" class="container">
                <div class="row">
                    <div id="purchase-form" class="col-md-8">
                        <form action="checkout.php" id="purchase" class="myform" method="post">
                            <label for="order-adress">Địa chỉ giao hàng: </label>
                            <input type="text" name="address" id=order-adress required="required" placeholder="Nhập địa chỉ giao hàng">

                            <label for="phone">Số điện thoại: </label>
                            <input type="tel" name="phone" pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" id="phone" required="required" placeholder="Nhập số điện thoại">

                            <!-- <div class="purchase-method">
                                <p id="title">Choose your payment method: </p>
                                <div class="method-container">
                                    <input type="radio" value="cash" id="cash" name="purchase-method">
                                    <label for="cash" class="method-name">Pay when you receive the product</label>
                                </div>
                                <div class="method-container">
                                    <input type="radio" value="card" id="card" name="purchase-method" checked>
                                    <label for="cash" class="method-name">Payment by credit card: Bank Transfer </label>
                                </div>
                            </div> -->
                            <!-- <div class="delivery-method">
                                <p id="title">Choose a shipping method: </p>
                                <div class="method-container">
                                    <input type="radio" value="cash" id="cash" name="delivery-method">
                                    <label for="cash" class="method-name">Express delivery (You will receive the product within 1-2 days)</label>
                                </div>
                                <div class="method-container">
                                    <input type="radio" value="card" id="card" name="delivery-method" checked>
                                    <label for="cash" class="method-name">Regular delivery (You will receive the product within 3-5 days)</label>
                                </div>
                            </div> -->
                            <input name="submit" type="submit" value="THANH TOÁN" id="purchase-btn">
                        </form>

                    </div>

                    <div id="mini-cart" class="col-md-4">
                        <!-- <table class="cart">
                            <tr>
                                <td>Your Cart( 3 Products )</td>
                                <td>
                                    <a href="#" class=" edit-btn align-right">Edit oder</a>
                                </td>
                            </tr>

                            <tr>
                                <td>1 x Organic Tea Tree Oil </td>
                                <td class="align-right">$ 15.99</td>
                            </tr>

                            <tr>
                                <td>1 x coconut powder </td>
                                <td class="align-right">$ 12.34</td>
                            </tr>

                            <tr>
                                <td>1 x Organic gluttonous rice</td>
                                <td class="align-right">$ 6.95</td>
                            </tr>

                            <tr class="no-border">
                                <td>TOTAL:</td>
                                <td class="align-right">$ 35.28</td>
                            </tr>
                        </table> -->
                    </div>
                </div><!-- /row-->
            </div>
            <!--/main-->
        <?php include 'footer.php' ?>
    </div><!-- /page-->


</body>

</html>