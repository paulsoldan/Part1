<?php 
session_start();
include("connection_db.php");
include("C:/xampp\htdocs\db_connection\config.php");
if(isset($_POST['send'])){
    $email=$_POST['email'];
    $messageGuest=$_POST['comment'];
    
    $query = "SELECT * FROM products";
    $stmt = mysqli_stmt_init($db);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $products=array();
    while ($row = mysqli_fetch_array($result)){                   
        if (in_array($row['id'], $_SESSION['cart']))
        {
            array_push($products,$row['title']);
            array_push($products,$row['description']);
            array_push($products,$row['price']);
            array_push($products,"/////////////////");
        }
    }
    //print_r($products);
    $prod="";
    foreach($products as $item){
        $prod=$prod . $item . "-->";
    }
    //echo $prod;
    
    require_once('../PHPMailer-master/PHPMailerAutoload.php');
    $mail             = new PHPMailer();
    //$body             = eregi_replace("[\]",'',$body);
    $mail->IsSMTP(); // telling the class to use SMTP                   // enables SMTP debug information (for testing)
    $mail->SMTPSecure = "ssl";                                            // 1 = errors and messages
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                                           // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Username   = $userEmail;  // GMAIL username
    $mail->Password   = $passEmail;            // GMAIL password
    $mail->SetFrom('contact@prsps.in', 'PRSPS');
    //$mail->AddReplyTo("user2@gmail.com', 'First Last");
    $mail->Subject    = "Products in Cart";
    $body = "Comment: " . $messageGuest . '. ' . "Products in cart: " . $prod;
    $mail->MsgHTML($body);
    //echo $messageGuest;
    $address = $email;
    $mail->AddAddress($address, "user2");

    $_SESSION['cart']=array();
    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      echo "Message sent!";
    }

}
if(isset($_POST['deleteCart'])){
	$id=$_GET['id'];
    foreach( $_SESSION['cart'] as $key => $val){
        if($val == $id){
            unset($_SESSION['cart'][$key]);
        }
    }
}
//var_dump($_SESSION['cart']);
if (!isset($_SESSION['cart'])||empty($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    
}
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
    <form method="post" action="cart.php">
        <input type="submit" value="Cart" />
    </form>
	<ul>
		<div>
			<?php while ($row = mysqli_fetch_array($result)) :
                    if (!in_array($row['id'], $_SESSION['cart']))                    
                    {?>
                    <div>
                        <form method="POST" action="cart.php?id=<?php echo $row["id"];  ?>">
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
                    }
                endwhile;
            ?>
		</div>
	</ul>
</body>
</html>