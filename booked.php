<?php

require_once("conn.php");
require_once("adminheader.php");


$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
} else {
    $bookings = [];
}

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
        <h2>Bookings Overview</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Service</th>
                <th>Price</th>
                <th>Date</th>
                <th>Location</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php if (!empty($bookings)): ?>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['service']); ?></td>
                        <td><?php echo htmlspecialchars($booking['price']); ?></td>
                        <td><?php echo htmlspecialchars($booking['date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['place']); ?></td>
                        <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                        <td>
                            <select>
                                <option value="Pending" <?php echo $booking['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?php echo $booking['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Completed" <?php echo $booking['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </td>
                        <td>
                            <a href="update_booking.php?id=<?php echo $booking['id']; ?>" class="btn">Update</a>
                            <button class="btn" onclick="deleteBooking(<?php echo $booking['id']; ?>)">Delete</button>
                        </td>                      
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No bookings available.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        function deleteBooking(id) {
            if (confirm('Are you sure you want to delete this booking?')) {
               window.location.href = 'delete_booking.php?id=' + id;
            }
        }
    </script>
</body>
</html>
