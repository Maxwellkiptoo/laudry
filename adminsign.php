<?php
require_once("conn.php");
require_once("header.php");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password !== $confirm_password) {
        echo "<script>alert('Error: Passwords do not match!'); window.location.href='adminsign.php';</script>";
        exit;
    }
    $check_sql = "SELECT id FROM admins WHERE email = '$email'";
    $result = $conn->query($check_sql);
    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Email is already registered!'); window.location.href='adminsign.php';</script>";
        exit;
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account created successfully!'); window.location.href='adminlogin.php';</script>";
        exit;
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="signup-container">
        <h2>Create an Account</h2>
        <form action="" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>
