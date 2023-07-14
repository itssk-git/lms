<?php include_once 'header.php'; ?>
<?php
if (!isset($_SESSION['username']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== "admin") {
  header("Location: ../user/login.php");
  exit();
}
?>

<div class="container">
  <div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
      <div class="container mt-4" style="overflow-x: auto;">
        <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card my-3">
              <div class="card-body">
                <h5 class="card-title">Show users</h5>
                <p class="card-text">Show users details </p>
                <a href="user_details.php" class="btn btn-primary">More Details</a>
              </div>
            </div>
          </div>



          <div class="col-md-4">
            <div class="card my-3">
              <div class="card-body">
                <h5 class="card-title">Add Books</h5>
                <p class="card-text">Add and manage books</p>
                <a href="add_books.php" class="btn btn-primary">More Details</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card my-3">
              <div class="card-body">
                <h5 class="card-title">Show Books</h5>
                <p class="card-text">Description of Books </p>
                <a href="show_books.php" class="btn btn-primary">More Details</a>
              </div>
            </div>
          </div>

         

          <div class="col-md-4">
            <div class="card my-3">
              <div class="card-body">
                <h5 class="card-title">Other Section</h5>
                <p class="card-text">Description of other section</p>
                <a href="other_section.php" class="btn btn-primary">More Details</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card my-3">
              <div class="card-body">
                <h5 class="card-title">Other Section</h5>
                <p class="card-text">Description of other section</p>
                <a href="other_section.php" class="btn btn-primary">More Details</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card my-3">
              <div class="card-body">
                <h5 class="card-title">Other Section</h5>
                <p class="card-text">Description of other section</p>
                <a href="other_section.php" class="btn btn-primary">More Details</a>
              </div>
            </div>
          </div>

          
        </div>
      </div>
    </div>
    <div class="col-lg-2"></div>
  </div>
</div>

<?php
include ('../includes/footer.php');

?>
