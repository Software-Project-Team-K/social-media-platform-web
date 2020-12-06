<?php 

        require 'classes.php';
        session_start();
        if(!isset($_SESSION['user']))header("location: hello.php");
?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Silvaro | Home!</title>
        <link rel="icon" href="logo.png">
    </head>
    
  
    
    <body>

        <div style="width:50%; position:relative; left:25%; text-align:center; font-size:200%; border: 2px green solid; background-color:silver;" >
        <p><?php echo  $_SESSION['user']->name(); ?></p>
        <p><a href="<?php echo  $_SESSION['user']->id() ?>">Visit Profile</a></p>
        <p><a href="logout.php">Logout</a></p>
        </div>
            
        
    </body>  
</html>
            