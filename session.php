<?php session_start();
include("C:/xampp\htdocs\db_connection\config.php");
  if(empty($_POST['username']) || empty($_POST['password'])){
        echo 'Please Login!';
  }
  else
    if($_POST['username'] == $login_username && $_POST['password']==$login_password) {
        $_SESSION['username'] = $_POST['username'];
    header('Location: admin.php');
    }
?>