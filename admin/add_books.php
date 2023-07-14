<?php include_once 'header.php'; ?>
<style>
        .form-group {
            max-width: 400px;   
        
        }
        
</style>
<?php


?>
<div class="container">
                
        <h2>Add Books</h2>
        <form action="../includes/all_action.php" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
                
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="p_date">Publication Date</label>
                <input type="text" class="form-control" id="p_date" name="p_date" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control" id="quantity" name="quantity" required>
            </div>

            
            <button type="submit" name="add_books" class="btn btn-primary" style="margin-top: 20px;">Add</button>

        </form>
    </div>

<?php
include ('../includes/footer.php');

?>

