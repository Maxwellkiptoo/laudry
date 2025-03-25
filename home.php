<?php
session_start();
require_once("conn.php");
require_once("headerhome.php");

if (!isset($_SESSION['email']) || !isset($_SESSION['phone'])) {
    echo "<script>alert('You must be logged in to submit a complaint.'); window.location.href='login.php';</script>";
    exit();
}

$id = $_SESSION['id'];
$sqlUser = "SELECT * FROM users WHERE id = $id";
$resultUser = $conn->query($sqlUser);
$user = $resultUser->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $place = $_POST['place'];
    $status = 'Pending';

   $checkBookingSql = "SELECT * FROM bookings WHERE service = '$service' AND name = '$name' AND date = '$date'";
    $resultCheck = $conn->query($checkBookingSql);

    if ($resultCheck->num_rows > 0) {
     echo "<script>alert('You already have a booking for this service on this date. Please choose a different date or service.'); window.location.href='home.php';</script>";
    } else {
           $sql = "INSERT INTO bookings (service, price, date, name, phone, place, status) 
                VALUES ('$service', '$price', '$date', '$name', '$phone', '$place', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Booking confirmed! Thank you for using our service.'); window.location.href='home.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Laundry Service</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="adminstyle.css">

    <script>
        function deposit(service, price) {
            document.getElementById('booking-form').style.display = 'block';
            document.getElementById('selected-service').value = service;
            document.getElementById('selected-price').value = price;
        }
    </script>
</head>
<body>
    <section id="services">
        <h2>Our Services</h2>
        <table>
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>Wash & Fold</td>
                <td>250 per kg</td>
                <td><button onclick="deposit('Wash & Fold', '250 per kg')">Book</button></td>
            </tr>
            <tr>
                <td>Dry Cleaning</td>
                <td>500 per kg</td>
                <td><button onclick="deposit('Dry Cleaning', '500 per kg')">Book</button></td>
            </tr>
            <tr>
                <td>Ironing</td>
                <td>100 per kg</td>
                <td><button onclick="deposit('Ironing', '100 per kg')">Book</button></td>
            </tr>
            <tr>
                <td>Stain Removal</td>
                <td>200 per item</td>
                <td><button onclick="deposit('Stain Removal', '200 per item')">Book</button></td>
            </tr>
            <tr>
                <td>Carpet Cleaning</td>
                <td>500 per carpet</td>
                <td><button onclick="deposit('Carpet Cleaning', '500 per carpet')">Book</button></td>
            </tr>
        </table>
    </section>

    <section id="booking-form" style="display:none;">
        <h2>Book a Service</h2>
        <form method="POST">
            <label>Service</label>
            <input type="text" id="selected-service" name="service" readonly required>

            <label>Price</label>
            <input type="text" id="selected-price" name="price" readonly required>

            <label>Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" readonly required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly required>

            <label>Pickup Date</label>
            <input type="date" name="date" required>

            <label>Pickup Location</label>
            <select name="place" required>
                <option value="Kijiji">Kijiji</option>
                <option value="Chapel">Chapel</option>
                <option value="Library">Library</option>
                <option value="Hostel">Hostel</option>
                <option value="Odel">Odel</option>
            </select>

            <button type="submit">Confirm Booking</button>
            <button type="button" onclick="document.getElementById('booking-form').style.display='none'">Cancel</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Laundry Management System. All rights reserved.</p>
    </footer>
</body>
</html>
