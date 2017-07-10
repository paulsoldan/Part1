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
	<form method="POST">
		<div>
			<?php
			$query = "SELECT id, title, description, price FROM products";
			mysqli_query($db, $query) or die('Error querying database.');
			$result = mysqli_query($db, $query);
			while ($row = mysqli_fetch_array($result)) {
				?>
				<ul>
				<?php
					echo $row['id'] . ' ' . $row['title'] . ': ' . $row['description'] . ' ' . $row['price'] .'<br />';
				?>
				</ul>
			<?php
			}
			mysqli_close($db);
			?>
		</div>
	</form>
</body>
</html>