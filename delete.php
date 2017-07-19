<?php 
require_once("connection_db.php");

if(isset($_POST['delete'])):
	$id=$_GET['id'];
	//delete file from hdd
	$stmt=mysqli_stmt_init($db);
	$query="SELECT * FROM products WHERE id = ?";
	if(!mysqli_stmt_prepare($stmt, $query)):
	    print "Failed to prepare statement\n";
	else:
		mysqli_stmt_bind_param($stmt, 's', $id);
	endif;
	mysqli_stmt_execute($stmt);
	$result=mysqli_stmt_get_result($stmt);
	while ($row = mysqli_fetch_array($result)):
		$image=$row['image'];
	endwhile;
    if (file_exists("img/" .$image)):
        unlink("img/" . $image);
    else:
    	echo "File not found";
        // File not found.
    endif;

	//delete from database
	$stmt=mysqli_stmt_init($db);
	$query="DELETE FROM products WHERE id=?";
	if(!mysqli_stmt_prepare($stmt, $query)):
	    print "Failed to prepare statement\n";
	else:
		mysqli_stmt_bind_param($stmt, 's', $id);
	endif;
	mysqli_stmt_execute($stmt);
    header("Location: admin.php");
    exit();
endif;
 ?>
