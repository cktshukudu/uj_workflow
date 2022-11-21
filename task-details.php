<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Task Details</title>
	<link rel="icon" href="assets/img/icon.jpg">
	<link rel="stylesheet" href="assets/css/loading.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
$task_id = $_GET['task_id'];

if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
}

$page_name="Edit Task";
include("includes/sidebar.php");

$sql = "SELECT a.*, b.fullname 
FROM task_info a
LEFT JOIN tbl_admin b ON(a.t_user_id = b.user_id)
WHERE task_id='$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>

<!--modal dialog for viewing user task details-->

<div class="row">
	<div class="col-md-12">
		<div class="well well-custom">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="well">
						<h3 class="text-center" style="font-weight: bold; font-size: 30px;">Task Details </h3>
						<hr style="border: 5px solid #33b5e5;"><br>
							<div class="row">
								<div class="col-md-12">

									<div class="table-responsive">
										<table class="table table-striped">
											<tbody>
												<tr>
													<td>Task Title</td><td><?php echo $row['t_title']; ?></td>
												</tr>
												<tr>
													<td>Description</td><td><?php echo $row['t_description']; ?></td>
												</tr>
												<tr>
													<td>Start Time</td><td><?php echo $row['t_start_time']; ?></td>
												</tr>
												<tr>
													<td>End Time</td><td><?php echo $row['t_end_time']; ?></td>
												</tr>
												<tr>
													<td>Assign To</td><td><?php echo $row['fullname']; ?></td>
												</tr>
												<tr>
													<td>Status</td><td><?php  if($row['status'] == 1){
																				echo "In Progress";
																			}elseif($row['status'] == 2){
																				echo "Completed";
																			}else{
																				echo "Incomplete";
																			} ?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="form-group">
										<div class="col-sm-3">
											<a title="Update Task"  href="task-info.php"><span class="btn btn-success-custom btn-xs">Go Back</span></a>
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

