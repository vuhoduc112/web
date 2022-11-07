
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
                        <a href="index.php"><img src="imgs/logo.jpg" alt="logo"></a>
                    </div>

                    <a href="index.php">Trang chủ</a>
                    <div class="dropdown-item">
                        <a href="#prd" id="drop">Sản Phẩm <span class="cheveron"></span></a>
                        <div class="subitem">
                            <?php
                            $prd = $conn->query("SELECT * FROM category WHERE status = 1");
                            while ($row = $prd->fetch_assoc()) {
                                echo "
                                    <a href='?id={$row['categoryID']}#prd'>{$row['categoryName']}</a>
                                ";
                            }
                            ?>
                        </div>
                    </div>
                    <a href="contact.php#ct">Liên hệ</a>
                    <a href="gallery.php">Thư Viện Ảnh</a>
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) { ?>
                        <a href='useraccount.php'><i class="fas fa-user"></i>Tài khoản</a>
                        <a href="logout.php"><i class="fas fa-power-off"></i>Đăng xuất</a>
                    <?php } else { ?>
                        <a href="login.php#page-title">Đăng nhập</a>
                    <?php } ?>
                </div>
                
                <form action="" method="post">
                    <div id="search-box">
                        <input type="text" name="search-text" placeholder="Type to search">
                        <a href="#" type='submit' name='search' id="search-btn">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </form>
            </div>


            <div class="swiper-container" id="banner-slideshow">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/rice-bg.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Bia và nước có cồn</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/bia.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Coktail</h3>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/condiments-bg.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Rượu</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="imgs/bia.jpg" alt="">
                        </div>
                        <div class="slide-caption">
                            <div class="content">
                                <h3>Nước giải khát</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-pagination"></div>
                
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>


        </div>