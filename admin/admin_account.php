<?php
    if(isset($user)){
        $conn = connect();
        $query = $conn->query("SELECT * FROM staff WHERE staffID = '{$user['userID']}'");
        $userInfo = $query->fetch_object();
        $conn->close();
    }
?>
<div class="content">
    <h2>Thông tin tài khoản</h2>
    <div class="user info">
        <form id="useraccount" action="updateAccount.php" method="post">
            <div class="container" style="width:70%">
                <div class="row mb-3">
                    <div class="col">
                        <label for="name">Tên đăng nhập:</label>
                        <input id='name' type="text" class='form-control' disabled value="<?=isset($userInfo)?$userInfo->userName:''?>">
                    </div>
                    <div class="col">
                        <label for="email">Email:</label>
                        <input type="hidden" id='hidden-email' value="<?=isset($userInfo)?$userInfo->email:''?>">
                        <input id='email' name="email" type="text" class='form-control' value="<?=isset($userInfo)?$userInfo->email:''?>">
                        <i><small id='errEmail' style="color:red"></small></i>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="oldpass">Mật khẩu cũ:</label>
                        <input id='oldpass' name='oldpass' type="password" class='form-control'>
                        <i><small id='errOldPass' style="color:red"></small></i>
                    </div>
                    <div class="col">
                        <label for="newpass">Mật khẩu mới:</label>
                        <input id='newpass' name='newpass' type="password" class='form-control'>
                        <i><small id='errNewPass' style="color:red"></small></i>
                    </div>
                    <div class="col">
                        <label for="repass">Nhập lại mật khẩu:</label>
                        <input id='repass' name='repass' type="password" class='form-control'>
                        <i><small id='errRePass' style="color:red"></small></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="text-align:center">
                        <input id='change-email' style="width:200px" type="submit" value="Thay đổi Email" name="upemail" class="btn btn-primary">
                        <input id='change-pass' style="width:200px" type="submit" value="Thay đổi mật khẩu" name="uppass" class="btn btn-warning">
                    </div>
                </div>
            </div>

        </form>
    </div>
    <hr>
</div>
<script>
    $('#change-email').on('click', function(e){
        if($('#hidden-email').val() == $('#email').val()){
            e.preventDefault();
            $('#errEmail').text('Nothing changes!');
        }
    })

    $('#change-pass').on('click', function(e){
            if($('#oldpass').val() == ''){
                e.preventDefault();
                $('#errOldPass').text('Please enter your old password.');
            }
            if($('#newpass').val() == '' || $('#repass').val()==''){
                e.preventDefault();
                $('#errNewPass').text('Please enter your new password.');
                $('#errRePass').text('Please re-enter your new password.');
            }
            if($('#newpass').val() != $('#repass').val()){
                e.preventDefault();
                $('#errRePass').text('Re-type password mismatched.');
            }
        })
</script>
</div>
<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('{$_SESSION['error']}')</script>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    print_r($_SESSION['success']);
    unset($_SESSION['success']);
}
?>
