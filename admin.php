<?php 
            require 'assets/classes.php';
            session_start();
            if(!isset($_SESSION['admin']))header("location: settings/../");
            $_SESSION['admin'] = new admin($_SESSION['admin']->get_username());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chatverse | Control Room</title>
        <link rel="icon" href="assets/img/icn_logo.png">
        <style>

            body{
                margin: 0;
                background-image: url(assets/img/control.jpg);
                background-size: cover;
            }
            *{
                box-sizing: border-box;
            }
            .block{
                width:35%; 
                height:auto; 
                display:inline-block;
                border:5px solid indigo; 
                background-color: whitesmoke;
                border-radius:15px; 
                margin:0 5%;
                vertical-align:top;
                text-align:center;
            }
            #rank{
                width:30%; 
                margin:15px auto;
                color:indigo;
                font-size:125%; 
                text-decoration:underline;
                font-weight:bold;
            }
            .data{
                width:100%;
                height:50px;
                border-bottom:1px solid brown;
                text-align:left;
            }
            .data img{
                width:15%;
                height:80%;
                display: inline-block;
                vertical-align:top;
                margin:5px 15px 0 5px;

            }
            .data p{
                display: inline-block;
                width:70%;
                font-weight:bold;
                font-style:italic;
                font-size:100%;
            }
            .data samp{
                display: inline-block;
                font-weight:bolder;
                font-size:110%;
                color:blue;
            }



        </style>
    </head>

    <body id="body">

    <div style="width:40%; background:whitesmoke; margin:0 auto 30px auto; padding:10px 5px; text-align:left; border:3px solid gray; border-top:0; border-radius:0 0 100px 100px;"><a href="assets/operation/logout.php" style="float:right; border:black 2px solid; background-color:indigo; color:white; text-decoration:none; pointer:cursor; border-radius:10px; margin:5px; padding:5px; font-size:120%;">Logout</a>
    <h3 style="margin:5px; color:royalblue;">Chatverse Control Room</h3>
    <img style="width:100px; display:inline-block; vertical-align:middle; margin: 5px 50px; background-color:indigo; border:3px brown solid; border-radius:20px;" src="assets/img/icn_logo.png"><p style="display:inline-block; font-size:120%; color:darkblue;">Welcome <?php echo $_SESSION['admin']->get_name()." - (".$_SESSION['admin']->get_control_type().")"; ?></p>
    </div>

    <div class="block" id="analysis" <?php if($_SESSION['admin']->get_control_type()=='Tracker') echo 'style="display:none;"'; ?>>
            <img style="width:20%;" src="assets/img/analyst.png">
            <p id="rank">Data Analysis</p>
            <samp style="font-size:110%; color:royalblue; margin: 0 10px;">Trends In The last (x) Days:</samp><input id="time" type="number" placeholder="Enter (X) Days" oninput="get_trends(this.value)" style="margin-bottom:10px; width:40%; color:green; border-radius:5px;"><br>
            <div id="status" style="display:inline-block; padding:5px; width:50%; border:2px solid black; "></div><div 
            id="trends" style="display:inline-block; text-align:left; border:2px solid black; border-left:0; vertical-align:top; padding:5px; width:50%;">
            <p style="width:100%; text-align:center;">Trends will appear here!</p>
            </div>




    </div><div class="block" <?php if($_SESSION['admin']->get_control_type()=='Analyst') echo 'style="display:none;"'; ?> >
            <img style="width:20%;" src="assets/img/tracker.png">
            <p id="rank">System Tracking</p>
        <?php
            echo'

            <p style="width:30%; display:inline-block; font-weight:bolder;"> Enter Unit Pattern: </p><samp style="color: blue;">(U > [User] | G > [Group] | P > [Page]) + ID</samp>
            <input type="text" id="pattern" style="width:40%; margin:10px 20px;"><input type="button" id="delete" value="Ban" style="width:20%; color:red; border-radius:5px; margin:10px;";>';
        ?>

    </div>



    <script>

        var body = document.getElementById("body");
        var analysis = document.getElementById("status");
        var analysis2 = document.getElementById("trends");
        body.onload = function(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    analysis.innerHTML =  this.responseText;
                    }
                };
            xhttp.open("GET","assets/operation/admin.php?op=fetch");
            xhttp.send();
        }

        function get_trends(time){
            var xhttp2 = new XMLHttpRequest();
            xhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    analysis2.innerHTML = this.responseText;
                }
                };
            xhttp2.open("GET","assets/operation/admin.php?op=fetch2&time=" + time);
            xhttp2.send();
        }

        var pattern = document.getElementById("pattern");
        var ban = document.getElementById("delete");
        ban.onclick = function(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
                };
            xhttp.open("GET","assets/operation/admin.php?op=delete&id=" + pattern.value);
            xhttp.send();
        }

    </script>

    </body>  
</html>
            