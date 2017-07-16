<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
</head>
<body>
<h1>Product Page</h1>

    <?php
   
    if (isset($_POST['update'])){
        include("connection_db.php");
        $id=$_GET['id'];
        //echo $id;

        $stmt=mysqli_stmt_init($db);
        $query="SELECT * FROM products WHERE id = ?";
        if(!mysqli_stmt_prepare($stmt, $query))
        {
            print "Failed to prepare statement\n";
        }
        else
        {
            mysqli_stmt_bind_param($stmt, 's', $id);
        }
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_array($result)){
			$title = $row["title"];
            $description = $row["description"];
            $price = $row["price"]; 
        }
    ?>
        <form method="POST" action="save.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
            <h5>Image</h5>
            <br>
            <input type="file" name="image" id="fileToUpload" >
            <h5>Title</h5>
            <br>
            <input type="text" name="title"  value="<?php echo $title; ?>">
            <h5>Description</h5>
            <br>
            <input type="text" name="description" value="<?php echo $description; ?>">
            <h5>Price</h5>
            <br>
            <input type="text" name="price" value="<?php echo $price; ?>">
            <br>
            <input type="submit" name="update" value="Update">
        </form>
    <?php
    }
    else{
        ?>
        <form method="POST" action="save.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
            <h5>Image</h5>
            <br>
            <input type="file" name="image" id="fileToUpload" >
            <h5>Title</h5>
            <br>
            <input type="text" name="title" >
            <h5>Description</h5>
            <br>
            <input type="text" name="description" >
            <h5>Price</h5>
            <br>
            <input type="text" name="price" >
            <br>
            <input type="submit" name="save" value="Save">
        </form>
    <?php
    }
?>
</body>
</html>