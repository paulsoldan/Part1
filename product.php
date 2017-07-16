<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
</head>
<body>
<h1>Product Page</h1>
<form method="POST" action="update.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
<?php //while ($row = mysql_fetch_array($result)){ ?>
	<h5>Image</h5>
	<br>
	<input type="file" name="image" id="fileToUpload">
	<h5>Title</h5>
	<br>
	<input type="text" name="title"  value="<?php // echo $row["title"]; ?>">
	<h5>Description</h5>
	<br>
	<input type="text" name="description">
	<h5>Price</h5>
	<br>
	<input type="text" name="price">
	<br>
	<input type="submit" name="save" value="Save">
	<input type="submit" name="update" value="Update">
<?php
//} 
?>
</form>
</body>
</html>