<?php
require_once("conn.php");
require_once("adminheader.php");


$sqlAdmins = "SELECT * FROM admins";
$resultAdmins = $conn->query($sqlAdmins);
$admins = $resultAdmins->fetch_all(MYSQLI_ASSOC);

$sqlUsers = "SELECT * FROM users";
$resultUsers = $conn->query($sqlUsers);
$users = $resultUsers->fetch_all(MYSQLI_ASSOC);

$sqlbookings = "SELECT * FROM bookings";
$resultbookings = $conn->query($sqlbookings);
$bookings = $resultbookings->fetch_all(MYSQLI_ASSOC);

$sqlComplaints = "SELECT * FROM complaints";
$resultComplaints = $conn->query($sqlComplaints);
$complaints = $resultComplaints->fetch_all(MYSQLI_ASSOC);

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
        <h2>Dashboard Overview</h2>
        <div class="stats">
            <div>
                <h3>Active Users</h3>
                <p><?php echo count($users); ?></p>
            </div>
            <div>
                <h3>Admins</h3>
                <p><?php echo count($admins); ?></p>
            </div>
            <div>
                <h3>Booked</h3>
                <p><?php echo count($bookings); ?></p>
            </div>
            <div>
                <h3>Complaints</h3>
                <p><?php echo count($complaints); ?></p>
            </div>
        </div>

        <h2>Admins Registered</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php if (!empty($admins)): ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['name']); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td>
                            <a href="update_admin.php?id=<?php echo $admin['id']; ?>" class="btn">Update</a>
                            <button class="btn" onclick="deleteAdmin(<?php echo $admin['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No admins found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <h2>Users Registered</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td>
                            <a href="update_user.php?id=<?php echo $user['id']; ?>" class="btn">Update</a>
                            <button class="btn" onclick="deleteuser(<?php echo $user['id']; ?>)">Delete</button>
                       </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
