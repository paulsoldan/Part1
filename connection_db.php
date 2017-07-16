<?php
    include("C:/xampp\htdocs\db_connection\config.php");
	$db = mysqli_connect($host,$user,$password,$database)
	or die('Error connecting to MySQL server.');