<?php
require 'vendor/autoload.php'; // Include PHPMailer autoload.php file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $website = $_POST['website'];

    // Simple validation
    if (empty($name) || empty($surname) || empty($email) || empty($website)) {
        http_response_code(400);
        echo "Please fill in all fields.";
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'kumaraguru@mosaique.link';             // SMTP username
        $mail->Password   = 'ehhhtwjmtpijbulr';                     // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption
        $mail->Port       = 587;                                    // TCP port to connect to, use 587 for TLS
        
        //Recipients
        $mail->setFrom('kumaraguru@mosaique.link', 'Karthick Karthick'); // Use your authenticated email
        $mail->addAddress('kumar1@mosaique.link');                 // Add a recipient
        $mail->addReplyTo($email, $name . ' ' . $surname);             // Add the user's email as the Reply-To address
        
        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        background-color: #f9f9f9;
                    }
                    .header {
                        background-color: #007bff;
                        color: #fff;
                        padding: 10px;
                        text-align: center;
                        border-radius: 5px 5px 0 0;
                    }
                    .content {
                        padding: 20px;
                    }
                    .content p {
                        margin: 10px 0;
                    }
                    .footer {
                        text-align: center;
                        padding: 10px;
                        font-size: 12px;
                        color: #777;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h2>Contact Form Submission</h2>
                    </div>
                    <div class="content">
                        <p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>
                        <p><strong>Surname:</strong> ' . htmlspecialchars($surname) . '</p>
                        <p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
                        <p><strong>Website:</strong> ' . htmlspecialchars($website) . '</p>
                    </div>
                    <div class="footer">
                        <p>This message was sent from your website contact form.</p>
                    </div>
                </div>
            </body>
            </html>';
        
        $mail->send();
        echo "Your message has been sent successfully!";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Sorry, there was an error sending your message. Please try again later.";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
