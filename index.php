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
                                <title>Chatverse | Newsfeed</title>
                                <link rel="icon" href="assets/img/icn_logo.png">
            
                                 <!--Navigation Bar-->
                                 <div id="nav">
                                    <a href=""><img src="assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                    <input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
                                        <div id="navbuttons">
                                                <button><a href='.$_SESSION["user"]->get_id().'><img src="'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                                <button><img src="assets/img/icn_msg.png"></button>
                                                <button><img src="assets/img/icn_notification.png"></button>
                                                <button id="arrow"><img src="assets/img/icn_settings.png"></button>
                                                <ul id="menu">
                                                        <li><a href="settings">Account Settings</li>
                                                        <li><a href="assets/operation/logout.php">Logout</a></li>
                                                </ul>
                                            </div> 
                                        </div>
                                <div style="height:40px; background-color: white;"></div>
                                <script>
                                var arrow = document.getElementById("arrow");
                                var menu = document.getElementById("menu");  
                                arrow.onclick = function() {
                                    if(menu.style.display == "block")menu.style.display = "none"
                                    else menu.style.display = "block";}
                                 </script>
                            </head>
                        <body>'
?>



















    </body>  
</html>
            