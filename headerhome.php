<?php
require_once("conn.php");

$user_email = $_SESSION['email'] ?? "Guest";
$user_phone = $_SESSION['phone'] ?? "N/A";
$user_name = $_SESSION['name'] ?? "Guest";
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <div class="user-info">
        <p><strong>Welcome, <?php echo htmlspecialchars($user_name); ?></strong></p>
        <p>Email: <?php echo htmlspecialchars($user_email); ?></p>
        <p>Phone: <?php echo htmlspecialchars($user_phone); ?></p>
    </div>

    <h1>Laundry Management System</h1>
    <nav>
        <ul>
           <li><a href="home.php" class="<?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">Dashboard</a></li>
           <li><a href="orders.php" class="<?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>">My Orders</a></li>
            <li><a href="Queries.php" class="<?php echo ($current_page == 'Queries.php') ? 'active' : ''; ?>">Complaints</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

</header>

</body>
</html>
