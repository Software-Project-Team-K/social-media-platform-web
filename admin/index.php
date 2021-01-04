<?php 
            require '../assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: ../");
            $_SESSION['user']=new user($_SESSION['user']->get_id());
        
            echo '
                 <!DOCTYPE html>
                    <html>
                        <head>
                                <link rel="stylesheet" href="main.css">
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Chatverse | Account Settings</title>
                                <link rel="icon" href="../assets/img/icn_logo.png">
            
                                <!--Navigation Bar-->
                                <div id="nav">
                                   <a href="../"><img src="../assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                   
                                   
                                   <form>
                                   <input type="text" id="searchbar">
                                   </form><button type="submit"><img style="width:12px; padding:0; margin:0;" src="../assets/img/icn_search.png"></button>
                                   <div id="searchbox">
                                   <div class="searchUnit">
                                   <samp>Search Results will be shown here!</samp>
                                   </div>
                                   </div>
                                   
                                   
                                   <div id="navbuttons">
                                               <button><a href="../'.$_SESSION["user"]->get_id().'"><img src="../'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                               <button><img src="../assets/img/icn_msg.png"></button>
                                               <button id="notiBtn"><img id="noti_img" src="../assets/img/icn_notification'.$_SESSION["user"]->get_noti_statues().'.png"></button>
                                               <button id="arrow"><img src="../assets/img/icn_settings.png"></button>
                                               <div id="noti">';
                                               $noti = new notification($_SESSION['user']->get_id());
                                               $noti->get_noti(); 
                                               echo '</div>
                                               
                                               <ul id="menu">
                                                       <li><a href="../settings">Settings</li>
                                                       <li><a href="../assets/operation/logout.php">Logout</a></li>
                                               </ul>
                                           </div> 
                                       </div>
                               <div style="height:40px; background-color: white;"></div>

         
                               <script>
                               var arrow = document.getElementById("arrow");
                               var notiBtn = document.getElementById("notiBtn");

                               var menu = document.getElementById("menu");  
                               var noti = document.getElementById("noti");
                               arrow.onclick = function() {
                                   if(menu.style.display == "block")menu.style.display = "none"
                                   else menu.style.display = "block";}
                               notiBtn.onclick = function() {
                                   if(noti.style.display == "block")noti.style.display = "none"
                                   else {

                                       var xhttp = new XMLHttpRequest();
                                       xhttp.onreadystatechange = function() {
                                         if (this.readyState == 4 && this.status == 200) {
                                          document.getElementById("noti_img").src = "../assets/img/icn_notification.png";
                                         }
                                       };
                                       xhttp.open("GET","../assets/operation/db_update.php");
                                       xhttp.send();
                                       noti.style.display = "block";
                                   }
                               }

                               /////////

                               var searchBar = document.getElementById("searchbar");
                               var searchBox = document.getElementById("searchbox");
                               searchBar.onfocus= function(){
                                   searchBox.style.display = "block";
                               }
                               searchBar.onblur= function(){
                                   myVar = setInterval(function () {
                                       searchBox.style.display = "none";
                                       clearInterval(myVar);
                                   }, 100);
                               }


                               searchBar.oninput=function(){
                               var xhttp = new XMLHttpRequest();
                               xhttp.onreadystatechange = function() {
                                 if (this.readyState == 4 && this.status == 200) {
                                   searchBox.innerHTML = this.responseText;
                                 }
                               };
                               xhttp.open("GET","../assets/operation/search.php?index=" + searchBar.value);
                               xhttp.send();
                               }


                               </script>


                            </head>
                        <body>'
?>


<!--GOOOOGLE-->
<?php     
include ('../hello/config.php');
if(isset($_GET["code"]))
{
 $token = $google_client2->fetchAccessTokenWithAuthCode($_GET["code"]);
 if(!isset($token['error']))
 {
  $google_client2->setAccessToken($token['access_token']);
  $_SESSION['access_token'] = $token['access_token'];
  $google_service = new Google_Service_Oauth2($google_client2);
  $data = $google_service->userinfo->get();
  if(!empty($data['id']))
  {
   $_SESSION['user']->link_google($data['id']);
   $google_client2->revokeToken();
   unset($_SESSION['access_token']);
  }
 }
}   
//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 echo $login_button = '<a style="position:relative; left:10%; top:100px;" href="'.$google_client2->createAuthUrl().'"><img style="width:100px; border-radius:10px;" src="http://localhost/social-media-platform-web/assets/img/google.png" /></a>';
}
?>

<?php 
if($_SESSION['user']->get_market_statues() == '0'){
echo'
    <form  method="POST" action="../assets/operation/db_update.php">
    <input type="submit" name="submit" value="Enable Market"> 
    </form>';
}
else
{
    echo'
    <form  method="POST" action="../assets/operation/db_update.php">
    <input type="submit" name="submit" value="Disable Market"> 
    </form>';
}



?>


    </body>  
</html>
            