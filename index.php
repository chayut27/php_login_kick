<?php

session_start();

echo (isset($_SESSION["msg"]) ? $_SESSION["msg"] : '');
unset($_SESSION["msg"]);


?>

<form action="login.php" method="POST">
<fieldset>
<legend>Login:</legend>
    <label for="">Username</label><br>
    <input type="text" name="username"><br>
    <label for="">Password</label><br>
    <input type="text" name="password"><br>

    <input type="submit" value="Login">

</fieldset>
</form>
