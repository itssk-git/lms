<?php
session_start();
include '../includes/connection.php';

if (isset($_GET['b_id'])) {
    $categoryId = $_GET['b_id'];

    $sql = "DELETE FROM category WHERE category_id = '$categoryId'";
    if ($conn->query($sql)) {
        $_SESSION['success_message'] = "Category deleted successfully";
        header("Location: /lms/admin/add_category.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error deleting category ";
        header("Location: /lms/admin/add_category.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Category ID not provided";
    header("Location: /lms/admin/add_category.php");
    exit();
}

$conn->close();
?>
