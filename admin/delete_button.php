
<?php
include '../includes/connection.php';
?>

<?php
$m_id = $_GET['m_id']; 

$sql = "DELETE FROM members WHERE member_id = '$m_id'";
if($conn->query($sql)){
    header('location:user_details.php');
}

?>

<?php
$b_id = $_GET['b_id']; 

$sql = "DELETE FROM books WHERE book_id = '$b_id'";
if($conn->query($sql)){
    header('location:show_books.php');
}

?>