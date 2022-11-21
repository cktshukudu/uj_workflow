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
if($user_role != 1){
  header('Location: task-info.php');
}

if(isset($_GET['delete_user'])){
  $action_id = $_GET['admin_id'];

  $task_sql = "DELETE FROM task_info WHERE t_user_id = $action_id";
  $delete_task = $obj_admin->db->prepare($task_sql);
  $delete_task->execute();

  $attendance_sql = "DELETE FROM attendance_info WHERE atn_user_id = $action_id";
  $delete_attendance = $obj_admin->db->prepare($attendance_sql);
  $delete_attendance->execute();
  
  $sql = "DELETE FROM tbl_admin WHERE user_id = :id";
  $sent_po = "admin-manage-user.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

$page_name="Admin";
include("includes/sidebar.php");

if(isset($_POST['add_user'])){
  $error = $obj_admin->add_new_user($_POST);
}

?>

<!--modal dialog for adding user-->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title text-center">Add User Info</h2>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <?php if(isset($error)){ ?>
              <h5 class="alert alert-danger"><?php echo $error; ?></h5>
              <?php } ?>
            <form role="form" action="" method="post" autocomplete="off">
              <div class="form-horizontal">

                <div class="form-group">
                  <label class="control-label col-sm-4">Fullname</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="Enter User's Name" name="em_fullname" list="expense" class="form-control input-custom" id="default" required>
                  </div>
                </div>
                  <div class="form-group">
                  <label class="control-label col-sm-4">Username</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="Enter User's username" name="em_username" class="form-control input-custom" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">Email</label>
                  <div class="col-sm-6">
                    <input type="email" placeholder="Enter User's Email" name="em_email" class="form-control input-custom" required>
                  </div>
                </div>       
                
                <div class="form-group">
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-3">
                    <button type="submit" name="add_user" class="btn btn-success-custom">Add User</button>
                  </div>
                  <div class="col-sm-3">
                    <button type="submit" class="btn btn-danger-custom" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </form> 
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!--modal dialog for user navigation-->

<div class="row">
  <div class="col-md-12">
    <div class="row">
        
    <div class="well well-custom">
      <?php if(isset($error)){ ?>
      <script type="text/javascript">
        $('#myModal').modal('show');
      </script>
      <?php } ?>
        <?php if($user_role == 1){ ?>
            <div class="btn-group">
              <button class="btn btn-primary btn-menu" data-toggle="modal" data-target="#myModal" style="border: 0; border-radius: 5px;">Add New User</button>
            </div>
          <?php } ?>
      <ul class="nav nav-tabs nav-justified nav-tabs-custom"><br>
        <li><a href="manage-admin.php">Manage Admin</a></li>
        <li class="active"><a href="admin-manage-user.php" style="background: #00b16a; color: #fff;">Manage User</a></li>
      </ul>
      <div class="gap"></div>
      <br>
      <div class="table-responsive">
        <table class="table">
          <thead class="thead-dark">
            <tr scope="col" style="color: #fff; background: #292b2c;">
              <th>Serial No.</th>
              <th>Fullname</th>
              <th>Email</th>
              <th>Username</th>
              <th>Temp Password</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>

          <?php 
            $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 ORDER BY user_id DESC";
            $info = $obj_admin->manage_all_info($sql);
            $serial  = 1;
            $num_row = $info->rowCount();
              if($num_row==0){
                echo '<tr><td colspan="7">No Data found</td></tr>';
              }
            while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
          ?>
            <tr>
              <td><?php echo $serial; $serial++; ?></td>
              <td><?php echo $row['fullname']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['username']; ?></td>
              <td><?php echo $row['temp_password']; ?></td>
              
              <td><a title="Update User" href="update-user.php?admin_id=<?php echo $row['user_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;<a title="Delete" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
            
          <?php  } ?>
            
          </tbody>
        </table>
      </div>
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

