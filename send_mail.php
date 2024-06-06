<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (!empty($name) && !empty($email) && !empty($message)) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0; // Disable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'kumaraguru@mosaique.link'; // SMTP username
            $mail->Password = 'ehhhtwjmtpijbulr'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('kumaraguru@mosaique.link'); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = "Japanese Mosaique Website from $name";
            $mail->Body    = "<b>Name:</b> $name<br><b>Email:</b> $email<br><br><b>Message:</b><br>$message";
            $mail->AltBody = "Name: $name\nEmail: $email\n\nMessage:\n$message";

            $mail->send();
            echo "Thank you for contacting us";
        } catch (Exception $e) {
            echo "There was an error sending your message. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "All fields are required!";
    }
} else {
    echo "Invalid request method!";
}
?>
