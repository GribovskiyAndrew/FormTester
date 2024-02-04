<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function sendEmailWithAttachment($recipientEmail, $attachmentPath) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Set to 2 for debugging
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your@example.com'; // SMTP username
        $mail->Password   = 'your_password';   // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port       = 587;   // TCP port to connect to

        // Sender info
        $mail->setFrom('your@example.com', 'Your Name');

        $mail->addAddress($recipientEmail);

        $mail->addAttachment($attachmentPath);

        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Form test results';
        $mail->Body    = 'Form test results';

        $mail->send();
        print_r('Email has been sent!');
    } catch (Exception $e) {
        print_r("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

$recipientEmail = 'recipient@example.com';
$attachmentPath = 'path/to/your/file.pdf';

sendEmailWithAttachment($recipientEmail, $attachmentPath);