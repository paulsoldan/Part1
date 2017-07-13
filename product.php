<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //something posted

    if (isset($_POST['update'])) {
        // update

    } 
    if (isset($_POST['delete'])) {
        // delete
        
    }
}
//$method=$_GET['']
 ?>


 <?php 

  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
</head>
<body>
<h1>Product Page</h1>
<form method="POST" action="admin.php" enctype="multipart/form-data">
	<h5>Image</h5>
	<br>
	<input type="file" name="image" id="fileToUpload">
	<h5>Title</h5>
	<br>
	<input type="text" name="title">
	<h5>Description</h5>
	<br>
	<input type="text" name="description">
	<h5>Price</h5>
	<br>
	<input type="text" name="price">
	<br>
	<input type="submit" name="save" value="Save">
	<input type="submit" name="update" value="Update">
</form>
</body>
</html>