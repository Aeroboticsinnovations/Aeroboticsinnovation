<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If installed via Composer
include "admin/config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name    = htmlspecialchars(strip_tags($_POST["name"]));
    $email   = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags($_POST["subject"]));
    $message = nl2br(htmlspecialchars(strip_tags($_POST["message"])));

    $secretKey = "6LcNbwIrAAAAAK36H6G7R61-ikRNyYbFnZzdYkH3"; // Replace with your Secret Key
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify response with Google
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captchaSuccess = json_decode($verify);

    if (!$captchaSuccess->success) {
        die(json_encode(["status" => "error", "message" => "reCAPTCHA verification failed."]));
    }

    // Process form data here (e.g., send email)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email address."]);
        exit();
    }

    $sql = "INSERT INTO contact_form (name, email, subject, message)
    VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {

        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aeroboticscontact@gmail.com';
            $mail->Password   = 'zkvw afmb bgtp chfu'; // Use App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Sender & Receiver
            $mail->setFrom($email, $name);
            $mail->addAddress('aeroboticscontact@gmail.com'); // Receiver Email

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "<p><b>Name:</b> $name</p>
                          <p><b>Email:</b> $email</p>
                          <p><b>Message:</b></p>
                          <p>$message</p>";

            // Send email
            $mail->send();

            echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Message could not be sent. Error: {$mail->ErrorInfo}"]);
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
