<?php
// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json'); // Set header for JSON response

$response = array(); // Initialize response array

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
            $mail->Username = 'contact@mosaique.link'; // SMTP username
            $mail->Password = 'xielvuhnilualpgi'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('contact@mosaique.link'); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = "Japanese Mosaique Contact Form Submission from $name";

            // Inline CSS styling
            $mail->Body    = "
                <div style='max-width: 700px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: Arial, sans-serif; color: #333333;'>
                    <div style='background-color: #007BFF; color: #ffffff; padding: 10px 20px; border-radius: 8px 8px 0 0; font-size: 20px; font-weight: bold;'>
                        Contact Form Submission
                    </div>
                    <div style='padding: 20px; font-size:20px;'>
                        <p><strong>Name:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Message:</strong></p>
                        <p>$message</p>
                    </div>
                    <div style='padding: 10px 20px; font-size: 17px; color: #777777; border-top: 1px solid #dddddd;'>
                        This message was sent from the contact form on Japanese.mosaique.link website.

.
                    </div>
                </div>
            ";

            $mail->AltBody = "Name: $name\nEmail: $email\n\nMessage:\n$message";

            $mail->send();
            $response['status'] = 'success';
            $response['message'] = "Thank you for contacting us";
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = "There was an error sending your message. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = "All fields are required!";
    }
} else {
    $response['status'] = 'error';
    $response['message'] = "Invalid request method!";
}

echo json_encode($response); // Return JSON response
?>
