<?php
require_once("conn.php");
require_once("adminheader.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('User not found!'); window.location.href='admin.php';</script>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];

    $check_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("si", $email, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Error: Email is already registered!'); window.location.href='update_user.php?id=$user_id';</script>";
        exit();
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE users SET name = ?, email = ?, phone = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("ssssi", $name, $email, $phone, $hashed_password, $user_id);
    } else {
        $sqlUpdate = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error updating user.'); window.location.href='update_user.php?id=$user_id';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="container">
        <h2>Update User</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            <label>Password (leave blank to keep current):</label>
            <input type="password" name="password">
            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>
