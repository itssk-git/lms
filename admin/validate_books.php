<?php
// Assuming you have a database connection established
include '../includes/connection.php';


if(isset($_POST['title'])) {
    $title = $_POST['title'];
    
    // Assuming $conn is your database connection
    
    $query = "SELECT * FROM books WHERE LOWER(title) = LOWER('$title')";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        echo "";
    }

    mysqli_close($conn);
}
?>






