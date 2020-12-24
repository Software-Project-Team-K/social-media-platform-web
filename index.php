    <?php 
            require 'assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: hello/");
        
        
            echo '
                 <!DOCTYPE html>
                    <html>
                        <head>
                                <link rel="stylesheet" href="main.css">
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Chatverse | Home</title>
                                <link rel="icon" href="assets/img/icn_logo.png">
            
                                 <!--Navigation Bar-->
                                 <div id="nav">
                                 <a href="../"><img src="assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                  <input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
                                        <div id="navbuttons">
                                                <button><a href='.$_SESSION["user"]->get_id().'><img src="'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                                <button><img src="assets/img/icn_msg.png"></button>
                                                <button><img src="assets/img/icn_notification.png"></button>
                                                <button onclick="toggle();"><img src="assets/img/icn_settings.png">
                                                    <div class="sub-menu-settings" style="display:none">
                                                            <ul>
                                                                <li><a href="settings/index.php">Settings</a></li>
                                                                <li><a href="assets/operation/logout.php">Logout</a></li>
                                                            </ul>
                                                        
                                                    </div> 
                                                </button>  
                                            </div> 
                                        </div>
                                <div style="height:40px; background-color: white;"></div>
                            </head>
                        <body>'
?>





    <script>
       function toggle(){
       var x = document.getElementsByClassName("sub-menu-settings")[0];
       if(x.style.display =="none")
       x.style.display = "block";
       else 
       x.style.display = "none";
        }
    </script>


    </body>  
</html>
            