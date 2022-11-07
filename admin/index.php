<?php
    session_start();
    require 'adminFunction.php';
    if(isset($_SESSION['account'])) {
        unset($_SESSION['account']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--Stop resubmissing form when refreshing page-->
    <script>
        if(window.history.replaceState){
            window.history.replaceState(null, null, location.href);
        }
    </script>
    <link rel="stylesheet" href="../css/adminLogin.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="warper">
        <div class="container">
            <h2>Admin Control Panel</h2><hr>
            <form style="width: 40%; margin: 0 auto;" action="login.php" method="post">
                <input class="input form-control mb-2 mr-sm-2" type="text" placeholder="Enter Username" name="uname" required>
                <input class="input form-control mb-2 mr-sm-2" type="password" placeholder="Enter Password" name="pass" required><br>
                <input class="btn btn-primary" type="submit" name="login" value="Login"><br><br>
                <!-- <input class="form-check-input" type="checkbox" checked="checked" name="remember">&nbsp;Remember me -->
            </form>
            <?php
                if(isset($_SESSION['error'])){
                    echo "<hr><span style='color: red;'>".$_SESSION['error']."</span>";
                    unset($_SESSION['error']);
                }
            ?>
        </div>
    </div>
</body>
</html>