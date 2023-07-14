<?php
include 'connection.php';
?>
<?php
if(isset($_POST['register'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $cpassword=$_POST['confirm_password'];
    $name=$_POST['name'];
    $address=$_POST['address'];
    $email=$_POST['email'];
    $number=$_POST['contact_number'];
    $joinDate = date('Y-m-d H:i:s');
    

    if($password!=$cpassword){
        die("Password did not match");
    }

    $sql = "INSERT INTO members (member_id,username, password, name, address, contact_number, email, join_date,type)
        VALUES ('','$username', '$password', '$name', '$address', '$number', '$email', '$joinDate','user')";

    if(!$conn-> query($sql)){
        echo"Not inserted";

    }
   

    header('Location: ../user/login.php');    
    
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM members WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $result=$result->fetch_assoc();
        

        session_start();
        $_SESSION['username']=$result['username'];
       
        $_SESSION['name']= $result['name'];
        $_SESSION['user_type']=$result['type'];
        
       
        header('Location: ../admin/dashboard.php');
        exit();
    } else {
        // Login failed
        echo "Invalid username or password";
    }
    
    // Close the database connection
    $conn->close();    
}



if(isset($_POST['add_books'])){
    $title=$_POST['title'];
    $author=$_POST['author'];
    $category=$_POST['category'];
    $p_date=$_POST['p_date'];
    $isbn=$_POST['isbn'];
    $quantity=$_POST['quantity'];
   
    

    

    $sql = "INSERT INTO books 
        VALUES ('','$title', '$author', '$p_date',   '$isbn', '$quantity','$category')";

    if(!$conn-> query($sql)){
        echo"Not inserted";

    }
   

    header('Location: ../admin/dashboard.php');    
    
}

if(isset($_POST['update'])){
    session_start();
    $userId = $_SESSION['id'] ;
    $username=$_POST['username'];
    $password=$_POST['password'];
    $cpassword=$_POST['confirm_password'];
    $name=$_POST['name'];
    $address=$_POST['address'];
    $email=$_POST['email'];
    $number=$_POST['contact_number'];
    $joinDate = date('Y-m-d H:i:s');
    
    

    if($password!=$cpassword){
        die("Password did not match");
    }

    $sql = "UPDATE members SET username = '$username', name = '$name', address = '$address', contact_number = '$number', email = '$email' WHERE member_id = $userId";
    

    if(!$conn-> query($sql)){
        echo"Not inserted";

    }
   

    
    
}
?>