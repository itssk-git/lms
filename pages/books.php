<?php
include ('../includes/header.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Cards</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color:#e6e5e7;
        }
        /* CSS to fix the image size and center it */
        .card .card-img-top {
            max-width: 200px; /* Set the maximum width for the image */
            max-height: 300px; /* Set the maximum height for the image */
            object-fit: cover; 
            margin: 0 auto; 
        }
        .card {
            background-color:#c1c1c1;
            height: 500px; /* Set the fixed height for the card */
            text-align: center; /* Center the card content vertically */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row" id="bookCards"></div>
    </div>

    <!-- Link to Bootstrap JS and jQuery (required for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
       $(document).ready(function() {
    // Fetch book data using AJAX
    $.ajax({
        url: 'fetch_books.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Populate cards with book data
            var bookCardsContainer = $('#bookCards');
            for (var i = 0; i < response.length; i++) {
                var book = response[i];
                var cardHtml = `
                    <div class="col-md-4 mb-4">
                        <div class="card d-flex flex-column"> <!-- Add d-flex and flex-column classes -->
                            <img src="${book.photo}" class="card-img-top" alt="Book Photo">
                            <div class="card-body">
                                <h5 class="card-title">${book.title}</h5>
                                <p class="card-text">${book.author}</p>
                                <p class="card-text">Genre: ${book.category}</p>
                            </div>
                            <div class="mt-auto"> <!-- Use mt-auto class to push buttons to the bottom -->
                                <button class="btn btn-primary mr-2">Request</button>
                                <button class="btn btn-success">Reserve</button>
                            </div>
                        </div>
                    </div>`;
                bookCardsContainer.append(cardHtml);

                // Check if three cards are added and wrap them in a new row
                if ((i + 1) % 3 === 0) {
                    bookCardsContainer.append('<div class="w-100"></div>');
                }
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});

    </script>
</body>
</html>
<?php
include ('../includes/footer.php');

?>
