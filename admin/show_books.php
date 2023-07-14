<?php
include '../includes/connection.php';
?>
<?php include_once 'header.php'; ?>

<?php
$select_books = "SELECT * FROM books";


$result = $conn->query($select_books);
if($result){


if ($result->num_rows > 0) {
    
    echo "<table class='table table-striped'>";
    echo "<tr>
            <th>Book Id</th>
            <th>Title</th>
            <th>Author</th>
            <th>Publication Date</th>
            <th>ISBN</th>
            <th>Quantity Available</th>
            <th>Category</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>";

    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['book_id']."</td>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['author']."</td>";
        echo "<td>".$row['publication_date']."</td>";
        echo "<td>".$row['ISBN']."</td>";
        echo "<td>".$row['quantity_available']."</td>";
        echo "<td>".$row['category']."</td>";
       
        echo "<td>
        <a href='add_books.php?b_id=".$row['book_id']."' class='btn btn-success'>Edit</a>
      </td>";
      echo "<td>
      <a href='delete_button.php?b_id=".$row['book_id']."' onclick=\"return confirm('Are you sure you want to delete this book?');\" class='btn btn-danger'>Delete</a>
  </td>";
        
        
        echo "</tr>";
    }

    
    echo "</table>";
} else {
    echo "No books found.";
}
}



?>



<?php
include ('../includes/footer.php');

?>
