<?php
if ($user['userRole'] != 1) {
    require "accessdenied.html";
} else { ?>
    <div class="content">
        <h2>Quản lý tài khoản</h2>
        <div class="user add">
            <h4>Đăng ký tài khoản</h4>
            <form id="adduser" action="addUser.php" method="post" enctype="multipart/form-data">
                <div class="input-group mb-1">
                    <span class="input-group-text" style="max-width:15%">Tên tài khoản:</span>
                    <input type="text" id="uname" class="form-control" name="uname" placeholder="" aria-label="uname" required>
                    <span class="input-group-text">Loại tài khoản:</span>
                    <select style="max-width:30%;" class="form-select" name="role" id="role">
                        <option value="0">chọn...</option>
                        <?php
                        $conn = connect();
                        $list = $conn->query("SELECT * FROM staffRole");
                        if ($list->num_rows > 0) {
                            while ($item = $list->fetch_assoc()) {
                                echo "<option value=\"{$item['roleID']}\">{$item['roleName']}</option>";
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <span class="input-group-text">Email:</span>
                    <input type="text" id="email" class="form-control" name="email" placeholder="" aria-label="email" required>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" style="max-width:15%">Mật khẩu:</span>
                    <input type="password" id="pass" class="form-control" name="pass" placeholder="" aria-label="pass" required autocomplete="new-password">
                    <span class="input-group-text">Nhập lại mật khẩu:</span>
                    <input id="repass" type="password" class="form-control" name="repass" placeholder="" aria-label="repass" required>
                </div>
                <div class="submit input-group mb3">
                    <input class="btn-add btn btn-primary" type="submit" value="Thêm" name="addUser" id="add">
                    <button class="btn-add btn btn-danger" type="reset" id="reset">Đặt lại</button>
                </div>
            </form>
        </div>
        <hr>
        <div class="user list row">
            <div class="col-md-3 title" style="padding-bottom: 10px;">
                <h4>Danh sách người dùng</h4>
            </div>
            <div class="col-md-4">
                <form action="" method="post" class="src-form" style="position: absolute; right: 45px; width:35%; ">
                    <div class="search-bar input-group">
                        <input name="searchvalue" type="search" id="searchbar" class="form-control src" placeholder="Search" />
                        <button class="btn btn-outline-success" type="submit" name="search" id='src-submit'>
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="display">
                <!-- display user list from database -->
                <?php
                if (isset($_POST['search'])) {
                    $search = $_POST['searchvalue'];
                    admin_displayUser($search);
                } else {
                    admin_displayUser('');
                }
                ?>
            </div>
        </div>
        <!-- Update user -->
        <form id='mng-user' action='updateUser.php' method='post'>
            <div class="modal fade" id="editPanel" tabindex="-1" aria-labelledby="editPanelLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="editPanelLabel">
                                <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                Cập nhập tài khoản
                            </h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="user-detail">
                            <!-- queryUser.php fetchs data here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <input type="submit" value="Lưu thay đổi" name="save" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
<?php } ?>
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