<?php 
require_once("connection_db.php");
require_once("config.php");

if(empty($_POST['username']) || empty($_POST['password'])):
    echo 'Please Login!';
else:
    if($_POST['username'] == $login_username && $_POST['password']==$login_password):
        $_SESSION['username'] = $_POST['username'];
        header('Location: admin.php');
        exit();
    endif;
endif;
if(!empty($_SESSION['username'])):
	header('Location: admin.php');
    exit();
endif;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h2>Login:</h2>    
    <form name="login" method = "POST">
        <label for="username">
            Username</label> <input type="username" id="username" name="username" required="required"><br><br>
        <label for="password">
            Password:</label> <input type="password" id="password" name="password" required="required"><br><br>
        <button type = "submit" name="submit">Login</button><br><br>       
    </form>
</body>
</html>