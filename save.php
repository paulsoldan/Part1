<?php  
include("connection_db.php");
print_r($_POST);


if(isset($_POST['save']) && isset($_FILES['image']['name'])){
	$target="img/".basename($_FILES['image']['name']);
	$image=$_FILES['image']['name'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$price=$_POST['price'];
	if (file_exists("img/" .$image)) {
		$image = "1" . $image;
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
	header("Location: admin.php");
}



if(isset($_POST['update']) && isset($_FILES['image']['name'])){
	$id=$_GET['id'];
	$stma=mysqli_stmt_init($db);
	$query="SELECT * from products WHERE id = ?";
	if(!mysqli_stmt_prepare($stma, $query))
	{
	    print "Failed to prepare statement\n";
	}
	else
	{
		mysqli_stmt_bind_param($stma, 'i', $id);
	}
	mysqli_stmt_execute($stma);
	$res=mysqli_stmt_get_result($stma);
	while ($row = mysqli_fetch_array($res)):
			$image = $row['image'];
	endwhile;
	
	if (file_exists("img/" .$image)) {
        unlink("img/" . $image);
    } 
    else 
    {
    	echo "File not found";
        // File not found.
    }

	$values = array($_FILES['image']['name'],$_POST['title'],$_POST['description'],$_POST['price'],$id);
	//echo $id;

	//delete file from hdd
	$stmt=mysqli_stmt_init($db);
	$query="UPDATE products SET image = ?, title = ?, description = ?, price = ?  WHERE id = ?";
	if(!mysqli_stmt_prepare($stmt, $query))
	{
	    print "Failed to prepare statement\n";
	}
	else
	{
		mysqli_stmt_bind_param($stmt, 'sssdd', $values[0], $values[1], $values[2], $values[3], $values[4]);
	}
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
	
	$target="img/".basename($_FILES['image']['name']);
	var_dump($target);
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target))
	{
		$msg="Image uploaded successfully";
	}
	else
	{
		$msg="There was a problem uploaded image";
	}
	header("Location: admin.php");
}
 ?>