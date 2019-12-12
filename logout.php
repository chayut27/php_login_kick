<?php

session_start();

$sql = "UPDATE `users` SET `session_id` = '' WHERE `id` = ? ";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["user_id"]));

session_destroy();
header("location:index.php");
exit();






?>