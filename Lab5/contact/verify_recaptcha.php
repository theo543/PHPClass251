<?php
function process_email_submit() {
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

    {
        // Google reCAPTCHA API secret key 
        require(dirname(__FILE__) . "/recaptcha_keys.secret.php");

        // reCAPTCHA response verification
        $verify_captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($RECAPTCHA_SECRET_KEY) . '&response=' . urlencode($_POST['g-recaptcha-response']));
    }

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

    try {
        $mail = new PHPMailer(true);

        $mail->IsSMTP();

        $mail->SMTPDebug = 3;
        $mail->SMTPAuth = true;

        $toEmail = '';
        $nume = 'DAW Project';

        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        {
            require(dirname(__FILE__) . "/mail_config.secret.php");
            $mail->Username = $MAIL_USERNAME; // GMAIL username
            $mail->Password = $MAIL_PASSWORD; // GMAIL password
            $toEmail = $MAIL_DESTINATION;
        }
        $mail->AddReplyTo($toEmail, 'DAW - project');
        $mail->AddAddress($toEmail, $nume);
        $mail->AddCC($email);

        $mail->SetFrom($email, $name);
        $mail->Subject = 'Formular contact';
        $mail->AltBody = 'To view this post you need a compatible HTML viewer!';
        $mail->MsgHTML($mailBody);

        $mail->Send();

        return 'Your message has been submitted successfully.';

    } catch (phpmailerException $e) {
        echo "PHPMailer exception:";
        echo $e->errorMessage(); //error from PHPMailer
    }
}

echo process_email_submit();
