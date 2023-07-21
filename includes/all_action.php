<?php
include 'connection.php';
?>
<?php
if(isset($_POST['register'])){
    session_start();
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

if($conn-> query($sql)){
    $_SESSION['status']='User Registered Sucessfully';
    header('Location: ../user/login.php');    

}
else{
    $_SESSION['status']='Register Failed';
    header('Location: ../user/login.php');    

}
   

    
    
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM members WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();

        session_start();
        $_SESSION['username'] = $result['username'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['user_type'] = $result['type'];

        header('Location: ../admin/dashboard.php');
        exit();
    } else {
        

        header('Location: ../user/login.php?error=Invalid credentials');
        exit();
    }

    $conn->close();
}











if (isset($_POST['add_books'])) {
    session_start();

    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $p_date = $_POST['p_date'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $photo = $_FILES['image']['tmp_name'];
    $photoContent = file_get_contents($photo);

    // Add database connection and error handling here if not already included

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO books (title, author, publication_date, ISBN, quantity_available, category, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $title, $author, $p_date, $isbn, $quantity, $category, $photoContent);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'Books Added Successfully';
        header('Location:../admin/show_books.php');
        exit();
    } else {
        $_SESSION['status'] = 'Adding Failed: ' . $conn->error;
        header('Location:../admin/show_books.php');
        exit();
    }
}



if(isset($_POST['update_user'])){
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
    

    if($conn-> query($sql)){
        $_SESSION['status']='Updated Sucessfully';
        header('Location:../admin/user_details.php');

    }
   

    
    
}



if (isset($_POST['update_books'])) {
    session_start();

    $bookId = $_SESSION['b_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $pub_date = $_POST['p_date'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $photo = $_FILES['image']['tmp_name'];
    $photoContent = file_get_contents($photo);

    
    if ($_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        
        $sql = "UPDATE books SET title=?, author=?, publication_date=?, ISBN=?, quantity_available=?, category=? WHERE book_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $title, $author, $pub_date, $isbn, $quantity, $category, $bookId);
    } else {
        
        $sql = "UPDATE books SET title=?, author=?, publication_date=?, ISBN=?, quantity_available=?, category=?, photo=? WHERE book_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $title, $author, $pub_date, $isbn, $quantity, $category, $photoContent, $bookId);
    }

    if ($stmt->execute()) {
        $_SESSION['status'] = 'Books Updated Successfully';
        header('Location:../admin/show_books.php');
        exit();
    } else {
        $_SESSION['status'] = 'Update Failed: ' . $conn->error;
        header('Location:../admin/show_books.php');
        exit();
    }
}


