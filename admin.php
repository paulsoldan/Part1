<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}
include("connection_db.php");
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
            <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" align = "left" height="300" width="300"> 								
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
    		<form method="POST" action="delete.php?id=<?php echo $row["id"]; ?>">
    			<tr>
          			<!-- Some more input fields -->
        			<input type="submit" name="delete" id="delete" value="Delete" />
    			</tr>
    		</form>
		</table>
        <br><br><br><br><br><br>
    </div>
    <?php endwhile; ?>
    <br><a href="logout.php" id="log-out">Logout</a>
</body>
</html>

