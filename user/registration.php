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
        <form action="../includes/all_action.php"  method="POST">
            <div class="form-group">
               
                <label for="username">Username</label>
                <input type="text" class="form-control" onInput="checkUsername()" id="username" value="<?php echo isset($username) ? $username : ''; ?>" name="username" required>
                
                <span class="text-danger" id="username_error"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" value="<?php echo isset($password) ? $password : ''; ?>"name="password" required>
  
    <span class="text-danger" id="passwordError"></span>

            
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" value="<?php echo isset($password) ? $password : ''; ?>" name="confirm_password" required>
                <span class="text-danger" id="confirmPasswordError"></span>

            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" value="<?php echo isset($name) ? $name : ''; ?>" name="name" required>
                <span class="text-danger" id="name_error"></span>

            </div>
            <div class="form-group">
                <label for="address">Address</label>

                <input type="text" class="form-control" id="address" value="<?php echo isset($address) ? $address : ''; ?>"name="address" required>
                <span class="text-danger" id="address_error"></span>

            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" value="<?php echo isset($contact) ? $contact : ''; ?>"name="contact_number" required>
                <span class="text-danger" id="contact_number_error"></span>

            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"required maxlength="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                <span class="text-danger" id="email_error"></span>

            </div>
            <?php
            if(isset($userId)){
                echo '<button type="submit" id="submit" name="update_user" class="btn btn-primary">' . $buttonLabel . '</button>';
            }

            else{
                echo '<button type="submit" id="submit" name="register" class="btn btn-primary"> Register </button>';



            }
            ?>
            
        </form>
    </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
  $('#username').on('keyup', function() {
    var username = $(this).val();

    if (username === '') {
     
     $('#username_error').html('');
     
     $('#submit').prop('disabled', true);
   }
   else {
    
     $.ajax({
       url: '../validate/checkAvailability.php',
       type: 'POST',
       data: { user_name: username },
       success: function(response) {
         if (response === 'available') {
           $('#username_error').html('<span class="text-success"></span>');
           $('#submit').prop('disabled', false);
         } else {
           $('#username_error').html('<span class="text-danger">Username already exists</span>');
           $('#submit').prop('disabled', true);
         }
       }
     });
    }
   
 });
});

   

    
</script>


<script>
    $(document).ready(function() {
  $('#email').on('keyup', function() {
    var email = $(this).val();

    if (email === '') {
     
      $('#email_error').html('');
      
      $('#submit').prop('disabled', false);
    }
    else {
      $.ajax({
        url: '../validate/checkAvailability.php',
        type: 'POST',
        data: { a_email: email },
        success: function(response) {
          if (response === 'available') {
            $('#email_error').html('<span class="text-success"></span>');
            $('#submit').prop('disabled', false);
          } else {
            $('#email_error').html('<span class="text-danger">Email already exists</span>');
            $('#submit').prop('disabled', true);
          }
        }
      });
    }
  });
});


    
</script>



<script>
  $(document).ready(function() {
    $('#contact_number').on('blur', function() {
      var contactNumber = $(this).val();

      $('#contact_number_error').html('');

      if (contactNumber !== '') {
        if (!/^\d{10}$/.test(contactNumber)) {
          $('#contact_number_error').html('<span class="text-danger">Must be number and  exactly 10 digits</span>');
          $('#submit').prop('disabled', true);
        } else {
          $('#contact_number_error').html('');
          $('#submit').prop('disabled', false);

          $.ajax({
            url: '../validate/checkAvailability.php',
            type: 'POST',
            data: { a_contact: contactNumber },
            success: function(response) {
              if (response === 'available') {
                $('#contact_number_error').html('<span class="text-success"></span>');
                $('#submit').prop('disabled', false);
              } else {
                $('#contact_number_error').html('<span class="text-danger">Number already exists</span>');
                $('#submit').prop('disabled', true);
              }
            }
          });
        }
      } else {
        $('#submit').prop('disabled', false);
      }
    });
  });
</script>







<script>
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirm_password');
    var passwordError = document.getElementById('passwordError');
    var confirmPasswordError = document.getElementById('confirmPasswordError');

    function validatePasswordConfirmation() {
      var password = passwordInput.value;
      var confirmPassword = confirmPasswordInput.value;

      if (password === '') {
        passwordError.textContent = '';
      } else if (password.length < 8) {
        passwordError.textContent = 'Password must be at least 8 characters long';
      } else {
        passwordError.textContent = '';
      }

      if (confirmPassword === '') {
        confirmPasswordError.textContent = '';
      } else if (password !== confirmPassword) {
        confirmPasswordError.textContent = 'Passwords do not match';
      } else {
        confirmPasswordError.textContent = '';
      }
    }

    passwordInput.addEventListener('input', validatePasswordConfirmation);
    confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);
</script>



<script>
  document.getElementById('submit').addEventListener('click', function(event) {

    var usernameInput = document.getElementById('username');
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirm_password');
    var nameInput = document.getElementById('name');
    var addressInput = document.getElementById('address');
    var contactNumberInput = document.getElementById('contact_number');
    var emailInput = document.getElementById('email');

    if (usernameInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('username_error').textContent = 'Username is required';
    }

    if (passwordInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('passwordError').textContent = 'Password is required';
    }

    if (confirmPasswordInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('confirmPasswordError').textContent = 'Confirm Password is required';
    }

    if (nameInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('name_error').textContent = 'Name is required';
    }

    if (addressInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('address_error').textContent = 'Address is required';
    }

    if (contactNumberInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('contact_number_error').textContent = 'Contact Number is required';
    }

    if (emailInput.value.trim() === '') {
      event.preventDefault(); 
      document.getElementById('email_error').textContent = 'Email is required';
    }
  });
</script>


<script>
  document.getElementById('address').addEventListener('input', function(event) {
    var addressInput = event.target;
    var addressError = document.getElementById('address_error');
    var regex = /^[A-Za-z\s]+$/;

    if (addressInput.value.trim() === '') {
      addressError.textContent = '';
    } else if (!regex.test(addressInput.value)) {
      addressError.textContent = 'Address must contain only alphabetic characters';
      event.preventDefault();
    } else {
      addressError.textContent = '';
    }
  });

  document.getElementById('name').addEventListener('input', function(event) {
    var nameInput = event.target;
    var nameError = document.getElementById('name_error');
    var regex = /^[A-Za-z\s]+$/;

    if (nameInput.value.trim() === '') {
      nameError.textContent = '';
    } else if (!regex.test(nameInput.value)) {
      nameError.textContent = 'Name must contain only alphabetic characters';
      event.preventDefault();
    } else {
      nameError.textContent = '';
    }
  });
</script>





<?php
  include '../includes/footer.php';
?>
