<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notification</title>
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
    #status {
      color: #999;
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

$page_name="Edit Task";
include("includes/sidebar.php");

?>

<!-- Manage Notification email -->

<?php 
// Import PHPMailer classes into the global namespace

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception; 
 
// Include library files 

require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 

$massage = '';
 

if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$status = $_POST['status'];

// Create an instance; Pass `true` to enable exceptions 
$mail = new PHPMailer(); 
 
// **************Server settings***************** //

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output 

$mail->isSMTP();                                   // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers 
$mail->SMTPAuth = true;                            // Enable SMTP authentication 
$mail->Username = 'terror.tivani@gmail.com';       // SMTP username 
$mail->Password = 'hqyrjsfttuvrsapq';              // SMTP password 
$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587 ;                                // TCP port to connect to 
 
// Sender info 

$mail->setFrom('terror.tivani@gmail.com', 'SenderName'); 
$mail->addReplyTo('reply@example.com', 'SenderName');
 
// Add a recipient 

$mail->addAddress($email); //$mail->addCC('cc@example.com'); --AND/OR-- $mail->addBCC('bcc@example.com'); 
$mail->isHTML(true); // Set email format to HTML 
$mail->Subject = 'Email from Task Manage'; // Mail subject 
 
// Mail body content 

$bodyContent = "<p>Hi there,<br><br>You have a task that is <strong>$status</strong>.<br>Please log in 
                <a href='https://workflow-application.herokuapp.com/index.php' target='_blank'>here</a> 
                and make approriate changes to this reference.<br><br>Regards.</p>"; 
$bodyContent .= "<p>This email is sent by the <b>Admin</b></p>"; 
$mail->Body    = $bodyContent; 

// Send email 

if(!$mail->send()) { 
    $massage = 'Notification NOT sent !!'; 
} else { 
    $massage = 'Notification sent !!'; 
}

//closing stmp connection

$mail->smtpClose();
}
?>

<!--modal for employee add-->

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="well">
            <h3 class="text-center" style="font-weight: bold; font-size: 30px;">
            <?php if(!$massage){
                                echo "Notification";
                                }else{
                                  echo $massage;
                                }?>
            </h3>
            <hr style="border: 5px solid #33b5e5;"><br>
            <div class="row">
              <div class="col-md-12">
                <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                      <div class="form-group">
                    <label class="control-label col-sm-4">Email</label>
                    <div class="col-sm-6">
                      <input type="text" name="email" placeholder="Enter Notifying Email" id="task_id"  class="form-control input-custom" <?php if($user_role != 1){ ?> readonly <?php } ?> val required>
                    </div>
                  </div>

                    <div class="form-group">
                      <label class="control-label col-sm-4">Status</label>
                    <div class="col-sm-6">
                      <select class="form-control input-custom" name="status" required>
                      <option value="" id="status">Select Status...</option>
                        <?php
                            $selected = "";
                            $options = array("DUE", "OVERDUE");
                            foreach ($options as $option) {
                              if ($selected == $option) {
                                echo "<option class='form-control input-custom' selected = '$selected' value='$option'>$option</option>";
                              }
                              else {
                                echo "<option class='form-control input-custom' value='$option'>$option</option>";
                              }
                            }
                        ?> 
                      </select>
                    </div>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-3">
                        <button type="submit" name="submit" class="btn btn-success-custom">Notify</button>
                      </div>
                      <div class="col-sm-3">
                        <a title="Update Task"  href="task-info.php"><span class="btn btn-danger-custom btn-xs">Cancel</span></a>
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

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- JS start & end times -->

<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true
  });

  flatpickr('#t_end_time', {
    enableTime: true
  });

</script>

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

