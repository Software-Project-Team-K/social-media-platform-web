<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");
        
        
                echo '
                                <!DOCTYPE html>
                                <html>
        
                                <head>
                                    <link rel="stylesheet" href="../main.css">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Silvaro | '.$_SESSION["user"]->name().'</title>
                                    <link rel="icon" href="../assets/img/icn_logo.png">
        
                                    <!--Navigation Bar-->
                                    <div id="nav">
                                        <a href="../"><img src="../assets/img/icn_logo.png" style="width: 50px; height: 95%; margin: 0 15px;"></a>
                                        <input type="text" style="width:20%; position: relative; left:5px; bottom:15px;">
                                        <div id="navbuttons">
                  
                                            <button><a href=""><img src="../assets/default/default_pp.jpg"></a></button>
                                            <button><img src="../assets/img/icn_msg.png"></button>
                                            <button><img src="../assets/img/icn_notification.png"></button>
                                            <button><a href="../assets/operation/logout.php"><img src="../assets/img/icn_settings.png"></a></button>
                                        </div> 
                                    </div>
                                    <div style="height:45px; background-color: white;"></div>
        
                                </head>
        
                                <body>'
        
        
?>



        <div id="NCP">  

            <div id="cover">
                <img src="../assets/default/default_cover.jpg">
            </div>

            <div id="PNB">

                <div style="display: inline-block; margin: 0 5%;">
                    <img id="pp" src="../assets/default/default_pp.jpg">
                    <button><img src="../assets/img/icn_upload.jpg"></button>
                    <p><?php echo $_SESSION['user']->name(); ?></p>
                </div>

            </div>
        </div>



        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px royalblue solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px red solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px green solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px yellow solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px silver solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px blue solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px orange solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px purple solid;"></div>
        <div style="width:70%; margin: 50px 15%; height: 150px; border: 4px orchid solid;"></div>

        <!--
        <form action="../upload.php" method="post" enctype="multipart/form-data">
          Select IMG:
         <input type="file" name="fileToUpload" id="fileToUpload"><br></br>
         <input type="submit" value="Upload Image" name="submit">
        </form>
        -->
        
    </body>  
</html>