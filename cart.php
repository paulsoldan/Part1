<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title></title>
</head>
<body>
	<h2>Cart:</h2>
	<?php
		include("connection_db.php");
	?>
	<ul>
		<div>
			<?php
			$id = $_GET["id"];
			if (!isset($_SESSION['cart'])) {
    			$_SESSION['cart'] = array();
			}
			array_push($_SESSION['cart'], "'".$id."'");
			$eNum = implode(',',$_SESSION['cart']);
			$query = "SELECT * FROM products where id in ($eNum) ";
			mysqli_query($db, $query) or die('Error querying database.');
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_array($result)) {			
				?>
				<div>  
                     <form method="post" action="index.php?id=<?php echo $row["id"]; ?>">  
                          <div>  
                               	<img src="img/<?php echo $row["image"]; ?>" class="img-responsive" align = "left" height="200" width="300"> 
								<div align="left">
                               		<h1><?php echo $row["title"]; ?></h1> 
                               		<h4><?php echo $row["description"]; ?></h4> 
                               		<h2><?php echo $row["price"]; ?> £</h2>   
                               		<input type="submit" name="deleteCart" value="Delete to Cart" />  
                               	</div>
                               	<br><br>
                          </div>  
                     </form>  
                </div>  
			<?php
			}
			mysqli_close($db);
			?>
		</div>
	</ul>
</body>