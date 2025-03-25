<?php
require_once("conn.php");
require_once("adminheader.php");

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    $sql = "SELECT * FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if (!$admin) {
        echo "<script>alert('Admin not found!'); window.location.href='admin.php';</script>";
        exit();
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $check_sql = "SELECT id FROM admins WHERE email = '$email'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: Email is already registered!');</script>";
        exit;
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE admins SET name = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("sssi", $name, $email, $hashed_password, $admin_id);
    } else {
        $sqlUpdate = "UPDATE admins SET name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("ssi", $name, $email, $admin_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Admin updated successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error updating admin.'); window.location.href='update_admin.php?id=$admin_id';</script>";
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
    <title>Update Admin</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="container">
        <h2>Update Admin</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($admin['id']); ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>

            <label>Password (leave blank to keep current):</label>
            <input type="password" name="password">

            <button type="submit">Update Admin</button>
        </form>
    </div>
</body>
</html>
