

<?php
include ('../includes/header.php');

?>
<?php



// Check if session is not set or user_id is not 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
  // Redirect to login.php
  header("Location: /lms/user/login.php");
  exit; // Make sure to add 'exit' after header() to stop further execution
} 



?>

<?php
    
    // Check if there is a session message
    if (isset($_SESSION['message1'])) {
        // Display the message with the class for green color
        echo '<p class="success-message">' . $_SESSION['message1'] . '<p>';

        // Unset the session message to avoid displaying it again on future visits
        unset($_SESSION['message1']);
    }
    ?>
    <?php
    
    if (isset($_SESSION['message2'])) {
        echo '<p class="error-message">' . $_SESSION['message2'] . '<p>';

        unset($_SESSION['message2']);
    }
    ?>
    <head>
        <link rel="stylesheet" href="book_cards.css">
    </head>

 

    <div class="container mt-5" >

<h1 >Books For you</h1>
        
        <?php
       
        require_once '../includes/connection.php';
        
        $sql = "SELECT b.*, c.name AS category_name, p.name AS publisher_name
        FROM books AS b
      JOIN category AS c ON b.category_id = c.category_id
         JOIN publisher AS p ON b.publisher_id = p.publisher_id WHERE quantity_available>0
         ORDER BY b.book_id LIMIT 4";
        $books = $conn->query($sql);

        echo'<div class="row" id="bookCards">';
        


        foreach ($books as $book) {
            $base64Image = base64_encode($book['photo']);
           
        
            echo '<section id="book1" class="section-p1">';
            echo '<div class="book-container">';
            echo '<a href="book_details.php?book_id=' . $book['book_id'] . '">';
            echo '<div class="book">';
            echo '<img src="data:image/jpeg;base64,' . $base64Image . '" alt="Book Photo">';
            echo '<div class="des">';
            echo '<span>' . $book['title'] . '</span>';
            echo '<h5>' . $book['author'] . '</h5>';
            echo '<h5 class="card-text">Genre: ' . $book['category_name'] . '</h5>';
            echo '</div>';
           
            echo '</a>';
            echo '</div>';
            echo '</div>';
            echo '</section>';
          
        }
          echo' </div>';
          
        ?>
        </div>
        
<?php
include ('../includes/footer.php');

?>