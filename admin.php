<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}
include("connection_db.php");
$msg="";
	if(isset($_POST['save'])){
		$target="img/".basename($_FILES['image']['name']);
		$image=$_FILES['image']['name'];
		$title=$_POST['title'];
		$description=$_POST['description'];
		$price=$_POST['price'];
		if (file_exists("img/" .$image)) {
        	$image=$title . $image;
    	}
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
		echo $image;
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
	//unset($_POST['save']);
	//var_dump(unset($_POST['save']));
?>



<?php 
if(isset($_POST['delete'])){
	$id=$_GET['id'];
	//echo $id;

	//delete file from hdd
	$stmt=mysqli_stmt_init($db);
	$query="SELECT * FROM products WHERE id = ?";
	if(!mysqli_stmt_prepare($stmt, $query))
	{
	    print "Failed to prepare statement\n";
	}
	else
	{
		mysqli_stmt_bind_param($stmt, 's', $id);
	}
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
	while ($row = mysqli_fetch_array($result)){
		$image=$row['image'];
	}
    if (file_exists("img/" .$image)) {
        unlink("img/" . $image);
    } 
    else 
    {
    	echo "File not found";
        // File not found.
    }

	//delete from database
	$stmt=mysqli_stmt_init($db);
	$query="DELETE FROM products WHERE id=?";
	if(!mysqli_stmt_prepare($stmt, $query))
	{
	    print "Failed to prepare statement\n";
	}
	else
	{
		mysqli_stmt_bind_param($stmt, 's', $id);
	}
	mysqli_stmt_execute($stmt);
}
 ?>

<?php 
	
 ?>

<?php 
	$stm = mysqli_stmt_init($db);
	$query="SELECT * FROM products";
	mysqli_stmt_prepare($stm, $query);
	mysqli_stmt_execute($stm);
	$result=mysqli_stmt_get_result($stm);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
<body>
<h1>Welcome ADMIN</h1>
<form name="addProduct" method="POST" action="product.php">
	<input type="submit" name="addProduct" id="addProduct" value="Add product"/>
</form>
<?php while ($row = mysqli_fetch_array($result)): ?>
    <div>  
     	<form name="form" id="form" action="admin.php?id=<?php echo $row["id"]; ?>" method="POST" enctype="multipart/form-data">
            <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" align = "left" height="200" width="300"> 								
            <h1 name="title"><?=$row["title"]; ?></h1> 
            <h4><?=$row["description"]; ?></h4> 
            <h2><?=$row["price"]; ?> £</h2> 
            <br>                                 	
        </form>
        <table>
        	<form method="POST" action="product.php?id=<?php echo $row["id"]; ?>">
    			<tr>
          			<!-- Some input fields -->
        			<input type="submit" name="update" id="update" value="Update" />
    			</tr>
    		</form>
    		<form method="POST" action="admin.php?id=<?php echo $row["id"]; ?>">
    			<tr>
          			<!-- Some more input fields -->
        			<input type="submit" name="delete" id="delete" value="Delete" />
    			</tr>
    		</form>
		</table>
    </div>
    <?php endwhile; ?>
    <br><a href="logout.php" id="log-out">Logout</a>
</body>
</html>

