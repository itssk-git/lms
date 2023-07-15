<?php
include '../includes/connection.php';

if (!empty($_POST['user_name'])) {
    $username = $_POST['user_name'];

    $query = "SELECT * FROM members WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo 'taken';
    } else {
        echo 'available';
    }
}
?>