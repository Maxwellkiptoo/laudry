<?php
require_once("conn.php");
require_once("adminheader.php");

$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);

$complaints = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Laundry Management</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="container">
        <h2>Complaints Received</h2>
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
                            <a href="update_complaint.php?id=<?php echo $complaint['id']; ?>" class="btn">Update</a>
                            <button class="btn" onclick="deleteComplaint(<?php echo $complaint['id']; ?>)">Delete</button>
                        </td>                      
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">Your Customers are okay.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        function deleteComplaint(id) {
            if (confirm('Are you sure you want to delete this concern?')) {
                window.location.href = 'admindelete_complaint.php?id=' + id;
            }
        }
    </script>
</body>
</html>
