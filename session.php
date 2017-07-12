<?php session_start();
  if(empty($_POST['username']) || empty($_POST['password'])){
        echo 'Please Login!';
  }
  else
    if($_POST['username'] == "admin" && $_POST['password']=="admin") {
        $_SESSION['username'] = $_POST['username'];
    header('Location: admin.php');
    }
?>