<?php 
include ("session.php");
if(!empty($_SESSION['username'])){
	header('Location: admin.php');
} ?>
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