<?php
session_start();
include '../includes/connection.php';

if (isset($_GET['b_id'])) {
    $publisherId = $_GET['b_id'];

    $sql = "DELETE FROM publisher WHERE publisher_id = '$publisherId'";
    if ($conn->query($sql)) {
        header("Location: /lms/admin/add_publisher.php"); 
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting publisher"; 
        header("Location: /lms/admin/add_publisher.php"); 
        exit();
    }
} 

$conn->close();
?>
