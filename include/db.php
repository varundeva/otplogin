<?php
   $dbhost = 'localhost';
   $dbuser = 'root';
   $dbpass = '';
   $dbname = 'clinic';
   $db = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

   if(! $db ) {
      die('Could not connect: ' . mysqli_error());
   }
?>
