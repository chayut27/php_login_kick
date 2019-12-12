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

$user = $_POST['username'];
$pass = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ? ");
$stmt->execute(array($user,$pass));

$count = $stmt->rowCount();
if($count > 0){

    $session_id = session_id();
    $row = $stmt->fetch(PDO::FETCH_BOTH);

    if(!empty($row["session_id"])){
        if($row["session_id"] != $session_id){
            $sql = "UPDATE `users` SET `session_id` = '' WHERE `id` = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($row["id"]));

            $_SESSION["msg"] = "มีผู้ใช้งาน username นี้อยู้กรุณา login อีกครั้ง.";
            header("location:index.php?m=notequal");
            exit();
        }else{
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["session_id"] = $row["session_id"];
            header("location:home.php?m=equal");
            exit();
        }
    }else{
        $sql = "UPDATE `users` SET `session_id` = ? WHERE `id` = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($session_id,$row["id"]));

        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];

        $stmt = $conn->prepare("SELECT `session_id` FROM `users` WHERE `id` = ? ");
        $stmt->execute(array($row["id"]));
        $row = $stmt->fetch(PDO::FETCH_BOTH);

        $_SESSION["session_id"] = $row["session_id"];
        header("location:home.php?m=empty");
        exit();
    }
   

   

}


?>