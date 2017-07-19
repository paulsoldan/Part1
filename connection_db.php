<?php
    require_once("config.php");
    
    session_start();
	$db = mysqli_connect($host,$user,$password,$database)
	or die('Error connecting to MySQL server.');