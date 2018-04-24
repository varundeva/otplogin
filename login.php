<?php
session_start();
$phone=$password="";
$phone_err=$password_err="";
$diserr=$err="";
if(isset($_GET['phone']))
{
  $phone=$_GET['phone'];
}
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(!preg_match("/[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]/",$_POST["phone"]))
        	{
            $phone_err="Enter Valid Mobile Number";
        	}
          else
          {
              $phone = $_POST["phone"];
          }


        // Check if password is empty
        if(empty(trim($_POST['password']))){
            $password_err = 'Please enter your password.';
        } else{
            $password = trim($_POST['password']);
        }

        //Param Password
        $param_password="";
        $param_password = md5($password);

        // Validate credentials
        if(empty($phone_err) && empty($password_err))
        {
            // Prepare a select statement
            require_once 'include/db.php';
            $sql = "SELECT patient_id FROM patient WHERE mobile = '$phone' AND password='$param_password'";
            $result=mysqli_query($db,$sql)or die(mysqli_error($sql));
            if(mysqli_num_rows($result)> 0)
            {
              if($row=mysqli_fetch_array($result))
              {
                $_SESSION['patient_id']=$row['patient_id'];
                header("Location:dashboard.php");
                exit();
              }else {
                  $err="Something Went Wrong Please Contact Admin";
              }
            }else {
              $err="Your Mobile Number or Password Enterd Invalid";
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
          <h2 align="center">Login</h2>
          <p>Please fill in your credentials to login.</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                  <label>Register Number:</label>
                  <input type="text" placeholder="Mobile Number" name="phone" maxlength="10" class="form-control" value="<?php echo $phone; ?>">
                  <span class="text-danger"><?php echo $phone_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label>Password:</label>
                  <input type="password" placeholder="Password" name="password" class="form-control">
                  <span class="text-danger"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Submit">
              </div>
              <p><span class="text-danger"><?php echo $err; ?></span></p>
               <?php   echo "Forgot Password? <a href=\"otplogin.php?phone=$phone\">Login with OTP</a>";?>
              <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
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
