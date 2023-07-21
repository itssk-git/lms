
<?php
include '../includes/connection.php';
?>
<?php include_once 'header.php'; ?>

<style>
   
    a[href="user_details.php"] {
      display: inline-block;
      padding: 10px 20px;
      background-color: #1e3050;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.2s ease-in-out;
    }

    a[href="user_details.php"]:hover {
      background-color: #218838; 
    }
  </style>
<div class="alert alert-success d-flex justify-content-between" role="alert">
  <a href="user_details.php">All Users</a>
  <?php 
  if(isset($_SESSION['status'])){
    echo $_SESSION['status'];
    unset($_SESSION['status']); }
    
    
    if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']); }
  ?>
  <form class="d-flex" action="" method="GET">
    <input type="text" name="search_user" id="" placeholder="Search Users">
    <button class="btn btn-success" name="search_btn">Search</button>
  </form>
</div>




  

<?php

if (isset($_GET['search_btn'])) {
  $user = $_GET['search_user'];

  $sql = "SELECT * FROM members WHERE `name` LIKE '%$user%'";
  $result = $conn->query($sql);
}
else{
  $select_users = "SELECT * FROM members";


  $result = $conn->query($select_users);
}

if($result){


if ($result->num_rows > 0) {

    
    echo "<table class='table table-striped'>";
    echo "<tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Join Date</th>
            <th>UserType</th>
            <th>Edit</th>
            <th>Delete</th>
            
          </tr>";

    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['member_id']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['password']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['address']."</td>";
        echo "<td>".$row['contact_number']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['join_date']."</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>
        <a href='../user/registration.php?m_id=".$row['member_id']."' class='btn btn-success'>Edit</a>
      </td>";
      echo "<td>
      <a href='../admin/delete_button.php?m_id=".$row['member_id']."' onclick=\"return confirm('Are you sure you want to delete this user?');\" class='btn btn-danger'>Delete</a>
  </td>";
  
        

        
        echo "</tr>";
    }

    
    echo "</table>";
} else {
    echo "No users found.";
}
}



?>




<?php
include ('../includes/footer.php');

?>
