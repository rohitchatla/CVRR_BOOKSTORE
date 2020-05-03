<?php

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "pay";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
	die("Connection failed:".mysqli_connect_error());
}
?>



<?php
	
	\Stripe\Stripe::setVerifySslCerts(false);

	
	$productID = $_GET['id'];

	if (!isset($_POST['stripeToken']) || !isset($products[$productID])) {
		header("Location: pricing.php");
		exit();
	}
	$token = $_POST['stripeToken'];
	$email = $_POST["stripeEmail"];

	$charge = \Stripe\Charge::create(array(
		"amount" => $products[$productID]["price"],
		"currency" => "inr",
		"description" => $products[$productID]["title"],
		"source" => $token,
	));


	
	echo 'Thank you! You have been charged $' . ($products[$productID]["price"]/100);



//endpoint traverse:can be done by:storing in database or sending email.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if(isset($_POST['stripeToken']) || isset($products[$productID])){
$token = $_POST['stripeToken'];
$email = $_POST["stripeEmail"];
$title = $products[$productID]["title"];
$price = $products[$productID]["price"]/100;




$query = mysqli_query($conn, "INSERT INTO payt (email,book,price) VALUES ('$email','$title','$price')");
if(!$query) {
    exit("Error");
}




    $mail = new PHPMailer(true);                           
    try {
        //Server settings
        $mail->isSMTP();                                 
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
        $mail->Username = '';        
        $mail->Password = '';                           
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   

        //Recipients
        $mail->setFrom('', 'CVRR');
        $mail->addAttachment("INVOICE.txt", "INVOICE");
        $mail->addAddress($email);     
        $mail->addReplyTo('noreply@example.com', 'noreply');
        

    
        //Content
        $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/ipn.php?";
        $mail->isHTML(true);
                                     
        $mail->Subject = 'INVOICE-CVRR_BOOKSTORE';
        $mail->Body    = "<h1>Book:details</h1>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        echo '<br>'.'INVOICE has been sent to your email';
    } catch (Exception $e) {
        echo 'Message could not be sent. CVRRMailer Error: ', $mail->ErrorInfo;
    }
exit();
    }
?>
