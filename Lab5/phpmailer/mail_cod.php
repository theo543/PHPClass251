<?php

require_once('class.phpmailer.php');
require_once('mail_config.php');

// Mesajul
$message = "Mesajul ce va fi transmis";

// În caz că vre-un rând depășește N caractere, trebuie să utilizăm
// wordwrap()
$message = wordwrap($message, 160, "<br />\n");


$mail = new PHPMailer(true); 

$mail->IsSMTP();

try {
 
  $mail->SMTPDebug  = 0;                     
  $mail->SMTPAuth   = true; 

  $to='dawphp2023@gmail.com';
  $nume='Daw Project';

  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;                   
  $mail->Username   = $username;  			// GMAIL username
  $mail->Password   = $password;            // GMAIL password
  $mail->AddReplyTo('dawphp2023@gmail.com', 'Daw Project');
  $mail->AddAddress($to, $nume);
 
  $mail->SetFrom('dawphp2023@gmail.com', 'Daw Project');
  $mail->Subject = 'Test';
  $mail->AltBody = 'To view this post you need a compatible HTML viewer!'; 
  $mail->MsgHTML($message);
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //error from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //error from anything else!
}
?>
