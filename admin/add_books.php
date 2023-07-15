<?php include_once 'header.php'; ?>
<?php
include '../includes/connection.php';
?>
<style>
        .form-group {
            max-width: 400px;   
        
        }
        
</style>
<?php
$query = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET['b_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();


if (isset($_GET['b_id'])) {
    
    $bookId = $_GET['b_id'];
   
    $_SESSION['b_id'] = $bookId; 

    
    $bookId = $row['book_id'];
    $title = $row['title'];
    $author = $row['author'];
    $pub_date = $row['publication_date'];
    $isbn = $row['ISBN'];
    $quantity = $row['quantity_available'];
    $category = $row['category'];
  
    
    $buttonLabel = 'Update';
    $formAction = 'all_action.php?id=' . $bookId;
} 

}
?>
<div class="container">            
        <h2>Add Books</h2>
        <form action="../includes/all_action.php" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($title) ? $title : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo isset($author) ? $author : ''; ?>" required>
                
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo isset($category) ? $category : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="p_date">Publication Date</label>
                <input type="text" class="form-control" id="p_date" name="p_date" value="<?php echo isset($pub_date) ? $pub_date : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo isset($isbn) ? $isbn : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo isset($quantity) ? $quantity : ''; ?>" required>
            </div>
            <?php
            if(isset($bookId)){
                echo '<button type="submit" name="update_books" style="margin-top: 20px;" class="btn btn-primary">' . $buttonLabel . '</button>';
            }

            else{
                echo '<button type="submit" name="add_books" style="margin-top: 20px;" class="btn btn-primary"> Add </button>';
            }
            ?>

            

        </form>
    </div>

<?php
include ('../includes/footer.php');

?>

