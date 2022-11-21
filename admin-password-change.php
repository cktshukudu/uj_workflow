<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administration</title>
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

$admin_id = $_GET['admin_id'];
if(isset($_POST['btn_admin_password'])){
    $error = $obj_admin->admin_password_change($_POST,$admin_id);
}
             
$page_name="Admin";
include("includes/sidebar.php");

?>

<script>
  function validate(admin_new_password,admin_cnew_password){
      var a = document.getElementById(admin_new_password).value;
      var b = document.getElementById(admin_cnew_password).value;
      if (a!=b) {
          alert("Passwords do not match");
          
      }
      return false;
  }
</script>

<!-- administration tab - change password -->

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <ul class="nav nav-tabs nav-justified nav-tabs-custom">
        <li class="active"><a href="manage-admin.php" style="background: #00b16a; color: #fff;">Manage Admin</a></li>
        <li><a href="admin-manage-user.php">Manage User</a></li>
      </ul>
      <div class="gap"></div>
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="well">
            <h3 class="text-center" style="font-weight: bold; font-size: 30px;">Change Password</h3>
              <hr style="border: 5px solid #33b5e5;"><br>
              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                
                <?php 

                if(isset($error)){
                  ?>
                  <div class="alert alert-danger">
                    <strong>Oopps!!</strong> <?php echo $error; ?>
                  </div>
                  <?php             
                }
                ?>

                <!-- admin change password-->

                  <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                    <div class="form-group">
                      <label class="control-label col-sm-4">Old Password</label>
                      <div class="col-sm-8">
                        <input type="password" placeholder="Enter Old Password" name="admin_old_password" id="admin_old_password" list="expense" class="form-control input-custom" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4">New Password</label>
                      <div class="col-sm-8">
                        <input type="password" placeholder="Enter New Password" name="admin_new_password" id="admin_new_password" class="form-control input-custom" min="8" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4">Confirm New Password</label>
                      <div class="col-sm-8">
                        <input type="password" placeholder="Confirm New Password" name="admin_cnew_password" id="admin_cnew_password" list="expense" min="8" class="form-control input-custom" required>
                      </div>
                    </div>
              
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-3">
                        <button type="submit" name="btn_admin_password" class="btn btn-success-custom">Change</button>
                        
                      </div>
                      <div class="col-sm-3">
                        <a href="manage-admin.php" class="btn btn-danger-custom">cancel</a>
                        
                      </div>
                    </div>
                  </form> 
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php

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

