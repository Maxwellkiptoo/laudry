<?php
require_once("conn.php");
require_once("adminheader.php");

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    $sql = "SELECT * FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        echo "<script>alert('Booking not found!'); window.location.href='booked.php';</script>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['id'];
    $service = trim($_POST['service']);
    $price = trim($_POST['price']);
    $date = trim($_POST['date']);
    $place = trim($_POST['place']);
    $phone = trim($_POST['phone']);
    $status = $_POST['status'];

    $sqlUpdate = "UPDATE bookings SET service = ?, price = ?, date = ?, place = ?, phone = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("ssssssi", $service, $price, $date, $place, $phone, $status, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='booked.php';</script>";
    } else {
        echo "<script>alert('Error updating booking.'); window.location.href='update_booking.php?id=$booking_id';</script>";
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
    <title>Update Booking</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="container">
        <h2>Update Booking</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
            
            <label>Service:</label>
            <input type="text" name="service" value="<?php echo htmlspecialchars($booking['service']); ?>" required>
            
            <label>Price:</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($booking['price']); ?>" required>
            
            <label>Date:</label>
            <input type="date" name="date" value="<?php echo htmlspecialchars($booking['date']); ?>" required>
            
            <label>Location:</label>
            <input type="text" name="place" value="<?php echo htmlspecialchars($booking['place']); ?>" required>
            
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($booking['phone']); ?>" required>

            <label>Status:</label>
            <select name="status">
                <option value="Pending" <?php echo $booking['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="In Progress" <?php echo $booking['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                <option value="Completed" <?php echo $booking['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
            </select>

            <button type="submit">Update Booking</button>
        </form>
    </div>
</body>
</html>
