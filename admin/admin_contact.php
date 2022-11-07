<div class="content">
    <h2>Phản hồi và Liên hệ</h2>
    <div class="user list row">
        <div class="col-md-3 title" style="padding-bottom: 10px;">
            <h4 style="visibility:hidden">Phản hồi và Liên hệ</h4>
        </div>
        <div class="col-md-4" style="padding-bottom: 10px;">
            <!-- <form action="" method="get" class="src-form" style="position: absolute; right: 45px; width:30%;">
                <div class="search-bar input-group">
                    <input name="searchvalue" type="search" id="searchbar" class="form-control src" placeholder="Search" />
                    <button class="btn btn-outline-success" type="submit" name="search" id='src-submit'>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form> -->
        </div>

        <div class="display">
            <!-- display user list from database -->
            <?php
            admin_contact();
            ?>
        </div>
    </div>
</div>
</div>
<?php
if (isset($_SESSION['error1'])) {
    echo "<script>alert('{$_SESSION['error1']}')</script>";
    unset($_SESSION['error1']);
}

if (isset($_SESSION['error2'])) {
    echo "<script>alert('Operation FAILED! Please check the following error(s):\\n";
    foreach ($_SESSION['error2'] as $value) {
        echo " - " . $value . "\\n";
    }
    echo "')</script>";
    unset($_SESSION['error2']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    print_r($_SESSION['success']);
    unset($_SESSION['success']);
}
?>