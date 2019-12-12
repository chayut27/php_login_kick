<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";

try{
    $conn = new PDO("mysql:host=$servername;dbname=log_in_kick", $username, $password);
    $conn->exec("set names utf8");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

if(empty($_SESSION["session_id"])){
    header("location:index.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT `session_id` FROM `users` WHERE `id` = ? ");
$stmt->execute(array($user_id));
$row = $stmt->fetch(PDO::FETCH_BOTH);

if($_SESSION["session_id"] != $row["session_id"]){
    session_destroy();
    header("location:index.php?m=y_not_equal");
    exit();
}

echo "ยินดีต้อนรับ : ".$_SESSION["username"];
echo "<br> <a href='logout.php'>ออกจากระบบ</a>";



?>