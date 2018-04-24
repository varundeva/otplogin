<?php
session_start();
if(!isset($_SESSION['otp']) || empty($_SESSION['otp']))
{
  header("location: index.php");
}

$otp=$phone="";
$otp=$_SESSION['otp'];
$phone=$_SESSION['phone'];
$otprcvd_err=$otprcvd=$patient_id="";

echo "$otp + $phone";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate mobile Number
    if(!preg_match("/[0-9][0-9][0-9][0-9]/",$_POST['otprcvd']))
	{
        $otprcvd_err = "!Please enter a valid OTP with a format of 0000";
    }else {
      $otprcvd = (isset($_POST['otprcvd']) ? $_POST['otprcvd'] : '');
      if($otp!=$otprcvd)
      {
        $otprcvd_err = "!Please enter a valid OTP you recieved";
      }else  {
              unset($_SESSION['otp']);
              $sql="SELECT patient_id FROM patient WHERE mobile='$phone'";
              require_once 'include/db.php';
              $result=mysqli_query($db,$sql);
              while ($row=mysqli_fetch_array($result))
              {
              $patient_id=$row['patient_id'];
              }
              unset($_SESSION['phone']);
              if($_SESSION['patient_id']=$patient_id)
              {
                header( "Location: dashboard.php" );
                }
              else
              {
                $otprcvd_err="Something Went Wrong";
              }

            }
    }
}
 ?>

<html>
<head>
  <title>
    Confirm Your Mobile Number
  </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- meta tags end -->
<!-- bootstrap Styleshert and JavaScript Start -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- bootstrap Styleshert and JavaScript End -->
<!-- Including Custom CSS -->
<link rel="stylesheet" type="text/css" href="css/style.css">
<!-- font-awesome cdn start-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- font-awesome cdn end-->
<style type="text/css">
    body{ font: 14px sans-serif; }
    .wrapper{ width: 350px; padding: 20px; }
</style>
</head>
<body>

  <div class="container">
<div class="row">
  <div class="col-md-3">
   </div>
    <div class="col-md-6">
      <h2 align="center">Enter OTP</h2>
      <p>Please enter your OTP recieved to your number <br> Wait a minute if it not recieved</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($otprcvd_err)) ? 'has-error' : ''; ?>">
              <label>Recieved OTP :<sup>*</sup></label>
              <input type="text" placeholder="Enter Recieved OTP" name="otprcvd" maxlength="4" class="form-control" value="<?php echo $otprcvd; ?>">
              <span class="text-danger"><?php echo $otprcvd_err; ?></span>
          </div>
          <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit">
          </div>
          <div class="form-group">
            <p>Still Not Recieved OTP?</p>
            <a type="button" class="btn btn-danger" href="?resendotp=1">Resend OTP</a>
            <?php
            if(isset($_GET['resendotp'])){
              $msg=urlencode("Hello OTP is - $otp\n Don't Share with anyone \n Powered By -https://www.freesv.com");
               $url="https://smsapi.engineeringtgr.com/send/?Mobile=XXXXXXXXXX&Password=XXXXXXXXXX&Key=xxxxxxxxxxxxxx&Message=".$msg."&To=".$phone;
               $msgst=@file_get_contents($url);
             }
            ?>
        </div>
      </form>
  </div>
  <div class="col-md-3">
   </div>
</div>
</div>


<!--JavaScript and Jquery CDN Start -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!--JavaScript and Jquery CDN End-->
</body>
</html>
