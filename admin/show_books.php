<?php
include '../includes/connection.php';
?>
<?php include_once 'header.php'; ?>


<style>
   
    a[href="show_books.php"] {
      display: inline-block;
      padding: 10px 20px;
      background-color: #1e3050;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.2s ease-in-out;
    }

    a[href="show_books.php"]:hover {
      background-color: #218838; 
    }
  </style>
<div class="alert alert-success d-flex justify-content-between" role="alert">
  <a href="show_books.php">All Books</a>
  <?php 
  if(isset($_SESSION['status'])){
    echo $_SESSION['status'];
    unset($_SESSION['status']);
  }

  if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
  }
  ?>
  <form class="d-flex" action="" method="GET">
    <input type="text" name="search_book" id="" placeholder="Search Books">
    <button class="btn btn-success" name="search_btn">Search</button>
  </form>
</div>


<?php
if (isset($_GET['search_btn'])) {
  $book = $_GET['search_book'];

  $sql = "SELECT * FROM books WHERE title LIKE '%$book%'";
  $result = $conn->query($sql);
}
else{
$select_books = "SELECT * FROM books";


$result = $conn->query($select_books);
}
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
