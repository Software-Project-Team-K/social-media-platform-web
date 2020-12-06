<?php
session_start();
if(isset($_SESSION['username']))header("location: index.php")
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

                       <p id="errMsg" style="text-align:center; color:red;"></p>           <!--   ///////////////// -->

                    <form id="login" method="POST" action="h_login.php">           
                        <p>Email/Username:</p>  <input  type="text" placeholder="Enter Email or User" name="logID">
                        <p>Password:</p>    <input  type="password" placeholder="Enter Password" name="password">
                        <input class="next" type="submit" value="Login">  
                    </form>
                    
                    <form id="register" method="POST" action="h_register.php" style="display: none;" >
                        <p>Full Name:</p>
                        <div style="float: right; margin: 15px 0; height: 20px; padding: 0; width: 50%;">
                        <input type="text" name="f_name" placeholder="Firstname" style="width: 50%;"><input type="text" name="l_name" placeholder="Lastname" style="width: 50%;"></div>
                        <p>Email address:</p><input  type="email" name="email" placeholder="Enter Email">
                        <p>Password:</p><input  type="password" name="password_c" placeholder="Enter Password">
                        <p>RE-Enter Password:</p><input type="password" name="password" placeholder="Re-Enter Password">
                        <p>Phone Number:</p><input type="text" name="phone_num" placeholder="Enter Mobile Number">
                        <p>Date of Birth:</p><input  type="date">
                        <input class="next" type="submit" value="Register">  
                    </form>
                    </div>
                </div>
    

        <script type="text/javascript" src="jquery.js"></script>
        <script>
        $(function() {
                 
        $("#slogin,#sreg").hover(function(event) {
        $(this).css("color","blue");},function(event) {
         $(this).css("color","royalblue"); 
        });

        $("input").hover(function(event) {
        $(this).css("border","2px solid blue");},function(event) {
         $(this).css("border","1px solid royalblue"); 
        });

        $("input").focus(function(event) {
        $(this).css("background-color","silver");
        });
     
        $("input").blur(function(){
         $(this).css("background-color", "white");
        });

        $("#slogin").click(function(event) {
        $("#register").css("display","none");
        $("#login").css("display","block");
        });
                 
        $("#sreg").click(function(event) {
        $("#register").css("display","block");
        $("#login").css("display","none");
        });      
        });





        </script>
        
    </body>  
</html>
            