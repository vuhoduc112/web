<?php session_start();
require "admin/adminFunction.php";
if (!isset($_SESSION['cid'])) {
    header("location: index.php");
}
$conn = connect();
$cid = $_SESSION['cid'];
$result = $conn->query("SELECT * FROM customers WHERE customerID = '$cid'");
$cus = $result->fetch_object();
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
    <link rel="stylesheet" href="css/sanpham.css">

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
    <style>
        body {
            min-height: 100vh;
        }
    </style>
    <title>Customer's User Account</title>
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
                        <a href="index.php#about"><img src="imgs/logo.png" alt="logo"></a>
                    </div>

                    <a href="/Project/project2/">Trang chủ</a>
                    <div class="dropdown-item">
                        <a href="#prd" id="drop">Sản Phẩm <span class="cheveron"></span></a>
                        <div class="subitem">
                            <?php
                            $prd = $conn->query("SELECT * FROM category WHERE status = 1");
                            while ($row = $prd->fetch_assoc()) {
                                echo "
                                    <a href='product.php?id={$row['categoryID']}#prd'>{$row['categoryName']}</a>
                                ";
                            }
                            ?>
                        </div>
                    </div>
                    <a href="contact.php#ct">Liên Hệ</a>
                    <a href="gallery.php">Thư Viện Ảnh</a>
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) { ?>
                        <a href='useraccount.php'><i class="fas fa-user"></i>Tài Khoản</a>
                        <a href="logout.php"><i class="fas fa-power-off"></i>Đăng Xuất</a>
                    <?php } else { ?>
                        <a href="login.php#page-title">Đăng Nhập</a>
                    <?php } ?>
                </div>
            </div><!-- end nav-->
        </div>
        <!--end head div-->
        <div id="content">
            <div id="general-title">
                <h2 id="prd">Tài khoản người dùng</h2>
                <h4>Xin chào, <?= $_SESSION['name'] ?></h4>
                <span class="separator"></span>
            </div>
            <div id="account" class="container" style="width:50%">
                <form action="updateAccount.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="hidden" id='hidden-email' value="<?= isset($_SESSION['cid']) ? $cus->customerEmail : '' ?>">
                                <input type="email" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpId" value="<?= isset($_SESSION['cid']) ? $cus->customerEmail : '' ?>">
                                <small style="color:red" id="errEmail" class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Số điện thoại:</label>
                                <input type="hidden" id='hidden-phone' value="<?= isset($_SESSION['cid']) ? $cus->customerPhone : '' ?>">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="" aria-describedby="helpId" value="<?= isset($_SESSION['cid']) ? $cus->customerPhone : '' ?>">
                                <small style="color:red" id="errPhone" class="text-muted"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="oldpass">Mật khẩu cũ:</label>
                                <input type="password" name="oldpass" id="oldpass" class="form-control" placeholder="" aria-describedby="helpId">
                                <small style="color:red" id="errOldPass" class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="newpass">Mật khẩu mới:</label>
                                <input type="password" name="newpass" id="newpass" class="form-control" placeholder="" aria-describedby="helpId">
                                <small style="color:red" id="errNewPass" class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="repass">Nhập lại mật khẩu mới:</label>
                                <input type="password" name="repass" id="repass" class="form-control" placeholder="" aria-describedby="helpId">
                                <small style="color:red" id="errRePass" class="text-muted"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align:center">
                            <button id='info' style="width:150px" type="submit" name='upinfo' class='btn btn-primary'>Cập nhật thông tin</button>
                            <button id='pass' style="width:150px" type="submit" name='uppass' class='btn btn-danger'>Đổi mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="container">
                <h2 style="text-align:center">Danh sách đơn hàng của bạn</h2>
                <h5 style="text-align:center">Bấm để xem chi tiết</h5>
                <span class="separator"></span>
                <?php
                $sql = "SELECT * FROM orders as o
                INNER JOIN customers as c ON o.customerID = c.customerID
                LEFT JOIN orderdetail as od ON o.orderID = od.orderID
                INNER JOIN product as p ON od.productID = p.productID
                GROUP BY o.orderID
                HAVING o.customerID = '$cid' ORDER BY o.orderTime DESC
                ";
                $query = $conn->query($sql);
                echo "<table class='table table-hover'>
                <thead>
                        <tr>
                            <th>Thời gian sáng tạo</th>
                            <th>Địa chỉ giao hàng</th>
                            <th>Điện thoại liên hệ</th>
                            <th>Tổng giá trị</th>
                            <th>Trạng thái</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                ";
                while ($order = $query->fetch_assoc()) { ?>
                    <tr class='vieworder' data-toggle='modal' data-target='#orderDetail' data-id="<?= $order['orderID'] ?>">
                        <td><?= $order['orderTime'] ?></td>
                        <td><?= $order['dAdd'] ?></td>
                        <td><?= $order['phone'] ?></td>
                        <td>$<?= $order['orderValue'] ?></td>
                        <td><?php if($order['orderStatus']=='pending'){
                        echo"Chưa giải quyết";
                    }else if($order['orderStatus']=='success'){
                        echo'Hoàn thành';
                    }
                    else{
                        echo'Huỷ';
                    }?></td>

                    </tr>
                <?php  }
                echo "</tbody></table>";
                ?>
            </div>
            <div class="modal fade" id="orderDetail" tabindex="-1" aria-labelledby="orderDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="orderDetailLabel">
                                Chi Tiết Đơn Hàng
                            </h3>
                        </div>
                        <div class="modal-body" id="order-detail">
                            <!-- data fetch here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
    <!-- end page div-->
</body>

<script>
    $(document).ready(function() {
        //sending requess
        $('.vieworder').on('click', function() {
            var orderID = $(this).attr('data-id');
            $.ajax({
                url: 'orderDetail.php',
                method: 'get',
                data: {
                    order: orderID
                },
                success: function(data) {
                    $('#order-detail').html(data);
                }
            })
        })

        //button click event:
        $('#info').on('click', function(e) {
            if ($('#email').val() == $('#hidden-email').val()) {
                if ($('#phone').val() == $('#hidden-phone').val()) {
                    e.preventDefault();
                    $('#errEmail').text('Không có gì thay đổi..');
                    $('#errPhone').text('Không có gì thay đổi..');
                }
            }
            if ($('#email').val() == '') {
                e.preventDefault();
                $('#errEmail').text('Email của bạn là bắt buộc.');
            }
            if ($('#phone').val() == '') {
                e.preventDefault();
                $('#errPhone').text('Điện thoại của bạn là bắt buộc.');
            }
        })

        $('#pass').on('click', function(e) {
            if ($('#oldpass').val() == '') {
                e.preventDefault();
                $('#errOldPass').text('Vui lòng xác nhận mật khẩu hiện tại của bạn.');
            }
            
            if ($('#newpass').val() == '' || $('#repass').val() == '') {
                e.preventDefault();
                $('#errNewPass').text('Vui lòng nhập mật khẩu mới của bạn và nhập lại.');
            }
            if ($('#newpass').val() != $('#repass').val()) {
                e.preventDefault();
                $('#errRePass').text('Nhập lại mật khẩu không khớp.');
            }
        })
    });
</script>

<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('Vui lòng kiểm tra (các) lỗi sau:\\n";
    foreach ($_SESSION['error'] as $value) {
        echo " - " . $value . "\\n";
    }
    echo "')</script>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['errDB'])) {
    echo "<script>alert('{$_SESSION['errDB']}')</script>";
    unset($_SESSION['errDB']);
}
?>
</html>
<?php $conn->close(); ?>