<?php
require_once("conn.php");
require_once("adminheader.php");

if (isset($_GET['id'])) {
    $complaint_id = $_GET['id'];
    $sql = "SELECT * FROM complaints WHERE id = $complaint_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $complaint = $result->fetch_assoc();
    } else {
        echo "<script>alert('Complaint not found!'); window.location.href='Adm_Queries.php';</script>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST['id'];
    $status = $_POST['status'];
    $response = trim($_POST['response']);

    $sqlUpdate = "UPDATE complaints SET status='$status', response='$response' WHERE id=$complaint_id";

    if ($conn->query($sqlUpdate)) {
        echo "<script>alert('Complaint updated successfully!'); window.location.href='Adm_Queries.php';</script>";
    } else {
        echo "<script>alert('Error updating complaint: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complaint</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="container">
        <h2>Update Complaint</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $complaint['id']; ?>">

            <label>Name:</label>
            <input type="text" value="<?php echo $complaint['name']; ?>" disabled>

            <label>Email:</label>
            <input type="email" value="<?php echo $complaint['email']; ?>" disabled>

            <label>Phone:</label>
            <input type="text" value="<?php echo $complaint['phone']; ?>" disabled>

            <label>Subject:</label>
            <input type="text" value="<?php echo $complaint['subject']; ?>" disabled>

            <label>Complaint Message:</label>
            <textarea disabled><?php echo $complaint['message']; ?></textarea>

            <label>Response:</label>
            <textarea name="response" required><?php echo $complaint['response'] ?? ''; ?></textarea>

            <label>Status:</label>
            <select name="status">
                <option value="Pending" <?php if ($complaint['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="In Progress" <?php if ($complaint['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Resolved" <?php if ($complaint['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
            </select>

            <button type="submit">Update Complaint</button>
        </form>
    </div>
</body>
</html>
