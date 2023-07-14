<?php
    include '../includes/header.php';
?>

<?php

if(isset($_SESSION['username'])){
    header('location: ../includes/index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
   
   
</head>
<body >
    <div class="container">
        <h2>Login Form</h2>
        <form action="../includes/all_action.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
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