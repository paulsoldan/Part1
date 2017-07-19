<?php  
require_once("connection_db.php");

if(isset($_POST['save']) && isset($_FILES['image']['name'])):
	$target="img/".basename($_FILES['image']['name']);
	$image=$_FILES['image']['name'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$price=$_POST['price'];
	while(file_exists("img/" .$image)):
		$image = "1" . $image;
	endwhile;
	$stmt = mysqli_stmt_init($db);
	$query="INSERT INTO products (image, title, description, price) values (?, ?, ?, ?)";
	if(!mysqli_stmt_prepare($stmt, $query)):
		print "Failed to prepare statement\n";
	else:
		mysqli_stmt_bind_param($stmt, 'sssd', $image, $title, $description, $price);
	endif;
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
    if($_FILES['uploaded_file']['size'] >= 5242880):
        $msg="File too large. File must be less than 5 MB.";
    else:
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)):
            $msg="Image uploaded successfully";
        else:
            $msg="There was a problem uploaded image";
        endif;
    endif;
	header("Location: admin.php");
    exit();
endif;

if(isset($_POST['update']) && isset($_FILES['image']['name'])){
	$id=$_GET['id'];
	$stma=mysqli_stmt_init($db);
	$query="SELECT * from products WHERE id = ?";
	if(!mysqli_stmt_prepare($stma, $query)):
	    print "Failed to prepare statement\n";
	else:
		mysqli_stmt_bind_param($stma, 'i', $id);
	endif;
	mysqli_stmt_execute($stma);
	$res=mysqli_stmt_get_result($stma);
	while ($row = mysqli_fetch_array($res)):
			$image = $row['image'];
	endwhile;
	
	if (file_exists("img/" .$image)):
        unlink("img/" . $image);
    else:
    	echo "File not found";
        // File not found.
    endif;
	$values = array($_FILES['image']['name'],$_POST['title'],$_POST['description'],$_POST['price'],$id);
	//delete file from hdd
	$stmt=mysqli_stmt_init($db);
	$query="UPDATE products SET image = ?, title = ?, description = ?, price = ?  WHERE id = ?";
	if(!mysqli_stmt_prepare($stmt, $query)):
	    print "Failed to prepare statement\n";
	else:
		mysqli_stmt_bind_param($stmt, 'sssdd', $values[0], $values[1], $values[2], $values[3], $values[4]);
	endif;
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
	
	$target="img/".basename($_FILES['image']['name']);
    if($_FILES['uploaded_file']['size'] >= 5242880):
        $msg="File too large. File must be less than 5 MB.";
    else:
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)):
            $msg="Image uploaded successfully";
        else:
            $msg="There was a problem uploaded image";
        endif;
    endif;
	header("Location: admin.php");
    exit();
}
 ?>