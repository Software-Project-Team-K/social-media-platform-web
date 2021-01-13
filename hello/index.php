<?php
        require "../assets/classes.php";
        include ('config.php');
        session_start();
        if(isset($_SESSION['user']) && !isset($_SESSION['success']))header("location: ../");
        if(isset($_SESSION['admin']))header("location: ../admin.php");
        if(isset($_SESSION['validator']))unset($_SESSION['validator']);


//Include Configuration File

if(isset($_GET["code"]))
{
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
 if(!isset($token['error']))
 {
  $google_client->setAccessToken($token['access_token']);
  $_SESSION['access_token'] = $token['access_token'];
  $google_service = new Google_Service_Oauth2($google_client);
  $data = $google_service->userinfo->get();
  if(!empty($data['id']))
  {
    $_SESSION['google_id'] = $data['id'];
    header("Location: ../assets/operation/login.php");
  }
 }
}   

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 $login_button = '<a href="'.$google_client->createAuthUrl().'"><img style="width:130px; border-radius:10px;" src="http://localhost/social-media-platform-web/assets/img/google_logo.png" /></a>';
}
?>

<!DOCTYPE html>
<html>
    
    <head>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
  

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chatverse | Hello!</title>
        <link rel="stylesheet" href="main.css">
        <link rel="icon" href="../assets/img/icn_logo.png">
    </head>
    
    <body id="body">
            <?php 
            if(isset($_SESSION['success'])){
            echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
            $("#body").fadeOut(400,function(e){location.replace("../")});
            $("body").css({"overflow":"hidden"});
            </script>
            ';
            }
            ?>

            <div class ="fulllogo">
                <img src="../assets/img/icn_logo.png">
                <div class="logotxt" >
                    <p id="logo">Chatverse</p>
                    <p>Welcome to your mini-world!</p>
                    <p>modern social platform.</p>
                </div>
            </div>
                       
                <div class="fullbox">
            
                    <div id="switchbar">
                        <div style="border-right: gray 3px solid;"><p id="slogin">Login</p></div><div><p id="sreg">Register</p></div>
                    </div>

                   <div>

                        <div>
                        <p id="errMsg" style ="height: 10px; margin-top:10px; text-align:center; color:orange; font-family:monospace; font-size:90%; font-weight:bolder; <?php if($_SESSION['color']=="green") echo 'color:rgb(0,255,0);';  else if($_SESSION['color']=="red")  echo 'color:rgb(255,0,0);';  ?>">
                           <?php if(isset($_SESSION['msg']))echo $_SESSION['msg']; else echo'Welcome! Please Login to Enter.'; unset($_SESSION['msg']);  unset($_SESSION['color']); ?> 
                        </p>        
                        </div>


                    <form id="login" method="POST" action="../assets/operation/login.php">           
                        <p>Email | ID:</p>  <input class="log" type="text" placeholder="Enter Email/ID or Phone" name="logID">
                        <p>Password:</p>    <input class="log" type="password" placeholder="Enter Password" name="password">
                        <?php echo '<div style="clear:left; display:inline-block; width:40%; position:relative; top:15px;">'.$login_button . '</div>'; ?>  
                        <input class="next" type="submit" value="Login" disabled>  
                    </form>
                    
                    <form id="register" method="POST" action="../assets/operation/register.php" style="display: none;" >
                        <p>Full Name:</p>
                        <div style="float: right; margin: 15px 0; height: 20px; padding: 0; width: 50%;">
                        <input type="text" name="f_name" class="reg"  onblur="checker(this.value,this.name)" placeholder="Firstname" style="width: 50%; height:100%;"><input type="text" class="reg" name="l_name" onblur="checker(this.value,this.name)" placeholder="Lastname" style="width: 50%;height:100%;"></div>
                        <p>Email address:</p><input  type="email" id="x1" disabled class="reg" onblur="checker(this.value,this.name)" name="email" placeholder="Enter Email">
                        <p>Password:</p><input  type="password" id="x2" disabled class="reg" onblur="checker(this.value,this.name)" name="password" placeholder="Enter Password">
                        <p>RE-Enter Password:</p><input type="password" class="reg" onblur="checker(this.value,this.name)" name="password2" placeholder="Re-Enter Password">
                        <p>Phone Number:</p><input type="text" name="phone_num" class="reg" onblur="checker(this.value,this.name)" placeholder="Enter Mobile Number">
                        <p>Date of Birth:</p><input class="reg" onblur="checker(this.value,this.name)" name="birth_date" type="date">
                        <p>Select Gender:</p>
                        <div style="clear:right; text-align:right;padding:10px; width:90%;">
                        <input type="radio" id="male" name="gender" value="Male" checked="checked"><samp> Male &emsp;</samp>
                        <input type="radio" id="female" name="gender" value="Female"><samp> Female</samp>
                        </div>
                        <input class="next" type="submit" value="Register"> 

                    </form>
                    </div>
                </div>

              


        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
     


        $(function() {
        $("#slogin").click(function(event) {
        $("#register").css("display","none");
        $("#login").css("display","block");
        $("#errMsg").css("color","orange");
        document.getElementById("errMsg").innerHTML = "Welcome! Please Login to Enter.";
        });
                 
        $("#sreg").click(function(event) {
        $("#register").css("display","block");
        $("#login").css("display","none");
        $("#errMsg").css("color","yellow");
        $("#x1").prop('disabled', false);
        $("#x2").prop('disabled', false);
        document.getElementById("errMsg").innerHTML = "Please fill the data form to register!";
        });      
        });





        setInterval(function () {
            enableLog();
            enableReg();
        }, 50);

        function enableLog() {
           var next = document.getElementsByClassName("next");
           var values = document.getElementsByClassName("log");
           var disable = false;
           for(var i=0;i<values.length;i++){
               if(values[i].value=="")disable=true;
           }
            next[0].disabled = disable;
            if(next[0].disabled == false){
                next[0].style.color="white";
                next[0].style.textShadow= "3px 3px 7px indigo" ;
                next[0].style.cursor="pointer";
                next[0].style.border="2px rgb(0,255,0) solid";
            }
            else{
                next[0].style.color="rgb(220, 170, 255)";
                next[0].style.textShadow= "0px 0px 0px indigo" ;
                next[0].style.cursor="not-allowed";
                next[0].style.border="2px rgb(255,0,0) solid";
            }
        }

        function enableReg() {
           var next = document.getElementsByClassName("next");
           var values = document.getElementsByClassName("reg");
           var disable = false;
           for(var i=0;i<values.length;i++){
               if(values[i].value=="")disable=true;
           }
           openButton(disable,next);
           if(next[1].disabled == false){
                next[1].style.color="white";
                next[1].style.textShadow= "3px 3px 7px indigo" ;
                next[1].style.cursor="pointer";
                next[1].style.border="2px rgb(0,255,0) solid";
            }
            else{
                next[1].style.color="rgb(220, 170, 255)";
                next[1].style.textShadow= "0px 0px 0px indigo" ;
                next[1].style.cursor="not-allowed";
                next[1].style.border="2px rgb(255,0,0) solid";
            }

        }

        function openButton(disable,next){
            if(disable==false){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) next[1].disabled = (this.responseText == "true")};
            xmlhttp.open("GET", "../assets/operation/lock_register.php", true);
            xmlhttp.send();
            }
            else {
                next[1].disabled = true;
            }
        }

        function checker(str,type) {
            document.getElementById("errMsg").style.color = "orangered";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) document.getElementById("errMsg").innerHTML = this.responseText;
            };
            xmlhttp.open("GET", "../assets/operation/register.php?q=" + str+"&t="+type, true);
            xmlhttp.send();
        }
        </script>
        
    </body>  
</html>
            