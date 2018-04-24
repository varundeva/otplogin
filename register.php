<?php
session_start();
include 'include/db.php';
$phone_err="";
$phone="";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $phone_err="";
  $phone="";
  //Mobile Number Validation
	if(!preg_match("/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$_POST["phone"]))
	{
    $phone_err="Enter Correct Mobile Number";
	}
  else {
    require_once 'include/db.php';
    $phone=$_POST["phone"];
    $sql="SELECT mobile FROM patient WHERE mobile='$phone'";
    $result=mysqli_query($db,$sql);
    if(mysqli_num_rows($result)> 0)
    {
      header("Location:login.php?phone=$phone");
      exit();
    }
    else {
      $otp=mt_rand(1000,9999);
      echo "$otp";
      $msg=urlencode("Hello, Your OTP is - $otp\n Don't Share with anyone \n Powered By -https://www.freesv.com");
      $url="http://www.smsidea.co.in/sendsms.aspx?mobile=XXXXXXXX&pass=XXXX&senderid=SMSBUZ&to=".$phone  ."&msg=".$msg;
      $msgst=@file_get_contents($url);
      if($msgst)
      {
        $_SESSION['otp']=$otp;
        $_SESSION['phone']=$phone;
        header( "Location: confirm.php" );
     }
     else {
       $phone_err="Something Went Wrong, Please Try Again Later";
     }
    }
  }



}
 ?>

<html>
<head>
  <title>
    Welcome
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
    <!-- Content here -->
    <div class="row">
      <div class="col-md-3">
       </div>
       <div class="col-md-6" >
         <h3>Registration</h3>
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="margin-top:5%;" method="post">
             <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                 <label>Mobile Number:</label>
                 <input type="text" placeholder="Mobile Number" name="phone" maxlength="10" class="form-control" value="<?php echo $phone; ?>">
                 <span class="text-danger"><?php echo $phone_err; ?></span>
             </div>
             <div class="form-group col-md-2">
                 <input type="submit" class="btn btn-primary" value="Submit">
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
