<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['patient_id']) || empty($_SESSION['patient_id']))
{
  header("location: index.php");
}
 ?>
<?php
$name=$password=$confirm_password=$email=$address=$dob=$age=$blood="";
$name_err=$password_err=$confirm_password_err=$email_err=$address_err=$dob_err=$age_err=$blood_err="";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(!empty($_POST['name']))
  {
    $name=$_POST['name'];
  }else {
    $name_err="Enter Your Name";
  }

  if(!empty($_POST['email']))
  {
    $email=$_POST['email'];
  }else {
    $email_err="Enter Your Email ID";
  }

  if(!empty($_POST['address']))
  {
    $address=$_POST['address'];
  }else {
    $address_err="Enter Your Address";
  }

  if(!empty($_POST['dob']))
  {
    $dob=$_POST['dob'];
  }else {
    $dob_err="Enter Your Date Of Birth";
  }

  if(!empty($_POST['blood']))
  {
    $blood=$_POST['blood'];
  }else {
    $blood_err="Select Your Blood Group";
  }

  // Validate password
  if(empty(trim($_POST['password']))){
      $password_err = "Please enter a password.";
  } elseif(strlen(trim($_POST['password'])) < 6){
      $password_err = "Password must have atleast 6 characters.";
  } else{
      $password = trim($_POST['password']);
  }

  // Validate confirm password
  if(empty(trim($_POST["confirm_password"]))){
      $confirm_password_err = 'Please confirm password.';
  } else{
      $confirm_password = trim($_POST['confirm_password']);
      if($password != $confirm_password){
          $confirm_password_err = 'Password did not match.';
      }
    }
    if(empty($name_err) && empty($password_err) && empty($confirm_password_err) &&empty($email_err) &&empty($address_err) &&empty($dob_err) &&empty($blood_err)){
      //Prepare password hash
      $param_password="";
      $param_password = md5($password);

      //Push to Database
      require_once 'include/db.php';
      $patient_id=$_SESSION['patient_id'];
      $sql="UPDATE patient SET name='$name',email='$email',address='$address',dob='$dob',blood_group='$blood',password='$param_password',proflag='1' WHERE patient_id='$patient_id'";
      if(mysqli_query($db,$sql))
      {
        header("Location:dashboard.php");
      }
}
else {
  echo "Error";
}

}



 ?>


 <html>
 <head>
   <title>
     Update Profile
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
 <script type="text/javascript" src="js/date.js"></script>
</head>
 <body>

   <div class="container">
     <!-- Content here -->
     <div class="row">
       <div class="col-md-3">
        </div>
        <div class="col-md-6">
    <h3>Complete Your Profile</h3>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                  <label>Name</label>
                  <input type="text" placeholder="Full Name" name="name" class="form-control" value="<?php echo $name; ?>">
                  <span class="text-danger"><?php echo $name_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label>Password</label>
                  <input type="password" name="password" placeholder="Password"class="form-control" value="<?php echo $password; ?>">
                  <span class="text-danger"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" value="<?php echo $confirm_password; ?>">
                  <span class="text-danger"><?php echo $confirm_password_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                  <label>E-Mail</label>
                  <input type="email" placeholder="E-Mail" name="email" class="form-control" value="<?php echo $email; ?>">
                  <span class="text-danger"><?php echo $email_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                  <label>Address</label>
                  <input type="text" placeholder="Address" name="address" class="form-control" value="<?php echo $address; ?>">
                  <span class="text-danger"><?php echo $address_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>">
                  <label>Date of Birth</label>
                  <smallclass="form-text text-muted"> - in the format of DD/MM/YYYY</small>
                  <input class="form-control"  type="date" name="dob" id="dob" onblur="date()" value="<?php echo $dob; ?>"/>
                  <span class="text-danger"><?php echo $dob_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                  <label>Age</label>
                  <input class="form-control"  type="text" disabled="disabled" id="age">
                  <span class="text-danger"><?php echo $age_err; ?></span>
              </div>

              <div class="form-group <?php echo (!empty($blood_err)) ? 'has-error' : ''; ?>">
                  <label>Blood Group</label>
                  <select class="form-control" name="blood">
                    <option disabled selected>Your Blood Group</option>
                    <option value="A+">A Positive</option>
                    <option value="A-">A Negative</option>
                    <option value="B+">B Positive</option>
                    <option value="B-">B Negative</option>
                    <option value="AB+">AB Positive</option>
                    <option value="AB-">AB Negative</option>
                    <option value="O+">O Positive</option>
                    <option value="O-">O Negative</option>
                    <option value="XXX">I Dont Know</option>
                  </select>
 <span class="text-danger"><?php echo $blood_err; ?></span>
              </div>

              <div class="form-group">
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
