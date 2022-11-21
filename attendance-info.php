<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance</title>
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
    h3 {
    font-weight: bold !important;
  }
  </style>

 <?php

require 'authentication.php';

// authentication check

$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
$user_role = $_SESSION['user_role'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

if(isset($_GET['delete_attendance'])){
  $action_id = $_GET['aten_id'];
  
  $sql = "DELETE FROM attendance_info WHERE aten_id = :id";
  $sent_po = "attendance-info.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

if(isset($_POST['add_punch_in'])){
   $info = $obj_admin->add_punch_in($_POST);
}

if(isset($_POST['add_punch_out'])){
    $obj_admin->add_punch_out($_POST);
}

$page_name="Attendance";
include("includes/sidebar.php");

?>

<!-- clock in -->

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <div class="row">
        <div class="col-md-8 ">
          <div class="btn-group">
            <?php 
            
              $sql = "SELECT * FROM attendance_info
                      WHERE atn_user_id = $user_id AND out_time IS NULL";
            

              $info = $obj_admin->manage_all_info($sql);
              $num_row = $info->rowCount();
              if($num_row==0){
          ?>

            <div class="btn-group">
              <form method="post" role="form" action="">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit" name="add_punch_in" class="btn btn-primary btn-lg rounded" style="border: 0; border-radius: 5px;">Clock In</button>
              </form>  
            </div>

          <?php } ?>

          </div>
        </div>
      </div>
      
      <!-- attendance management table -->

      <center><h3>Manage Atendance</h3>  </center>
      <br>
      <div class="gap"></div>
      <div class="gap"></div>

      <div class="table-responsive">
        <table class="table">
          <thead class="thead-dark">
            <tr scope="col" style="color: #fff; background: #292b2c;">
              <th>S.N.</th>
              <th>Name</th>
              <th>In Time</th>
              <th>Out Time</th>
              <th>Total Duration</th>
              <th>Status</th>
              <?php if($user_role == 1){ ?>
              <th>Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>

          <?php 
            if($user_role == 1){
              $sql = "SELECT a.*, b.fullname 
              FROM attendance_info a
              LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
              ORDER BY a.aten_id DESC";
            }else{
              $sql = "SELECT a.*, b.fullname 
              FROM attendance_info a
              LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id)
              WHERE atn_user_id = $user_id
              ORDER BY a.aten_id DESC";
            }      

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
              <td><?php echo $row['in_time']; ?></td>
              <td><?php echo $row['out_time']; ?></td>
              <td><?php
                if($row['total_duration'] == null){
                  $date = new DateTime('now', new DateTimeZone('Africa/Johannesburg'));
                  $current_time = $date->format('d-m-Y H:i:s');

                  $dteStart = new DateTime($row['in_time']);
                  $dteEnd   = new DateTime($current_time);
                  $dteDiff  = $dteStart->diff($dteEnd);
                  echo $dteDiff->format("%H:%I:%S"); 
                }else{
                  echo $row['total_duration'];
                }   

              ?></td>
              <?php if($row['out_time'] == null){ ?>
              <td>
                <form method="post" role="form" action="">
                  <input type="hidden" name="punch_in_time" value="<?php echo $row['in_time']; ?>">
                  <input type="hidden" name="aten_id" value="<?php echo $row['aten_id']; ?>">
                  <button type="submit" name="add_punch_out" class="btn btn-danger-custom btn-xs rounded" style="margin-top: 0; width: 6rem; padding: 0; border-radius: 10px;">Clock Out</button>
                </form>
              </td>
            <?php } ?>
            <?php if($user_role == 1){ ?>
              <td>
              <a title="Delete" href="?delete_attendance=delete_attendance&aten_id=<?php echo $row['aten_id']; ?>" onclick=" return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
          <?php } ?>
            </tr>
            <?php } ?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php

include("includes/footer.php");

?>

<!-- loader wrapper --> 

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 

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


