<?php
require_once("conn.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];    
    $place = $_POST['place'];
    $status = 'Pending';
    
    $sql = "INSERT INTO bookings (service, price, date, name, phone, place, status) 
        VALUES ('$service', '$price', '$date', '$name', '$phone', '$place', '$status') 
        ON DUPLICATE KEY UPDATE status='Pending'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking confirmed! Thank you for using our service.'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshFold </title>    
    <link rel="stylesheet" href="styles.css">
       <script>
            function deposit(service, price) {
                document.getElementById('booking-form').style.display = 'block';
                document.getElementById('selected-service').value = service;
                document.getElementById('selected-price').value = price;
            }
            function confirmBooking(event) {
                event.preventDefault();
                let phone = document.getElementById('phone').value;
                if (phone.length < 10 || phone.length > 13) {
                    alert('Phone number must be between 10 and 13 digits.');
                    return;
                }
                let bookingData = {
                    service: document.getElementById('selected-service').value,
                    price: document.getElementById('selected-price').value,
                    date: document.getElementById('date').value,
                    place: document.getElementById('place').value,
                    name: document.getElementById('name').value,
                    phone: document.getElementById('phone').value
                };
                document.getElementById('popup-service').innerText = bookingData.service;
                document.getElementById('popup-price').innerText = bookingData.price;
                document.getElementById('popup-date').innerText = bookingData.date;
                document.getElementById('popup-place').innerText = bookingData.place;
                document.getElementById('popup-name').innerText = bookingData.name;
                document.getElementById('popup-phone').innerText = bookingData.phone;
                document.getElementById('booking-popup').style.display = 'block';
            }
            function closePopup() {
                alert('Thank you for your booking!');
                document.getElementById('booking-popup').style.display = 'none';
                window.location.reload();
            }
        </script>
</head>
<body>
    <header>
        <h1>Laundry Management System</h1>
        <nav>
            <ul>
                <li><a href="#services">Services</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    
    <section id="hero">
        <div class="slider">
            <div class="slide"><img src="https://daganghalal.blob.core.windows.net/41409/Product/1000x1000__drycleaning-1663660845351.png" alt="Laundry Service 1"></div><br>
            <div class="slide"><img src="https://th.bing.com/th/id/R.fac16a0c4f7f16b319e0bf5285e1d7ec?rik=1IQ8tHZDRgWTLw&pid=ImgRaw&r=0" alt="Laundry Service 2"></div><br>
            <div class="slide"><img src="https://www.iamexpat.nl/sites/default/files/styles/default/public/dry-cleaning-ironing-laundry-delivery-services-netherlands_0.jpg?itok=CsWHDGKC" alt="Laundry Service 3"></div><br>
            <div class="slide"><img src="https://th.bing.com/th/id/OIP.-42Z6pXbeVmIMjTQfOU_bAHaE8?rs=1&pid=ImgDetMain" alt="Laundry Service 3"></div><br>
            <div class="slide"><img src="https://th.bing.com/th/id/OIP.O6Ry3ibLQYmtGfaPpE9zlgHaE8?rs=1&pid=ImgDetMain" alt="Laundry Service 3"></div><br>
            <div class="slide"><img src="https://daganghalal.blob.core.windows.net/41409/Product/1000x1000__drycleaning-1663660845351.png" alt="Laundry Service 1"></div><br>
        </div>
    </section>
    
    <section id="services">
        <h2>Our Services</h2>
        <div class="service-box">
            <img src="https://th.bing.com/th/id/OIP.O6Ry3ibLQYmtGfaPpE9zlgHaE8?rs=1&pid=ImgDetMain" alt="Wash & Fold">
            <h3>Wash & Fold</h3>
            <p>Professional washing and folding at an affordable price.</p>
        </div>
        <div class="service-box">
            <img src="https://th.bing.com/th/id/OIP.cfCpqfdHlCeiz1S29mDu5AHaE8?rs=1&pid=ImgDetMain" alt="Stain Removal">
            <h3>Stain Removal</h3>
            <p>Effective stain removal treatment to restore your garments.</p>
        </div>
        <div class="service-box">
            <img src="https://th.bing.com/th/id/OIP.20BYmufBumKRKbsZeQWVJAHaEi?rs=1&pid=ImgDetMain" alt="Dry Cleaning">
            <h3>Dry Cleaning</h3>
            <p>Premium dry cleaning to keep your clothes fresh and crisp.</p>
        </div>
           
        <div class="service-box">
            <img src="https://th.bing.com/th/id/OIP.20BYmufBumKRKbsZeQWVJAHaEi?rs=1&pid=ImgDetMain" alt="Dry Cleaning">
            <h3>Carpet Cleaning</h3>
            <p>Deep cleaning for carpets to remove dirt and allergens.</p>
        </div>
        <div class="service-box">
            <img src="https://th.bing.com/th/id/OIP.nPhSsMTY-6NwpyVQaiDlPgAAAA?rs=1&pid=ImgDetMain" alt="Ironing">
            <h3>Ironing</h3>
            <p>Expert ironing services to keep your clothes wrinkle-free and fresh.</p>
        </div>
    </section>
      
    <section id="pricing">
        <h2>Pricing</h2>
        <table>
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>Wash & Fold</td>
                <td>250 per kg</td>
                <td><button class="deposit-btn" onclick="deposit('Wash & Fold', '250 per kg')">Book</button></td>
            </tr>
            <tr>
                <td>Dry Cleaning</td>
                <td>500 per kg</td>
                <td><button class="deposit-btn" onclick="deposit('Dry Cleaning', '500 per kg')">Book</button></td>
            </tr>
            <tr>
                <td>Ironing</td>
                <td>100 per kg</td>
                <td><button class="deposit-btn" onclick="deposit('Ironing', '100 per kg')">Book</button></td>
            </tr>
            <tr>
                <td>Stain Removal</td>
                <td>200 per item</td>
                <td><button class="deposit-btn" onclick="deposit('Stain Removal', '200 per item')">Book</button></td>
            </tr>
            <tr>
                <td>Carpet Cleaning</td>
                <td>500 per carpet</td>
                <td><button class="deposit-btn" onclick="deposit('Carpet Cleaning', '500 per carpet')">Book</button></td>
            </tr>
        </table>
    </section>
    
  c
   
    <section id="booking-popup">
        <h2>Booking Details</h2>
        <p><strong>Service:</strong> <span id="popup-service"></span></p>
        <p><strong>Price:</strong> <span id="popup-price"></span></p>
        <p><strong>Name:</strong> <span id="popup-name"></span></p>
        <p><strong>Phone:</strong> <span id="popup-phone"></span></p>        
        <p><strong>Pickup Date:</strong> <span id="popup-date"></span></p>        
        <p><strong>Location:</strong> <span id="popup-place"></span></p>
        <button class="close-btn" onclick="closePopup()">Close</button>
        
    </section>
  
     <section id="contact">
        <h2>Contact Us</h2>
        <p>Email: support@laundryms.com</p>
        <p>Phone: +254 074567890</p>
    </section>
    
    <footer>
        <p>&copy; 2025 Laundry Management System. All rights reserved.</p>
    </footer>
</body>
</html>
