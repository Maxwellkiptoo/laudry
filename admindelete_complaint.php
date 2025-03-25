<?php
session_start();
require_once("conn.php");

if (!isset($_SESSION['email']) || !isset($_SESSION['phone'])) {
    echo "<script>alert('You must be logged in to delete a complaint.'); window.location.href='login.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $complaint_id = $_GET['id'];
    $email = $_SESSION['email'];

    $sql = "SELECT * FROM complaints WHERE id = '$complaint_id' AND email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
         $delete_sql = "DELETE FROM complaints WHERE id = '$complaint_id'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "<script>alert('Complaint deleted successfully.'); window.location.href='Adm_Queries.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
         echo "<script>alert('You can only delete a selected complaints.'); window.location.href='Adm_Queries.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='Adm_Queries.php';</script>";
}

$conn->close();
?>
