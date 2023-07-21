<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/527006ca5f.js" crossorigin="anonymous"></script>
    <style>
        body{
            font-family: "Roboto", sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            color:white;
        }

        
       
        nav{
            background-color: #1E3050;
        
        }
       ul li a{
        color:white;
       }
    </style>
</head>
<body >
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container">
                <a class="navbar-brand" href="#">Library Management System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Members</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Borrowings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Reservations</a>
                        </li>
                        <?php
                            session_start();

                                echo '<li class="nav-item">';

                                if (isset($_SESSION['username'])) {
                                    echo '<a class="nav-link" href="/lms/user/logout.php">Logout</a>';
                                    } 
                                    else {
                                        echo '<a class="nav-link" href="/lms/user/login.php">Login</a>';
                                            }       

                                    echo '</li>';
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
</html>
