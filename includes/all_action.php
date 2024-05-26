<?php
include 'connection.php';
?>
<?php




if (isset($_POST['register'])) {
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $number = $_POST['contact_number'];
    $joinDate = date('Y-m-d H:i:s');

    $errors = array();

    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 6) {
        $errors['username'] = 'Username must be at least 6 characters long';
    } else {
        $query = "SELECT * FROM members WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors['username'] = 'Username already exists';
        }
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $errors['password'] = 'Password must be between 8 and 20 characters long';
    }

    if (empty($cpassword)) {
        $errors['confirm_password'] = 'Confirm Password is required';
    } elseif ($password !== $cpassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (empty($name)) {
        $errors['name'] = 'Name is required';
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors['name'] = 'Name can only contain letters and spaces';
    }
    
    if (empty($address)) {
        $errors['address'] = 'Address is required';
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $address)) {
        $errors['address'] = 'Address can only contain letters and spaces';
    }
    

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    } else {
        $query = "SELECT * FROM members WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors['email'] = 'Email already exists';
        }
    }

    if (empty($number)) {
        $errors['contact_number'] = 'Contact Number is required';
    } elseif (!preg_match("/^9[0-9]{9}$/", $number)) {
        $errors['contact_number'] = 'Contact Number must start with "9" and be 10 digits in total';
    } else {
        $query = "SELECT * FROM members WHERE contact_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $number);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors['contact_number'] = 'Contact Number already exists';
        }
    }

    if (!empty($errors)) {
        $_SESSION['registration_errors'] = $errors;
        header('Location: ../user/registration.php');
        exit();
    } else {
        $sql = "INSERT INTO members (username, password, name, address, contact_number, email, join_date, type, approved)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'user', '')";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $_SESSION['status'] = 'Register Failed';
            header('Location: ../user/login.php');
            exit();
        }

       

        $stmt->bind_param("sssssss", $username, $password, $name, $address, $number, $email, $joinDate);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'User Registration Successful! Your registration is pending approval by an admin.';
            header('Location: ../user/login.php');
            exit();
        } else {
            $_SESSION['status'] = 'Register Failed';
            header('Location: ../user/login.php');
            exit();
        }
    }
}



if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; 

    if ($user_type === 'admin') {
       
        $admin_sql = "SELECT * FROM admin WHERE username = '$username' AND BINARY password = '$password'";
        $admin_result = $conn->query($admin_sql);

        if ($admin_result->num_rows > 0) {
            $result = $admin_result->fetch_assoc();
            
            session_start();
            $_SESSION['admin_id'] = $result['admin_id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['admin_name'] = $result['name'];
            $_SESSION['user_type'] = 'admin';

            header('Location: ../admin/dashboard.php'); 
            exit();
        }
    } elseif ($user_type === 'member') {
        $members_sql = "SELECT * FROM members WHERE username = '$username' AND BINARY password = '$password' AND approved = 1";
        $members_result = $conn->query($members_sql);

        if ($members_result->num_rows > 0) {
            $result = $members_result->fetch_assoc();
            
            session_start();
            $_SESSION['username'] = $result['username'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['user_id'] = $result['member_id'];
            $_SESSION['user_type'] = 'user';

            header('Location: ../pages/books.php'); 
            exit();
        }
    }

    if ($user_type == "admin") {
        header('Location: ../user/admin_login.php?error=Invalid credentials');
    } 
    if ($user_type == "member") {
        header('Location: ../user/login.php?error=Invalid credentials');
    } 
    
    exit();
    
    $conn->close();
}



if (isset($_POST['add_books'])) {
    session_start();
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $publisher = $_POST['publisher'];


   
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $photo = $_FILES['image']['tmp_name'];
    $photoContent = file_get_contents($photo);

    $errors = array();

    if (empty($title)) {
        $errors['title'] = 'Title is required';
    } else {
        $query = "SELECT * FROM books WHERE title = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['title'] = 'Title already exists';
        }
    }

    if (empty($author)) {
        $errors['author'] = 'Author is required';
    } else {
        $pattern1 = '/^[a-zA-Z\s]+$/';
        if (!preg_match($pattern1, $author)) {
            $errors['author'] = 'Author can only contain letters';
        }
    }

    if (empty($category)) {
        $errors['category'] = 'Category is required';
    }

    if (empty($publisher)) {
        $errors['publisher'] = 'Publisher is required';
    }

    
    

    if (empty($isbn)) {
        $errors['isbn'] = 'ISBN is required';
    } elseif (!preg_match("/^[0-9\-]*$/", $isbn)) {
        $errors['isbn'] = 'Please use only numbers and hyphens for ISBN';
    } else {
        $query = "SELECT * FROM books WHERE ISBN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['isbn'] = 'ISBN already exists';
        }
    }

    if (empty($quantity)) {
        $errors['quantity'] = 'Quantity is required';
    } elseif (!is_numeric($quantity)) {
        $errors['quantity'] = 'Quantity must be a number';
    }

    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors['image'] = 'File upload error';
    } else {
        $allowedFormats = ['image/jpeg', 'image/png','image/jpg'];
        $fileFormat = mime_content_type($_FILES['image']['tmp_name']);
    
        if (!in_array($fileFormat, $allowedFormats)) {
            $errors['image'] = 'Please upload valid image';
        }
    }

    if (!empty($errors)) {
        $_SESSION['add_books_errors'] = $errors;
        $_SESSION['status'] = 'Adding Failed: ' ;
        header('Location:../admin/show_books.php');        
        exit();
    } else {
        $insertBookQuery = "INSERT INTO books (title, author, category_id, publisher_id, ISBN, quantity_available, description, photo) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($insertBookQuery);
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssiiisbs", $title, $author, $category, $publisher, $isbn, $quantity, $description, $photoContent);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'Book Added Successfully';
            header('Location:../admin/show_books.php');
            exit();
        } else {
            $_SESSION['status'] = 'Adding Failed';
            header('Location:../admin/show_books.php');
            exit();
        }

        $stmt->close();
        $conn->close();
    }
}











if(isset($_POST['update_user'])){
    session_start();
    $userId = $_SESSION['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $number = $_POST['contact_number'];
    $joinDate = date('Y-m-d H:i:s');
    
    $errors = array();

    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 6) {
        $errors['username'] = 'Username must be at least 6 characters long';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8 || strlen($password) > 20) {
        $errors['password'] = 'Password must be between 8 and 20 characters long';
    }

    if (empty($cpassword)) {
        $errors['confirm_password'] = 'Confirm Password is required';
    } elseif ($password !== $cpassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }

    if (empty($address)) {
        $errors['address'] = 'Address is required';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($number)) {
        $errors['contact_number'] = 'Contact Number is required';
    } elseif (!preg_match("/^9[0-9]{9}$/", $number)) {
        $errors['contact_number'] = 'Contact Number must start with "9" and be 10 digits in total';
    }

    if (!empty($errors)) {
        $_SESSION['update_user_errors'] = $errors;
        header('Location: ../admin/user_details.php?id=' . $userId);
        exit();
    } else {
        $sql = "UPDATE members SET username = '$username', name = '$name', address = '$address', contact_number = '$number', email = '$email' WHERE member_id = $userId";

        if ($conn->query($sql)) {
            $_SESSION['status'] = 'Updated Successfully';
            header('Location:../admin/user_details.php');
            exit();
        } else {
            $_SESSION['status'] = 'Update Failed';
            header('Location:../admin/user_details.php');
            exit();
        }
    }
}





if (isset($_POST['update_books'])) {
    include_once 'connection.php'; 
    session_start();

    $bookId = $_POST['b_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category_id = $_POST['category'];
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $quantity = $_POST['quantity'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $publisher = $_POST['publisher'];

    $errors = array();

    if (!empty($_FILES['image']['name'])) {
        $photo = $_FILES['image']['tmp_name'];
        $photoContent = file_get_contents($photo);

        $allowedFormats = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileFormat = mime_content_type($photo);

        if (!in_array($fileFormat, $allowedFormats)) {
            $errors['image'] = 'Please upload valid image (JPEG, JPG, PNG)';
        }
    }

    if (empty($title)) {
        $errors['title'] = 'Title is required';
    } else {
        $query = "SELECT * FROM books WHERE title = '$title' AND book_id != $bookId";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $errors['title'] = 'Title already exists';
        }
    }

    if (empty($author)) {
        $errors['author'] = 'Author is required';
    } else {
        $pattern1 = '/^[a-zA-Z\s]+$/';
        if (!preg_match($pattern1, $author)) {
            $errors['author'] = 'Author can only contain letters';
        }
    }

    if (empty($category_id)) {
        $errors['category'] = 'Category is required';
    }

    if (empty($publisher)) {
        $errors['publisher'] = 'Publisher is required';
    }

    if (empty($isbn)) {
        $errors['isbn'] = 'ISBN is required';
    } elseif (!preg_match("/^[0-9\-]*$/", $isbn)) {
        $errors['isbn'] = 'Please use only numbers and hyphens for ISBN';
    } else {
        $query = "SELECT * FROM books WHERE ISBN = '$isbn' AND book_id != $bookId";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $errors['isbn'] = 'ISBN already exists';
        }
    }

    if (empty($quantity)) {
        $errors['quantity'] = 'Quantity is required';
    } elseif (!is_numeric($quantity)) {
        $errors['quantity'] = 'Quantity must be a number';
    }

    if (empty($description)) {
        $errors['description'] = 'Description is required';
    }

    if (!empty($errors)) {
        $_SESSION['update_books_errors'] = $errors;
        $_SESSION['status'] = 'Update Failed: ';
        header('Location: ../admin/show_books.php');
        exit();
    }

    if (isset($photoContent)) {
        $updateWithPhotoQuery = "UPDATE books 
            SET title='$title', publisher_id='$publisher', author='$author', category_id=$category_id, ISBN='$isbn', quantity_available=$quantity, description='$description', photo=?
            WHERE book_id=$bookId";
        
        $stmt = $conn->prepare($updateWithPhotoQuery);
        $stmt->bind_param("s", $photoContent);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'Book Updated Successfully';
            header('Location:../admin/show_books.php');
            exit();
        } else {
            $_SESSION['status'] = 'Update Failed: ' . mysqli_error($conn);
            header('Location:../admin/show_books.php');
            exit();
        }
    } else {
        $updateWithoutPhotoQuery = "UPDATE books 
            SET title='$title', publisher_id='$publisher', author='$author', category_id=$category_id, ISBN='$isbn', quantity_available=$quantity, description='$description'
            WHERE book_id=$bookId";

        if (mysqli_query($conn, $updateWithoutPhotoQuery)) {
            $_SESSION['status'] = 'Book Updated Successfully';
            header('Location:../admin/show_books.php');
            exit();
        } else {
            $_SESSION['status'] = 'Update Failed: ' . mysqli_error($conn);
            header('Location:../admin/show_books.php');
            exit();
        }
    }

    $conn->close();
}








if (isset($_POST['add_publisher'])) {
    include 'connection.php';
    $publisherName = $_POST['publisher'];
    $location = $_POST['location'];

    $errors = array();

    if (empty($publisherName)) {
        $errors['publisher'] = 'Publisher name is required';
    }

    if (empty($location)) {
        $errors['location'] = 'Location is required';
    } else {
        if (!preg_match("/^[a-zA-Z\s]+$/", $location)) {
            $errors['location'] = 'Location can only contain letters';
        }
    }

    $query = "SELECT * FROM Publisher WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $publisherName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['publisher'] = 'Publisher name already exists';
    }

    if (!empty($errors)) {
        $_SESSION['publisher_errors'] = $errors;
        header("Location: ../admin/add_publisher.php");
        exit();
    }

    $insertQuery = "INSERT INTO Publisher (name, location) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ss", $publisherName, $location);

    if ($stmt->execute()) {
        header("Location: ../admin/add_publisher.php");
        exit();
    } else {
        header("Location: ../admin/add_publisher.php");
        
    }

    $stmt->close();
}



?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';

if (isset($_POST['update_category'])) {
    $categoryName = $_POST['category'];
    $categoryId = $_POST['c_id'];

    $errors = array();

    if (empty($categoryName)) {
        $errors['category'] = 'Category name is required';
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $categoryName)) {
        $errors['category'] = 'Category name can only contain letters';
    }

    $query = "SELECT * FROM category WHERE name = ? AND category_id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $categoryName, $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['category'] = 'Category name already exists';
    }
    if (!empty($errors)) {
        $_SESSION['category_errors'] = $errors;
        header("Location: /lms/admin/add_category.php?c_id=$categoryId");
        exit();
    }
    
    $sql = "UPDATE category SET name = '$categoryName' WHERE category_id = '$categoryId'";
    if ($conn->query($sql)) {
        header("Location: /lms/admin/add_category.php");
        exit();
    } else {
        $_SESSION['category_error_message'] = "Error updating category: ";
        header("Location: /lms/admin/edit_category.php?c_id=$categoryId");
        exit();
    }
    
$conn->close();
}
?>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';

if (isset($_POST['add_category'])) {
    $categoryName = $_POST['category'];

    $errors = array();

    if (empty($categoryName)) {
        $errors['category'] = 'Category name is required';
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $categoryName)) {
        $errors['category'] = 'Category name can only contain letters';
    }

    $query = "SELECT * FROM category WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['category'] = 'Category name already exists';
    }

    if (!empty($errors)) {
        $_SESSION['category_errors'] = $errors;
        header("Location: /lms/admin/add_category.php");
        exit();
    }

    $sql = "INSERT INTO category (name) VALUES ('$categoryName')";
    if ($conn->query($sql)) {
        header("Location: /lms/admin/add_category.php");
        exit();
    } else {
        $_SESSION['category_error_message'] = "Error adding category: " . $conn->error;
        header("Location: /lms/admin/add_category.php");
        exit();
    }
    
    $conn->close();
}
?>



<?php
include 'connection.php';

if (isset($_POST['update_publisher'])) {
    $publisherId = $_POST['c_id'];
    $publisherName = $_POST['publisher'];
    $location = $_POST['location'];

    $errors = array();

    if (empty($publisherName)) {
        $errors['publisher'] = 'Publisher name is required';
    }

    if (empty($location)) {
        $errors['location'] = 'Location is required';
    } else {
        if (!preg_match("/^[a-zA-Z\s]+$/", $location)) {
            $errors['location'] = 'Location can only contain letters';
        }
    }

    $query = "SELECT * FROM publisher WHERE name = ? AND publisher_id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $publisherName, $publisherId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors['publisher'] = 'Publisher name already exists';
    }

    if (!empty($errors)) {
        $_SESSION['publisher_errors'] = $errors;
        header("Location: /lms/admin/add_publisher.php?c_id=$publisherId");
        exit();
    }

    $sql = "UPDATE publisher SET name = '$publisherName', location = '$location' WHERE publisher_id = '$publisherId'";
    if ($conn->query($sql)) {
        header("Location: /lms/admin/add_publisher.php");
    } else {
        $_SESSION['publisher_error_message'] = "Error updating publisher " ;
        header("Location: /lms/admin/add_publisher.php?c_id=$publisherId");
    }
}

$conn->close();
?>


