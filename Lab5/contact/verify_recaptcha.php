<?php
function process()
{
    if (!isset($_POST['submit'])) {
        return '';
    }
    // Form fields validation check
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone'])) {
        return 'Please fill all the required fields.';
    }
    // reCAPTCHA checkbox validation
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        return 'Please check the CAPTCHA box.';
    }
    // Google reCAPTCHA API secret key 
    $secret_key = 'SECRET KEY';

    // reCAPTCHA response verification
    $verify_captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

    // Decode reCAPTCHA response 
    $verify_response = json_decode($verify_captcha);

    // Check if reCAPTCHA response returns success 
    if (!$verify_response->success) {
        return "CAPTCHA check failed.";
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['content'];

    #email Gmail
    require_once('../phpmailer/class.phpmailer.php');
    require_once('../phpmailer/mail_config.php');

    $mailBody = "User Name: " . $name . "\n";
    $mailBody .= "User Email: " . $email . "\n";
    $mailBody .= "Phone: " . $phone . "\n";
    $mailBody .= "Message: " . $message . "\n";

    $mail = new PHPMailer(true);

    $mail->IsSMTP();

    try {

        $mail->SMTPDebug = 3;
        $mail->SMTPAuth = true;

        $toEmail = 'dawphp2023@gmail.com';
        $nume = 'DAW Project';

        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = $username; // GMAIL username
        $mail->Password = $password; // GMAIL password
        $mail->AddReplyTo('dawphp2023@gmail.com', 'DAW - project');
        $mail->AddAddress($toEmail, $nume);
        $mail->addCustomHeader("BCC: " . $email);

        $mail->SetFrom($email, $name);
        $mail->Subject = 'Formular contact';
        $mail->AltBody = 'To view this post you need a compatible HTML viewer!';
        $mail->MsgHTML($mailBody);

        $mail->Send();

        $returnMsg = 'Your message has been submitted successfully.';

    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //error from PHPMailer
    }
}
echo process();
