<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Include your custom CSS files if any -->
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />  
  <style>
    /* Custom CSS for the dashboard header */
    body{
      font-family: "Roboto", sans-serif;    }

    .dashboard-header {
      background-color: #1E3050;
      color: #fff;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .dashboard-header .navbar-brand {
      font-size: 20px;
      font-weight: bold;
    }
    
    .dashboard-header .welcome-message {
      font-size: 16px;
      margin-right: 70px;
    }
    
    .dashboard-header .logout-button {
      color: #fff;
      text-decoration: none;
      border: none;
      background: none;
      cursor: pointer;
    }
    
    .dashboard-header .logout-button:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body >
  <div class="dashboard-header">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="welcome-message">
      <?php
        session_start();
        
        // Check if the session variables are set and have the desired values
        if (isset($_SESSION['username']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] === "admin") {
          $userName = $_SESSION['name'];
        
          // Display the welcome message with the username
          echo "Welcome, " . $userName;
        }
      ?>
    </div>
    <button class="logout-button" onclick="location.href='../user/logout.php'">Logout</button>
  </div>

</body>
</html>
