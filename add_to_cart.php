<?php
session_start();
include("connection_db.php");
$stmt = mysqli_stmt_init($db);

/*if (!isset($_GET['id']) || empty($_GET['id'])){
	$query = "SELECT * FROM products";
	mysqli_stmt_prepare($stmt, $query);
}
else{*/
	$query = "SELECT * FROM products where id not in (?)"; 
	if(empty($_SESSION['array']) || !isset($_SESSION['array'])){
		$_SESSION['array'] = array();
	}

	array_push($_SESSION['array'], "'".$_GET['id']."'");
	$eNum = implode(',',$_SESSION['array']);
	//echo $eNum;
	var_dump($eNum);
	if(!mysqli_stmt_prepare($stmt, $query))
	{
	    print "Failed to prepare statement\n";
	}
	else
	{
		mysqli_stmt_bind_param($stmt, 's', $eNum);
	}

	//$query = "SELECT * FROM products where id not in ($eNum) ";
//}
mysqli_stmt_execute($stmt);
//mysqli_query($db, $query) or die('Error querying database.');
$result = mysqli_stmt_get_result($stmt);
//mysqli_close($db);
header("Location: cart.php");
?>