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

 $id=$_SESSION['patient_id'];
 echo "HELLO, Welcome to Dhanvantari Dental Care";


  ?>
