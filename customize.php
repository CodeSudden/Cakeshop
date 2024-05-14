<?php
session_start();
include 'components/connect.php';

if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header('location: login.php');
    exit(); // Make sure to exit after redirecting
}

// Now you can access $_SESSION['user_id'] to get the logged-in user ID
$user_id = $_SESSION['user_id'];

// Your existing code for handling orders, checkout, etc. goes here
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale= 1.0">
    <link rel="stylesheet" type="text/css" href="css/user_style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Cake Bliss - Home Page</title>



</head>
<body>

<?php include 'components/user_header.php';?>
   
  <body id="markers-on-the-map">
    
  <!-- <div class="cake-container" style="justify-content: center;"> -->
      <?php 
      include 'cake2.php'
      ?>
<!-- </div> -->
    <script type="text/javascript" src='demo.js'></script>
  </body>
</html>


<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>

    <?php include 'components/alert.php'; ?>
