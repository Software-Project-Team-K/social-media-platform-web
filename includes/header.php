<?php
require 'config/config.php';
if(isset($_SESSION['username']))
{
    $userloggedin=$_SESSION['username'];
    $userloggedin_query=mysqli_query($con, "SELECT * FROM users WHERE username='$userloggedin' ");
    $user= mysqli_fetch_array($userloggedin_query);
}
else
{
    header("Location: register.php");
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>alaa</title>
    <!-- js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
<!-- css-->
<!-- font awesom for icons-->
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> 
    <link rel="stylesheet" type=text/css href="styling/bootstrap.css">
    <link rel="stylesheet" type=text/css href="styling/style.css">
   
</head>
<body>
   <div class="top_bar">
        <div class="logo">
            <a href= "index.php">Alaa!</a>
        </div>
        <nav>
            <a href="profile.php">
           <?php echo $user['first_name'];?> 
            </a>
            <a href="index.php">
            home
            </a>
            <!-- try to find the icons 
            <a href="index.php">
            <i class="icon-camera-retro icon-large"></i> 
            </a> -->
            <a href="#">
            messages
            </a>
            <a href="#">
            users    
            </a>
            <a href="#">
            notifications
            </a>
            <a href="#">
            settings   
            </a>
            <a href="includes/handlers/logout.php">
            logout    
            </a>
        </nav>
   </div>
   <div class="wrapper ">