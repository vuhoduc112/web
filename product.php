<?php session_start();
require "admin/adminFunction.php";
$conn = connect();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 1;
}

if (isset($_POST['search-text'])) {
    $search = filter_var($_POST['search-text'], FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM product
    INNER JOIN category ON product.categoryID = category.categoryID
    WHERE product.productName LIKE CONCAT('%',?,'%') 
    OR category.categoryName LIKE CONCAT('%',?,'%')
    AND product.status = 1 AND category.status = 1
    ";
    $stm = $conn->prepare($sql);
    $stm->bind_param("ss", $search, $search);
    $stm->execute();
    $product = $stm->get_result();
    $stm->close();
} else {
    $sql = "SELECT * FROM product 
    INNER JOIN category ON product.categoryID = category.categoryID 
    WHERE product.categoryID = ? AND product.status = 1 AND category.status = 1";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $id);
    $stm->execute();
    $product = $stm->get_result();
    $stm->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <!-- import fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- font awesome-->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.css">
    <!-- swiper plugin-->
    <script src="vendor/swiper/swiper.min.js"></script>
    <link rel="stylesheet" href="vendor/swiper/swiper.min.css">
    <!--customer stylesheet-->
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/style_index.css">
    <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/product.css">

    <!-- customer javascript-->
    <script src="js/showMenuOnScroll.js"></script>
    <script src="js/toggleMenu.js"></script>
    <script src="js/DropMenu.js"></script>
    <script src="js/popupEffect.js"></script>
    <script src="js/ScrollToTop.js"></script>
    <!-- <script src="js/cart.js" async></script> -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, location.href);
        }
    </script>
    <title><?= admin_getCategoryName($id) ?></title>
</head>

<body>
    <?php require_once "head.php" ?>
    <div id="content">
        <div id="general-title">
            <h2 id="prd"><?= isset($_POST['search-text']) ? "Chúng tôi có một cái gì đó cho bạn:" : admin_getCategoryName($id) ?></h2>
            <span class="separator"></span>
        </div>
        <div id="product-container" class="container">
            <div class="row" id="row1">
                <?php if ($product->num_rows > 0) {
                    $i = 1;
                    foreach ($product as $value) : ?>
                        <div class="product-card col-md-3 col-sm-6">
                            <div class="product-img">
                                <img src="<?= $value['imgURL'] ?>" alt="<?= $value['productName'] ?>" class="img" onclick="toggle(<?= $i ?>)" />
                            </div>
                            <div class="product-details">
                                <span class='pid' style="display:none"><?= $value['productID'] ?></span>
                                <h3 style="color: black" class="product-name"><?= $value['productName'] ?></h3>
                                <p>
                                    <span class="product-price"><?= number_format($value['unitPrice'], 3) ?></span>
                                    <span class="vnd">₫</span>
                                    <span class="vnd">/<?= $value['unit'] ?></span>
                                </p>
                               

                                <button type="button" class="mybtn AddToCart1 2cart" data-id='<?= $value['productID'] ?>' data-name='<?= $value['productName'] ?>'>Thêm vào giỏ</button>
                            </div>
                        </div>
                <?php $i++;
                    endforeach;
                } else {
                    echo "<div class='row' style='text-align:center'>
                            <h3>Chúng tôi rất tiếc vì sản phẩm bạn đang tìm kiếm hiện không có sẵn trong cửa hàng của chúng tôi.</h3>
                            <h3>
                            44 / 5000
                            Kết quả dịch
                            Nếu bạn có bất kỳ nhu cầu đặc biệt nào, vui lòng  <b><a href='contact.php'>liên lạc với chúng tôi</a>!</b></h3>
                        </div>";
                }
                ?>

            </div>
        </div> <!-- end product container-->
        <!-- cart section-->
        <div id="cart" class="container">
            <h2 class="cart-header">Giỏ Hàng<i class="fas fa-cart-arrow-down"></i></h2>
            <!-- <form id='cart-submit' action="addcart.php" method="post"> -->
            <span class="separator"></span>
            <!-- cart product-->
            <table class="table table-condensed" id="cart-product">
                <thead>
                    <tr>
                        <th>Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Số Lượng</th>
                        <th>Tổng tiền</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody class="cart-items">
                    <?php
                    if (isset($_SESSION['customerCart'])) {
                        foreach ($_SESSION['customerCart'] as $item) : ?>
                            <tr class='cart-row'>
                                <td class='item-img'>
                                    <img style="height: 80px; width:100px" src='<?= admin_findImg($item['id']) ?>' alt=''>
                                    <span class='item-name'><?= $item['name'] ?></span>
                                </td>
                                <td>
                                    <input type="hidden" class='price' value="<?= $item['price'] ?>">
                                    <span class='item-price'><?= $item['price'] ?></span>,000 VNĐ
                                </td>
                                <td>
                                    <input style='max-width:50px' name='itemQuantity' type='number' min='1' step='1' value='<?= $item['qtt'] ?>' class='quantity-input' data-id='<?= $item['id'] ?>'>
                                </td>   
                                <td>
                                    <input type='hidden' value='<?= $item['subtotal']?>' class='subtotal'>
                                    <span class='visible-subtotal'><?= $item['subtotal']?></span>,000 VND
                               
                                </td>
                                <td>
                                    <button data-id='<?= $item['id'] ?>' class='remove btn btn-danger'>Xóa</button>
                                </td>
                            </tr>
                    <?php endforeach;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td class="toltal-price" colspan="4">Tổng: <span id='sum'><?= isset($_SESSION['totalCart']) ? number_format($_SESSION['totalCart'],0) : '' ?></span>,000 VNĐ</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class='order-btn'>
                <a href='customer-cart.php' class="btn purchase-btn gocart">Thanh Toán</a>
            </div>
            <!-- </form> -->

        </div>
      
        <a href="#cart" class="scrollToCart">
            <i class="fab fa-opencart"></i>
            <span id='badge' class='badge'></span>
        </a>

        
        <div id="popup-container">
            <?php
            $i = 1;
            foreach ($product as $value) { ?>
                <div id="popup-<?= $i ?>" class="popup">
                    <span class='pid' style="display:none"><?= $value['productID'] ?></span>
                    <h2 class='pname'><?= $value['productName'] ?></h2>
                    <img class='imgURL' src="<?= $value['imgURL'] ?>" alt="<?= $value['productName'] ?>" class="popup-img">
                    <p><?= $value['productDetail'] ?></p>
                    <p class='unitprice' style="visibility: hidden"><?= $value['unitPrice'] ?></p>
                    <button type="button" class="close-btn mybtn" onclick="toggle(<?= $i ?>)">Đóng</button>
                    <button type="button" data-id='<?= $value['productID'] ?>' data-name='<?= $value['productName'] ?>' class="AddToCart mybtn 2cart" onclick="toggle(<?= $i ?>);"><i class="fas fa-cart-plus"></i>Thêm vào giở</button>
                    <!-- <a href="customer-cart.php" class="AddToCart mybtn" target="_blank"><i class="fas fa-cart-plus"></i> Add To Cart</a> -->
                </div>
            <?php
                $i++;
            } ?>
        </div>
        <!-- end popup container-->
    </div>
    <?php include 'footer.php' ?>
    </div><!-- end page div-->
    <a href="#" class="UpToTop"><i class="fas fa-arrow-up"></i></a>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    <script src="js/addtocart1.js"></script>
</body>

</html>
<?php $conn->close(); ?>