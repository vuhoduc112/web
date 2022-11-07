<?php session_start();
require 'admin/database.php';
if (isset($_POST['login'])) {
    $conn = connect();
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM customers WHERE customerEmail = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param("s", $email);
    $stm->execute();
    $result = $stm->get_result();
    if ($result->num_rows > 0) {
        while ($user = $result->fetch_assoc()) {
            if (password_verify($pass, $user['password']) === true) {
                $_SESSION['login'] = true;
                $_SESSION['cid'] = $user['customerID'];
                $_SESSION['name'] = $user['customerName'];
                $_SESSION['email'] = $user['customerEmail'];
                $_SESSION['phone'] = $user['customerPhone'];
                if (isset($_SESSION['customerCart'])) {
                    header("location: customer-cart.php");
                } else {
                    header ("location: index.php");
                }
            } else {
                $_SESSION['error'] = 'Email hoặc mật khẩu không hợp lệ.';
                header("location: login.php");
            }
        }
    } else {
        $_SESSION['error'] = 'Email hoặc mật khẩu không hợp lệ.';
        header("location: login.php");
    }
}
