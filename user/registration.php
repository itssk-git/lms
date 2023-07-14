<?php
    include '../includes/header.php';
?>
<?php
include '../includes/connection.php';
?>

<?php
$query = "SELECT * FROM members WHERE member_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET['m_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();


if (isset($_GET['m_id'])) {
    
    $userId = $_GET['m_id'];
   
    $_SESSION['id'] = $userId; 

    
    $username = $row['username'];
    $password = $row['password'];
    $name = $row['name'];
    $address = $row['address'];
    $contact = $row['contact_number'];
    $email = $row['email'];
    $join_date = $row['join_date'];
    $type = $row['type'];
    
    $buttonLabel = 'Update';
    $formAction = 'all_action.php?id=' . $userId;
} 


}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    
    <style>
        .form-group {
            max-width: 400px;   
        
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <form action="../includes/all_action.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" value="<?php echo isset($username) ? $username : ''; ?>" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" value="<?php echo isset($password) ? $password : ''; ?>"name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" value="<?php echo isset($password) ? $password : ''; ?>" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" value="<?php echo isset($name) ? $name : ''; ?>" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" value="<?php echo isset($address) ? $address : ''; ?>"name="address" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" value="<?php echo isset($contact) ? $contact : ''; ?>"name="contact_number" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"required maxlength="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">

            </div>
            <?php
            if(isset($userId)){
                echo '<button type="submit" name="update" class="btn btn-primary">' . $buttonLabel . '</button>';
            }

            else{
                echo '<button type="submit" name="register" class="btn btn-primary"> Register </button>';



            }
            ?>
            
        </form>
    </div>
</body>
</html>
<?php
    include '../includes/footer.php';
?>
