<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Administration</title>
  <link rel="icon" href="assets/img/icon.jpg">
	<link rel="stylesheet" href="assets/css/loading.css">
</head>
<body>

  <style>
    body {
		  background: linear-gradient(#00b16a, rgba(0, 0, 0, 0.5), #33b5e5), url(assets/img/banner.jpg) !important;
		  background-size: cover !important;
		  backdrop-filter: blur(5px) !important;
	  }
  </style>
  
<?php
require 'authentication.php';

// authentication check

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// admininstrator check

$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
  header('Location: task-info.php');
}

$page_name="Admin";
include("includes/sidebar.php");

?>

<!-- Administrator details -->

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <ul class="nav nav-tabs nav-justified nav-tabs-custom">
        <li class="active"><a href="manage-admin.php" style="background: #00b16a; color: #fff;">Manage Admin</a></li>
        <li><a href="admin-manage-user.php">Manage User</a></li>
      </ul>
      <div class="gap"></div>
      <br>
      <div class="table-responsive">
        <table class="table">
          <thead class="thead-dark">
            <tr scope="col" style="color: #fff; background: #292b2c;">
              <th>Serial No.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Username</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>

          <?php 
            $sql = "SELECT * FROM tbl_admin WHERE user_role = 1";
            $info = $obj_admin->manage_all_info($sql);

            $serial  = 1;
            $total_expense = 0.00;
            while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
          ?>
            <tr>
              <td><?php echo $serial; $serial++; ?></td>
              <td><?php echo $row['fullname']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['username']; ?></td>
              
              <td><a title="Update Admin" href="update-admin.php?admin_id=<?php echo $row['user_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;</td>
            </tr>
            
          <?php  } ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_SESSION['update_user_pass'])){

  echo '<script>alert("Password updated successfully");</script>';
  unset($_SESSION['update_user_pass']);
}
include("includes/footer.php");

?>

<!-- loader wrapper --> 

<div class="loader-wrapper">
	<span class="loader loader-gradient-green"><span class="loader-inner"></span></span>
</div>

<script>
	$(window).on("load", function() {
		$(".loader-wrapper").fadeOut("slow");
	});
</script>

</body>
</html>

