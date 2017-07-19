<?php
require_once("connection_db.php");
require_once("functions.php");

if(isset($_POST['deleteCart'])):
	$id=$_GET['id'];
    foreach( $_SESSION['cart'] as $key => $val):
        if($val == $id):
            unset($_SESSION['cart'][$key]);
        endif;
    endforeach;
else:
    cleanArrayCart();
    if(!isset($_GET['id'])):
        $id=0;
    else:
        $id=$_GET['id'];
    endif;
    array_push($_SESSION['cart'],$id);
endif;
if(isset($_POST['send'])):
    $email=$_POST['email'];
    $messageGuest=$_POST['comment'];
    $query = "SELECT * FROM products";
    $stmt = mysqli_stmt_init($db);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $products=array();
    while ($row = mysqli_fetch_array($result)):                 
        if (in_array($row['id'], $_SESSION['cart'])):
            array_push($products,$row['title']);
            array_push($products,$row['description']);
            array_push($products,$row['price']);
            array_push($products,"/////////////////");
        endif;
    endwhile;
    $prod="";
    foreach($products as $item):
        $prod=$prod . $item . "-->";
    endforeach;
    require_once('PHPMailer-master/PHPMailerAutoload.php');
    $mail             = new PHPMailer();
    //$body             = eregi_replace("[\]",'',$body);
    $mail->IsSMTP(); // telling the class to use SMTP                   // enables SMTP debug information (for testing)
    $mail->SMTPSecure = "ssl";                                            // 1 = errors and messages
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                                           // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Username   = $userEmail;  // GMAIL username
    $mail->Password   = $passEmail;            // GMAIL password
    $mail->SetFrom($setFrom, 'PRSPS');
    $mail->Subject    = "Products in Cart";
    $body = "Comment: " . $messageGuest . '. ' . "Products in cart: " . $prod;
    $mail->MsgHTML($body);
    $address = $email;
    $mail->AddAddress($address, "user2");
    $_SESSION['cart']=array();
    if(!$mail->Send()):
      echo "Mailer Error: " . $mail->ErrorInfo;
    else:
      echo "Message sent!";
    endif;
endif;

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
    <a href="index.php" id="Cart">Go to Products</a>
	<ul>
		<div>
			<?php 
            while ($row = mysqli_fetch_array($result)) :                   
                if (in_array($row['id'], $_SESSION['cart'])):
                ?>
                <div>  
                    <form method="post" action="cart.php?id=<?php echo $row["id"]; ?>">  
                        <div>  
                            <img src="img/<?php echo $row["image"]; ?>" class="img-responsive" align = "left" height="300" width="300"> 
                            <div align="left">
                                <h1><?php echo $row["title"]; ?></h1> 
                                <h4><?php echo $row["description"]; ?></h4> 
                                <h2><?php echo $row["price"]; ?> £</h2>   
                                <input type="submit" name="deleteCart" value="Delete from Cart" />  
                            </div>
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
    <br><br>
    <form method="post" action="cart.php">
        <div>
            <input type="email" name="email" placeholder="Email:">
        </div>
        <br>
        <div>
            <input rows="4" cols="50" name="comment"  placeholder="Enter text here..." />
        </div>
        <br>
        <div>
            <input type="submit" name="send" value="Send">
        </div>
    </form>
</body>