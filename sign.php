<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("PHPMailer/src/PHPMailer.php");
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

require_once("conn.php");
require_once("header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Error: Passwords do not match!')</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

        if ($stmt->execute()) {
            // Send confirmation email
            $mail = new PHPMailer(true);

            try {
                // SMTP Server Configuration
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'kiptoomaxwell82@gmail.com'; 
                $mail->Password   = 'gvktixzyklwrzagq'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                // Email Sender and Recipient
                $mail->setFrom('kiptoomaxwell82@gmail.com', 'Laundry System');
                $mail->addAddress($email, $name);

                // Email Content
                $mail->isHTML(true);
                $mail->Subject = 'Welcome to Laundry System!';
                $mail->Body    = "Hi <b>$name</b>,<br><br>Thank you for signing up! Your account has been created successfully.<br><br>Kind Regards,<br>Laundry Team";

                $mail->send();
                echo "<script>alert('Account created successfully! Confirmation email sent.'); window.location.href='login.php';</script>";
                exit;

            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry System - Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="signup-container">
        <h2>Create an Account</h2>
        <form action="sign.php" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
