<?php
//This file contain database connection
define('HOST', 'localhost');
define('USER', 'root');
define('PWD', '');
define('DB', 'datadoan');

function connect() {
    $conn = new mysqli(HOST, USER, PWD, DB);
    if($conn->connect_error) {
        return null;
    } else {
        return $conn;
    }
}


function pdoConn(){
    $host = HOST;
    $db = DB;
    $dsn = "mysql:host=$host; dbname=$db; charset=UTF8";
    try {
        $con = new PDO ($dsn, USER, PWD);
        if($con) {
            return $con;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
        return $error;
    }
}

$con = pdoConn();
$id = 2;
$sql = "SELECT * FROM customers WHERE customerID = :id";
$stm = $con->prepare($sql);
$stm->execute([':id'=>$id]); //bind parameter inside execute method by parsing an array
$stm->setFetchMode(PDO::FETCH_OBJ); //set fetch mode to 'object' (default is 'assoc')

$user = $stm->fetch();
// echo $user->customerName ."-". $user->customerEmail;
?>