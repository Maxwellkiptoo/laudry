<?php
session_start();
require_once("conn.php");
require_once("headerhome.php");


if (!isset($_SESSION['email']) || !isset($_SESSION['phone'])) {
    echo "<script>alert('You must be logged in to view your dashboard.'); window.location.href='login.php';</script>";
    exit();
}

$user_email = $_SESSION['email'];
$user_phone = $_SESSION['phone'];


$sql = "SELECT * FROM bookings WHERE name = (SELECT name FROM users WHERE email = ?) AND phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_email, $user_phone);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User FreshFold Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
        .container { padding: 20px; }
    </style>
</head>
<body>
    <section class="container">
        <h2>Your Orders</h2>
        <?php if ($result->num_rows > 0) { ?>
            <table>
                <tr>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['service']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['place']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>
    </section>

    <br>
    
    <button><a href="home.php">Make Order</a></button>

</body>
</html>
