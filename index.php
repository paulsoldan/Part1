<?php 
/*if(isset($_POST['deleteCart'])){
	$id=$_GET['id'];
	echo $id;
}*/
 ?>
<?php
session_start();
$_SESSION['cart'] = array();
include("connection_db.php");
$stmt = mysqli_stmt_init($db);

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
	if(isset($_POST['deleteCart'])){
		$id=$_GET['id'];
		echo $id;
		$_SESSION['cart'] = array_diff($_SESSION['cart'], array('$id'));
		var_dump($_SESSION['cart']);
	}
	$query = "SELECT * FROM products";
	mysqli_stmt_prepare($stmt, $query);
}
else{
	$query = "SELECT * FROM products where id not in (?)"; 
	$eNum = implode(',',$_SESSION['cart']);
	//echo $eNum;
	//var_dump($eNum);
	if(!mysqli_stmt_prepare($stmt, $query))
	{
	    print "Failed to prepare statement\n";
	}
	else
	{
		mysqli_stmt_bind_param($stmt, 's', $eNum);
	}

	//$query = "SELECT * FROM products where id not in ($eNum) ";
}
mysqli_stmt_execute($stmt);
//mysqli_query($db, $query) or die('Error querying database.');
$result = mysqli_stmt_get_result($stmt);
//mysqli_close($db);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title></title>
</head>
<body>
	<h2>Products:</h2>
	<ul>
		<div>
			<?php while ($row = mysqli_fetch_array($result)): ?>
				<div>
                    <form method="POST" action="cart.php?id=<?php echo $row["id"]; ?>">
                        <div>
                            <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" align = "left" height="200" width="300">
                               	<h1 name="title"><?php echo $row["title"]; ?></h1>
                               	<h4><?php echo $row["description"]; ?></h4>
                               	<h2><?php echo $row["price"]; ?> £</h2>
                               	<input type="submit" value="Add to Cart" />
                            <br><br>
                        </div>  
                    </form>  
                </div>  
            <?php endwhile; ?>
		</div>
	</ul>
</body>
</html>