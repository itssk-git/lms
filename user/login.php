<?php
    include '../includes/header.php';
?>

<?php

if(isset($_SESSION['username'])){
    header('location: ../includes/index.php');
}

?>

<?php

if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];
} else {
    $errorMessage = ''; 
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
        .alert{
            background-color:white;
            border:none;
        }
        .mid {
      display: flex;
      justify-content: center;
      
      margin: 0;
    }

    h1 {
      margin-left: auto;
      margin-right: auto;
    }
    </style>
   
   
</head>
<body >
    <div class="container">
    
        
        <div class="alert alert-success" role="alert">
        <div class="mid">
        <h1>Login Form</h1>

        </div>
       
  <?php 
  if(isset($_SESSION['status'])){
  echo $_SESSION['status'];
  unset($_SESSION['status']); }?>
</div>
        <form action="../includes/all_action.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <p class="text-danger"><?php echo $errorMessage; ?></p>
            <button type="submit" name="login" class="btn btn-primary">Login</button><br><br>
            <button class="btn btn-success" ><a href="registration.php" style="color:white">Create an account</a></button>
            <span>Dont have an account?</span>


        </form>
    </div>
</body>
</html>

<?php
    include '../includes/footer.php';
?>