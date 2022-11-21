<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin/User Login</title>
	<link rel="icon" href="assets/img/icon.jpg">
	<link rel="stylesheet" href="assets/css/loading.css">
	<link rel="stylesheet" href="assets/css/glitch.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik+Bubbles&display=swap" rel="stylesheet">
</head>
<body>

<style>
	body {
		background: linear-gradient(#00b16a, rgba(0, 0, 0, 0.5), #33b5e5), url(assets/img/banner.jpg) !important;
		background-size: cover !important;
		backdrop-filter: blur(5px) !important;
		position: relative;
	}
</style>

<?php
require 'authentication.php';

// authentication check

if(isset($_SESSION['admin_id'])){
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['admin_name'];
  $security_key = $_SESSION['security_key'];
  if ($user_id != NULL && $security_key != NULL) {
    header('Location: task-info.php');
  }
}

if(isset($_POST['login_btn'])){
 $info = $obj_admin->admin_login_check($_POST);
}

$page_name="Login";
include("includes/login_header.php");

?>

<!-- Login platform -->

<div class="container">
  	<div class="glitch" data-text="WATCH THIS VIDEO BEFORE USING THE APP">WATCH THIS VIDEO BEFORE USING THE APP</div> 
  		<div class="glow">WATCH THIS VIDEO BEFORE USING THE APP</div>
  			<p class="subtitle"></p>
</div>
<div class="scanlines"></div>
<div class="row">
	<div class="col-md-4">
		<div style="position:relative;top:20vh;">
			<iframe class="embed-responsive-item" width="760" height="440" src="https://www.youtube.com/embed/CoLNPvbTwL8" allowfullscreen></iframe>
		</div>
	</div>
	<div class="col-md-4 col-md-offset-3">
		<div class="well" style="position:relative;top:20vh;">
			<form class="form-horizontal form-custom-login" action="" method="POST">
				<div class="form-heading" style="background: transparent;">
					<h2 class="text-center" style="font-weight: bold; font-size: 30px; color: #000;">Login</h2>
					<hr style="border: 5px solid #00b16a;">
				</div>
					
				<?php if(isset($info)){ ?>
				<h5 class="alert alert-danger"><?php echo $info; ?></h5>
				<?php } ?>
				
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Username" name="username" required/>
				</div>
				<div class="form-group" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
					<input type="password" class="form-control" placeholder="Password" name="admin_password" required/>
				</div>
				<button type="submit" name="login_btn" class="btn btn-info pull-right" style="border: 0; border-radius: 10px;">Sign In</button>
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

