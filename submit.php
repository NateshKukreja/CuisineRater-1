<?php
if(isset($_POST['submit'])){ //check if form was submitted
  $message = "<div class='w3-panel w3-pale-green w3-padding-16' id='contact_message'>
		<p>Thank you! The email has been sent to you!</p>
  </div>";
}
$email = $_POST['email'];
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
$from = "info@rukazana.com";
$send = "Hello " . (isset($name) ? $name : "User") . ",\n\n";
$admin_email = "production.outspace@gmail.com";
$send .= "Thank you for asking to download our app. Here is the <a href='#'>link</a> to download the app. \n\n*********************\nDo not reply to this message. \n\nThank you!\n********************";
$headers = "From:" . $from;
mail($email,"App Download",$send, $headers);
?>
