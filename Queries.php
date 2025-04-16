<?php
session_start();
require_once("conn.php");
require_once("headerhome.php");

if (!isset($_SESSION['email']) || !isset($_SESSION['phone'])) {
    echo "<script>alert('You must be logged in to submit a complaint.'); window.location.href='login.php';</script>";
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM complaints WHERE email = '$email'"; 
$result = $conn->query($sql);
$complaints = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $status = "Pending"; 

    $sql = "INSERT INTO complaints (name, email, phone, subject, message, status) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Complaint submitted successfully!'); window.location.href='home.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Complaint</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>

<div class="container">
    <h2>Your Complaints</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Response</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($complaints)): ?>
            <?php foreach ($complaints as $complaint): ?>
                <tr>
                    <td><?php echo htmlspecialchars($complaint['name']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['email']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['phone']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['subject']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['message']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['status']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($complaint['response'] ?? 'No response yet'); ?></td>
                    <td>
                       <button class="btn" onclick="deleteComplaint(<?php echo $complaint['id']; ?>)">Delete</button>
                    </td>                      
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">You have no complaints submitted yet.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script>
    function deleteComplaint(id) {
        if (confirm('Are you sure you want to delete this concern?')) {
           window.location.href = 'delete_complaint.php?id=' + id;
        }
    }
</script>

<section id="complaint-form">
    <h2>Submit a Complaint</h2>
    <form id="complaintForm" action="" method="POST">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" readonly>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>     

        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>" readonly>

        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" placeholder="Enter Subject" required>

        <label for="message">Complaint Details</label>
        <textarea id="message" name="message" placeholder="Describe your issue in detail..." rows="5" required></textarea>
        <button type="submit">Submit Complaint</button>       
        <a href="home.php" class="back-button">Go Back</a>
    </form>
</section>
</body>
</html>
