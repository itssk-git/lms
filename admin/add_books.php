<?php include_once 'header.php'; ?>
<?php
include '../includes/connection.php';
?>
<head>
    <script src="validate.js"></script>
</head>

<style>
        <style>
   .login-form {
    display: flex;
    flex-direction: column;
}
.login-form label {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
}
.login-form input {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
}
.login-form button {
    padding: 10px;
    margin: -15px 5px 5px 5px;
    font-size: 18px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.login-form button:hover {
    background-color: #45a049;
}

.main-body {
    margin: 0;
    padding: 10px 0 10% 0;
    display: flex;
    justify-content: center;
    height: 160vh;
    background-color: #F2EEE3;
}

.login-form a button {
    padding: 10px;
    margin:5px;
    font-size: 18px;
    background-color: #088178;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width:96%;
}
.login-form a button:hover {
    background-color: hsl(180, 70%, 35%);
}
.login-container {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    width: 50%;
    margin-top: 2%;
    height:153vh;
    
}
.btn{
    width:25%;
}
.error-text{
    color:red;
}
#submit[disabled] {
    background-color: gray;
    color: white; 
    cursor: not-allowed;
   
}
</style>
<?php
if (isset($_GET['b_id'])) {
    $bookId = $_GET['b_id'];

    $query = "SELECT * FROM books WHERE book_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $title = $row['title'];
        $author = $row['author'];
       
        $isbn = $row['ISBN'];
        $quantity = $row['quantity_available'];
        $category_id = $row['category_id'];
        $publisher_id = $row['publisher_id'];
        $description = $row['description'];
        $photo = $row['photo'];

      
        
    } else {
        echo "Book not found.";
    }

    $stmt->close();
} 
?>


<div class="main-body">
    <div class="login-container">          
        <h2>Add Books</h2>
        <form class="login-form" action="../includes/all_action.php" method="POST" enctype="multipart/form-data" onsubmit="return validation()">
            <div class="form-group">
                <label for="title">Title</label>
                <span id="title-error" class="error-text"></span>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($title) ? $title : ''; ?>" required>
            </div>
            <div class="form-group">
    <input type="hidden" name="b_id" value="<?php echo isset($bookId) ? $bookId : ''; ?>">
</div>
            <div class="form-group">
                <label for="author">Author</label>
                <span id="author_error" class="error-text"></span>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo isset($author) ? $author : ''; ?>" required>
                
            </div>
            <div class="form-group">
    <label for="category">Category</label>
    <span id="category_error" class="error-text"></span>
    <select class="form-control" id="category" name="category" required>
        <option value="" >Select a Category</option>
        <?php
        $categoryQuery = "SELECT * FROM Category";
        $categoryResult = $conn->query($categoryQuery);

        while ($categoryRow = $categoryResult->fetch_assoc()) {
            $categoryId = $categoryRow['category_id'];
            $categoryName = $categoryRow['name'];
            $selected = ($category_id == $categoryId) ? 'selected' : '';
            echo '<option value="' . $categoryId . '" ' . $selected . '>' . $categoryName . '</option>';
        }
        ?>
    </select>
</div>






<!-- Publisher Selection -->
<div class="form-group">
    <label for="publisher">Publisher</label>
    <span id="publisher_error" class="error-text"></span>
    <select class="form-control" id="publisher" name="publisher" required>
        <option value="" >Select a Publisher</option>
        <?php
        $publisherQuery = "SELECT * FROM Publisher";
        $publisherResult = $conn->query($publisherQuery);

        while ($publisherRow = $publisherResult->fetch_assoc()) {
            $publisherId = $publisherRow['publisher_id'];
            $publisherName = $publisherRow['name'];
            $selected = ($publisher_id == $publisherId) ? 'selected' : '';
            echo '<option value="' . $publisherId . '" ' . $selected . '>' . $publisherName . '</option>';
        }
        ?>
    </select>
</div>



           
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <span id="isbn_error" class="error-text"></span>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo isset($isbn) ? $isbn : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <span id="quantity_error" class="error-text"></span>

                <input type="text" class="form-control" id="quantity" name="quantity" value="<?php echo isset($quantity) ? $quantity : ''; ?>" required>
            </div>

<div class="form-group">


    <label for="description">Description:</label>
    <span id="desc_error" class="error-text"></span>
    <textarea name="description" class="form-control" id="description" rows="5" cols="50" placeholder="Give Description"><?php echo isset($description) ? $description : ''; ?></textarea>
</div>

<div class="form-group">
    <label for="image">Image</label>
    <span id="image_error" class="error-text"></span> 
    <div id="imagePreviewContainer">
        <?php if (isset($photo) && !empty($photo)) { ?>
            <img id="imagePreview" src="data:image/jpeg;base64,<?php echo base64_encode($photo); ?>" alt="Existing Image" width="100">
        <?php } else { ?>
            <div id="imagePreview" style="display: none;"></div>
        <?php } ?>
    </div>
   
</div>


<script>
    function updateImagePreview() {
        var imageInput = document.getElementById('image');
        var imagePreview = document.getElementById('imagePreview');
        var imagePreviewContainer = document.getElementById('imagePreviewContainer');
        var file = imageInput.files[0];

        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    }
</script>


            <?php
            if(isset($bookId)){
                echo '<button id="submit" type="submit" name="update_books" style="margin-top: 20px;" class="btn">Update</button>';
            }

            else{
                echo '<button id="submit" type="submit" name="add_books" style="margin-top: 20px;" class="btn"> Add </button>';
            }
            ?>

            

       
    </div>
    </form>
        </div>
        </div>

<?php
include ('../includes/footer.php');

?>




<script>

   



    $(document).ready(function() {
    $('#title').on('blur', function() {
        var title = $(this).val();
        $.ajax({
            type: "POST",
            url: "validate_books.php",
            data: { title: title },
            success: function(response) {
                $('#title-error').text(response);
            }
        });
    });
});



//For author
$(document).ready(function() {
    $('#author').on('keyup', function() {
        
        var author = $(this).val();
        var pattern1 = /^[a-zA-Z\s]+$/;

        if (!pattern1.test(author)) {
            $('#author_error').text('Author can only contain letters');
          
        } else {
            $('#author_error').text('');
            
        }
    });
});

//Category
$(document).ready(function() {
    $('#category').on('change', function() {
        validateCategory();
    });


    validateCategory();

    function validateCategory() {
        var selectedCategory = $('#category').val();
        var $errorMessage = $('#category_error');

        if (selectedCategory === '') {
            $errorMessage.text('*');
      
        } else {
            $errorMessage.text('');
            
        }
    }
});



$(document).ready(function() {
    $('#publisher').on('change', function() {
        validatePublisher();
    });


    validatePublisher();

    function validatePublisher() {
        var selectedPublisher = $('#publisher').val();
        var $errorMessage = $('#publisher_error');

        if (selectedPublisher === '') {
            $errorMessage.text('*');
       
        } else {
            $errorMessage.text('');
           
        }
    }
});


//Date
$(document).ready(function() {
    $('#p_date').on('change', function() {
        var enteredDate = new Date($(this).val());
        var currentDate = new Date();
        var $errorMessage = $('#date_error');

        if (isNaN(enteredDate)) {
            $errorMessage.text('Invalid date format');
          
        } else if (enteredDate >= currentDate) {
            $errorMessage.text('exceeds current date');
           
        } else {
            $errorMessage.text('');
            
        }
    });
});


//ISBN


$('#isbn').on('input', function() {
        var isbn = $(this).val();
        var pattern = /^[0-9\-]*$/;
        var $errorMessage = $('#isbn_error');

        if (!pattern.test(isbn)) {
            $errorMessage.text('Please use only numbers and hyphens');
      
        } else {
            $errorMessage.text('');

           
        }
    });


//Quantity
$(document).ready(function() {
    $('#quantity').on('input', function() {
        var quantity = $(this).val();
        var pattern = /^[0-9]*$/;
        var $errorMessage = $('#quantity_error');

        if (!pattern.test(quantity)) {
            $errorMessage.text('Please use only numbers');
            
        } else {
            $errorMessage.text('');
     
        }
    });
});
//desc

$(document).ready(function() {
    $('#description').on('blur', function() {
        var description = $(this).val(); 
        var $errorMessage = $('#desc_error');

        if (description === '') {
            $errorMessage.text('Description cannot be empty');
           
        } else {
            $errorMessage.text('');
           
        }
    });
});













</script>



