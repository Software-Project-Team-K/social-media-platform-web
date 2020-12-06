<?php 
require 'connect.php';
session_start();
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Silvaro | <?php echo $_SESSION['username']; ?></title>
        <link rel="icon" href="../logo.png">
    </head>
    
  
    
    <body>
    <div style="position:relative; left:5%; width:90%; text-align:center; background-color:silver;">


    
        <P style="font-size:200%; color:green;"> <?php echo $_SESSION['realname']; ?></p>
        <div>
        <img src="pp.jpg" style="width: 50%;" alt="profile_pic">
        </div>
        <form action="../upload.php" method="post" enctype="multipart/form-data">
          Select IMG:
         <input type="file" name="fileToUpload" id="fileToUpload"><br></br>
         <input type="submit" value="Upload Image" name="submit">
        </form>
</br>
<p style="font-size:250%"><a href="../">Go To Home</a></p>
</div>
        
    </body>  
</html>