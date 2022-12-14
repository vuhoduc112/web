<?php
session_start();
include_once 'admin/adminFunction.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="js/norepeat.js"></script>
    <script src="js/infomation.js"></script>
    <script>
        var input = document.getElementById('form_message');
        input.oninvalid = function(event) {
            event.target.setCustomValidity('Message should only contain lowercase letters. e.g. john');
        }
    </script>
    <!-- jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <!-- way point plugin-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <!-- count up plugin (fixed bug decrease counting number when scroll to counting section again)-->
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
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/index.css">
    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/ScrollToTop.js"></script>
    <script src="js/validateForm.js" async></script>
</head>

<body>
    <div id="page">
        <div id="head">
            <div id="nav">
                <!--begin nav-->
                <!-- responsive -->
                <button class="hamburger">
                    <span></span>
                </button>

                <div id="menu">
                    <div id="logo">
                        <a href="index.php#about"><img src="imgs/logo.jpg" alt="logo"></a>
                    </div>

                    <a href="index.php">Trang ch???</a>
                    <div class="dropdown-item">
                        <a href="#" id="drop">S???n ph???m <span class="cheveron"></span></a>
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
                    <a href="contact.php">Li??n H???</a>
                    <a href="gallery.php">Th?? Vi???n ???nh</a>
                </div>
                <!-- Search  -->
                <!-- <div id="search-box">
                    <input type="text" name="search-text" placeholder="Type to search">
                    <a href="#" id="search-btn">
                        <i class="fas fa-search"></i>
                    </a>
                </div> -->

            </div><!-- end nav-->
            <!-- Banner -->
            <div id="banner">
                <!--Begin banner-->
                <img src="imgs/logo.png" alt="logo-banner" id="logo-img">
                <p class="welcome">Li??n h??? ch??ng t??i</p>
                <h1 class="introduction">H??y cho ch??ng t??i bi???t b???n ??ang ngh?? g?? ?</h1>
            </div>
            <!--End banner-->
        </div>
        <!--End head-->

        <!-- Begin container -->
        <div class="container">

            <div class="row">

                <div id="ct" class="col-lg-8 col-lg-offset-2">
                    <h1 class="contact_heading">Li??n H???</h1>
                    <span class="separator"></span>
                    <h5 style="text-align:center">B???n c?? c???n m???t c??i g?? ???? ?????c bi???t ? <br>Ho???c b???n mu???n gi??p ch??ng t??i c???i thi???n d???ch v??? c???a m??nh b???ng c??ch cung c???p ph???n h???i c???a b???n ? <br>Xin vui l??ng cho ch??ng t??i bi???t.</h5><br>
                    <form id="contact-form" method="post" role="form" action="sendcontact.php">

                        <div class="messages"></div>

                        <div class="controls">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_name">T??n *</label>
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Vui l??ng nh???p t??n c???a b???n *" required="required" data-error="Firstname is required." value="<?=isset($_GET['fname'])? $_GET['fname'] : '' ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_lastname">H??? *</label>
                                        <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Vui l??ng nh???p h??? c???a b???n *" required="required" data-error="Lastname is required." value="<?=isset($_GET['lname'])? $_GET['lname'] : '' ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_email">Email *</label>
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Vui l??ng nh???p email c???a b???n *" required="required" data-error="Valid email is required." value="<?=isset($_GET['email'])? $_GET['email'] : '' ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_phone">S??? ??i???n tho???i *</label>
                                        <input id="form_phone" type="tel" name="phone" class="form-control" required="required" placeholder="Vui l??ng nh???p SDT c???a b???n *" data-error="Valid phone is required" value="<?=isset($_GET['phone'])? $_GET['phone'] : '' ?>">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">?? ki???n ????ng g??p *</label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Nh???n tin cho ch??ng t??i *" rows="4" required="required" data-error="Please,leave us a message." pattern="[a-z]{1,15}"><?=isset($_GET['mess'])? $_GET['mess'] : '' ?></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="ok" class="btn btn-success btn-send" value="G???i tin nh???n">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <p class="text-muted"><strong>*</strong> C??c tr?????ng n??y l?? b???t bu???c. Li??n h??? v???i <a href="index.php" target="_blank">Star Organic</a>.</p>
                                </div>
                            </div>
                        </div>
                    </form>

                </div><!-- /.8 -->

            </div> <!-- /.row-->

        </div> <!-- /.container-->

        <?php include 'footer.php' ?>
    </div>
    <!--End page-->
    <a href="#" class="UpToTop"><i class="fas fa-arrow-up"></i></a>
</body>

</html>

<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('Please check the following error(s):\\n";
    foreach ($_SESSION['error'] as $value) {
        echo " - " . $value . "\\n";
    }
    echo "')</script>";
    unset($_SESSION['error']);
}

if(isset($_SESSION['success'])){
    echo "<script>alert('{$_SESSION['success']}')</script>";
    unset($_SESSION['success']);
}

if(isset($_SESSION['errDB'])){
    echo "<script>alert('{$_SESSION['errDB']}')</script>";
    unset($_SESSION['errDB']);
}
?>