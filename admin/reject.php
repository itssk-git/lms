<?php
include '../includes/connection.php';

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    $sql_update = "UPDATE borrowing SET status = 'rejected' WHERE borrowing_id = $request_id";

    if ($conn->query($sql_update) === TRUE) {
        header('location:requested_book.php');
    } else {
        echo "Error updating request status: " . $conn->error;
    }
}
?>
