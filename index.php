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
	<h2>Products:</h2>
	<?php
		include("connection_db.php");
	?>
	<ul>
		<div>
			<?php
			
			if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
				$query = "SELECT id, title, description, price FROM products";
			}
			else{
				$eNum = implode(',',$_SESSION['cart']);
				$query = "SELECT id, title, description, price FROM products where id not in ($eNum) ";
			}
			mysqli_query($db, $query) or die('Error querying database.');
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_array($result)) {
				//echo $row['id'] . ' ' . $row['title'] . ': ' . $row['description'] . ' ' . $row['price'] ;
				?>
				<div>  
                     <form method="POST" action="cart.php?id=<?php echo $row["id"]; ?>">  
                          <div>  
                               	<img src="img/<?php echo $row["id"]; ?>.jpg" class="img-responsive" align = "left" height="200" width="300"> 
								
                               		<h1 name="title"><?php echo $row["title"]; ?></h1> 
                               		<h4><?php echo $row["description"]; ?></h4> 
                               		<h2><?php echo $row["price"]; ?> lei</h2>   
                               		<input type="submit" value="Add to Cart" />  
                               	
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
</html>