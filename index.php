<?php 
require_once("connection_db.php");
require_once("config.php");
require_once("functions.php");

cleanArrayCart();
$query = "SELECT * FROM products";
$stmt = mysqli_stmt_init($db);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title></title>
</head>
<body>
	<h2>Products:</h2>
    <a href="cart.php" id="Cart">Go to Cart</a>
	<ul>
		<div>
			<?php 
            while ($row = mysqli_fetch_array($result)) :
                if (!in_array($row['id'], $_SESSION['cart'])):
                ?>
                <div>
                    <form method="POST" action="cart.php?id=<?php echo $row["id"]; ?>">
                        <div>
                            <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" align = "left" height="300" width="300">
                                <h1 name="title"><?php echo $row["title"]; ?></h1>
                                <h4><?php echo $row["description"]; ?></h4>
                                <h2><?php echo $row["price"]; ?> £</h2>
                                <input type="submit" value="Add to Cart" />
                            <br><br>
                        </div>  
                    </form>
                    <br><br><br><br><br>
                </div>  
                <?php
                endif;
            endwhile;
            ?>
		</div>
	</ul>
</body>
</html>