<?php
session_start();
include("connection_db.php");
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if(!isset($_GET['id'])){
    $id=-1;
}
else{
    $id=$_GET['id'];
}
//var_dump($id);
//var_dump($_SESSION['cart']);
array_push($_SESSION['cart'],$id);
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
	<h2>Cart:</h2>
	<ul>
		<div>
			<?php while ($row = mysqli_fetch_array($result)) :                   
                    if (in_array($row['id'], $_SESSION['cart']))
                    {
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
                endwhile;
            ?>
		</div>
	</ul>
</body>