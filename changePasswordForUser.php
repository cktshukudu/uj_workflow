<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create Password</title>
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

if(isset($_SESSION['admin_id'])){
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['name'];
  $security_key = $_SESSION['security_key'];
 
}

if(isset($_POST['change_password_btn'])){
 $info = $obj_admin->change_password_for_user($_POST);
}

$page_name="Login";
include("includes/login_header.php");

?>

<!-- User first time change password (after getting temp password) -->

<div class="row">
	<div class="col-md-4 col-md-offset-3">
		<div class="well" style="position:relative;top:20vh;">
			<form class="form-horizontal form-custom-login" action="" method="POST">
			  <div class="form-heading" style="background: transparent;">
			    <h2 class="text-center" style="font-weight: bold; font-size: 30px; color: #000;">Please Change your password</h2>
				<hr style="border: 5px solid orange;">
			  </div>
			  <?php if(isset($info)){ ?>
			  <h5 class="alert alert-danger"><?php echo $info; ?></h5>
			  <?php } ?>
			  
			  <div class="form-group">
			  	<input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" required/>
			    <input type="password" class="form-control" placeholder="Password" name="password" required/>
			  </div>
			  <div class="form-group">
			    <input type="password" class="form-control" placeholder="Retype Password" name="re_password" required/>
			  </div>
			  <button type="submit" name="change_password_btn" class="btn btn-success pull-right" style="border: 0; border-radius: 10px;">Change Password</button>
			</form>
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

