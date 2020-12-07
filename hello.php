<?php

        session_start();
        if(isset($_SESSION['user']))header("location: index.php");
        if(isset($_SESSION['validator']))unset($_SESSION['validator']);

?>

<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Silvaro | Hello!</title>
        <link rel="stylesheet" href="hello.css">
        <link rel="icon" href="logo.png">
    </head>
    
  
    <body>

        
            
            <div class ="fulllogo">
                <img src="logo.png">
                <div class="logotxt" >
                    <p id="logo">Silvaro</p>
                    <p>Welcome to your mini-world!</p>
                    <p>simple social platform.</p>
                </div>
            </div>
                       
                <div class="fullbox">
            
                    <div id="switchbar">
                        <div style="border-right: darkblue 1px solid;"><p id="slogin">Login</p></div><div><p id="sreg">Register</p></div>
                    </div>

                   <div>

                        <div>
                        <p id="errMsg" style ="height: 12px; text-align:center; <?php  if($_SESSION['color']=="green") echo "color:green;"; else echo "color:red;" ?> font-family:monospace; font-weight:bolder;">
                           <?php if(isset($_SESSION['error']))echo $_SESSION['error']; unset($_SESSION['error']);  unset($_SESSION['color']); ?>
                        </p>        
                        </div>


                    <form id="login" method="POST" action="h_login.php">           
                        <p>Email/Username:</p>  <input class="log" type="text" placeholder="Enter Email or User" name="logID">
                        <p>Password:</p>    <input class="log" type="password" placeholder="Enter Password" name="password">
                        <input class="next" type="submit" value="Login" disabled>  
                    </form>
                    
                    <form id="register" method="POST" action="h_register.php" style="display: none;" >
                        <p>Full Name:</p>
                        <div style="float: right; margin: 15px 0; height: 20px; padding: 0; width: 50%;">
                        <input type="text" name="f_name" class="reg"  onblur="checker(this.value,this.name)" placeholder="Firstname" style="width: 50%;"><input type="text" class="reg" name="l_name" onblur="checker(this.value,this.name)" placeholder="Lastname" style="width: 50%;"></div>
                        <p>Email address:</p><input  type="email" class="reg" onblur="checker(this.value,this.name)" name="email" placeholder="Enter Email">
                        <p>Password:</p><input  type="password" class="reg" onblur="checker(this.value,this.name)" name="password" placeholder="Enter Password">
                        <p>RE-Enter Password:</p><input type="password" class="reg" onblur="checker(this.value,this.name)" name="password2" placeholder="Re-Enter Password">
                        <p>Phone Number:</p><input type="text" name="phone_num" class="reg" onblur="checker(this.value,this.name)" placeholder="Enter Mobile Number">
                        <p>Date of Birth:</p><input class="reg" type="date">
                        <input class="next" type="submit" value="Register">  
                    </form>
                    </div>
                </div>

                

              


        
        <script type="text/javascript" src="jquery.js"></script>
        <script>
     


        $(function() {
        $("#slogin").click(function(event) {
        $("#register").css("display","none");
        $("#login").css("display","block");
        $("#errMsg").css("color","red");
        document.getElementById("errMsg").innerHTML = "</br>";
        });
                 
        $("#sreg").click(function(event) {
        $("#register").css("display","block");
        $("#login").css("display","none");
        $("#errMsg").css("color","red");
        document.getElementById("errMsg").innerHTML = "</br>";
        });      
        });

        setInterval(function () {
            enableLog();
            enableReg();
        }, 100);

        function enableLog() {
           var next = document.getElementsByClassName("next");
           var values = document.getElementsByClassName("log");
           var disable = false;
           for(var i=0;i<values.length;i++){
               if(values[i].value=="")disable=true;
           }
           
            next[0].disabled = disable;
        }

        function enableReg() {
           var next = document.getElementsByClassName("next");
           var values = document.getElementsByClassName("reg");
           var disable = false;
           for(var i=0;i<values.length;i++){
               if(values[i].value=="")disable=true;
           }
           openButton(disable,next);
        }

        function openButton(disable,next){
            if(disable==false){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) next[1].disabled = (this.responseText == "true"); };
            xmlhttp.open("GET", "button_register.php", true);
            xmlhttp.send();
            }
            else 
            next[1].disabled = true;
        }

        function checker(str,type) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) document.getElementById("errMsg").innerHTML = this.responseText;
            };
            xmlhttp.open("GET", "h_register.php?q=" + str+"&t="+type, true);
            xmlhttp.send();
        }
        </script>
        
    </body>  
</html>
            