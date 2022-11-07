<div class="content">
    <h2>Bảng Điều Khiển</h2>
    <div class='row' style="padding-left: 10px;padding-right: 10px;">
        <div class="col-3">
            <div class="stat-user">
                <div class="text">
                    Khách Hàng
                </div>
                <div class="number">
                    <i class="fa fa-male" aria-hidden="true"></i>
                    <?php echo totalCustomer() ?>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-lsale">
                <div class="text">
                    Hoá đơn trong tuần
                </div>
                <div class="number">
                    <i class="fa fa-list" aria-hidden="true"></i>
                    <?= number_format(admin_countOrder()) ?>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-csale">
                <div class="text">
                    Sale hôm nay
                </div>
                <div class="number">
                    $<?= number_format(admin_saleValue(date('Y-m-d'))) ?>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-total">
                <div class="text">
                    Tổng sale
                </div>
                <div class="number">
                    $<?= number_format(admin_saleValue('')) ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="list">
        <div class="row">
            <div class="col-4">
                <h3>Danh sách đơn hàng</h3>
            </div>
            <div class="col-4">
                <form action="" method="post" id='search'>
                    <div class="input-group">
                        <input style="max-width:50%" type="date" class='form-control' name="date" id="">
                        <button type="submit" name="search" value="" class="btn btn-outline-success">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input style="max-width:90%" type="search" class="form-control src" name="searchvalue" id="searchbar" placeholder="Search">
                    <button class="btn btn-outline-success" type="submit" name="search" id='src-submit'>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST['search'])) {
            if (isset($_POST['date'])) {
                $date = $_POST['date'];
            } else {
                $date = '';
            }
            admin_displayOrder($_POST['searchvalue'], $date);
        } else {
            admin_displayOrder('', '');
        }
        ?>
    </div>
    <form id='mng-product' action='processOrder.php' method='post'>
        <div class="modal fade" id="process" tabindex="-1" aria-labelledby="processLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="processLabel">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                            Chi tiết đơn hàng
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="order-detail">
                        <!-- ajax jquery fetching data here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('{$_SESSION['error']}')</script>";
    unset($_SESSION['error']);
}
?>
