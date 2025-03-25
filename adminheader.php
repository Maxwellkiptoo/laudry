<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Laundry Management</title>
    <link rel="stylesheet" href="styles.css">
  </head>
<body>
<header>
        <h1>Admin Panel - Laundry Management</h1>
        <nav>
            <ul>
                <li><a href="admin.php" class="<?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">Home</a></li>  
                <li><a href="booked.php" class="<?php echo ($current_page == 'booked.php') ? 'active' : ''; ?>">Manage Bookings</a></li>  
                <li><a href="Adm_Queries.php" class="<?php echo ($current_page == 'Adm_Queries.php') ? 'active' : ''; ?>">Received Queries</a></li>              
                <li><a href="logout.php">View as a User</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
    