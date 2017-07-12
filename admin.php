<?php 
/*session_start();
$_SESSION['cart'] = array();
include("connection_db.php");
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
	$query = "SELECT * FROM products";
}
else{
	$eNum = implode(',',$_SESSION['cart']);
	$query = "SELECT * FROM products where id not in ($eNum) ";
}
mysqli_query($db, $query) or die('Error querying database.');
$result = mysqli_query($db, $query);
mysqli_close($db);*/
?>



<?php
include("connection_db.php");
$msg="";
	if(isset($_POST['save'])){
		$target="img/".basename($_FILES['image']['name']);
		$image=$_FILES['image']['name'];
		$title=$_POST['title'];
		$description=$_POST['description'];
		$price=$_POST['price'];
		
		/*echo $target ,'<br>';
		echo $image ,'<br>';
		echo $title ,'<br>';
		echo $description ,'<br>';
		echo $price ,'<br>';*/

		$stmt = mysqli_stmt_init($db);
		//$query="INSERT INTO products (image, title, description, price) values ('$image', '$title', '$description', '$price')";
		$query="INSERT INTO products (image, title, description, price) values (?, ?, ?, ?)";
		if(!mysqli_stmt_prepare($stmt, $query))
		{
	    	print "Failed to prepare statement\n";
		}
		else
		{
			mysqli_stmt_bind_param($stmt, 'sssd', $image, $title, $description, $price);
		}
		//mysqli_query($db, $query) or die('Error querying database.');
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if(move_uploaded_file($_FILES['image']['tmp_name'], $target))
		{
			$msg="Image uploaded successfully";
		}
		else
		{
			$msg="There was a problem uploaded image";
		}
		echo $msg;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
<body>
<h1>Welcome ADMIN</h1>
<form name="addProduct" method="POST" action="product.php">
	<input type="submit" name="update" id="update" value="Add product"/>
</form>
<?php while ($row = mysqli_fetch_array($result)): ?>
<form name="form" id="form" action="product.php?id=<?php echo $row["id"]; ?>" method="POST" enctype="multipart/form-data">
     	<div>  
            <img src="img/<?php echo $row["id"]; ?>.jpg" class="img-responsive" align = "left" height="200" width="300"> 								
            <h1 name="title"><?=$row["title"]; ?></h1> 
            <h4><?=$row["description"]; ?></h4> 
            <h2><?=$row["price"]; ?> lei</h2>   
            <table>
    			<tr>
          			<!-- Some input fields -->
        			<input type="submit" name="update" id="update" value="Update" />
    			</tr>
    			<tr>
          			<!-- Some more input fields -->
        			<input type="submit" name="delete" id="delete" value="Delete" />
    			</tr>
			</table>                               	
            <br><br>
        </div> 
    </form>
    <?php endwhile; ?>
</body>
</html>

