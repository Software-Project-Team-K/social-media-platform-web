<?php 
            require '../assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: ../");
            
            //refetch the data
            $_SESSION['user'] = new user($_SESSION['user']->get_id());
            if(isset($_SESSION['user']) && strlen($_SESSION['user']->get_id())==0) header("location: ../assets/operation/logout.php");


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
                                   <div class="searchUnit" style="text-align:center; width:100%;">
                                   <samp style="color:brown;"> Results will be shown here.</samp></div>
                                   <div style="text-align:center; border:0;">
                                   <img style="width:50%; margin:0 10%; height:130px; border:0;" src="http://localhost/social-media-platform-web/assets/img/icn_search.png"></div>
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
                                                       <li><a href="../saved">Saved Posts</li>
                                                       <li><a href="../assets/operation/logout.php">Logout</a></li>
                                               </ul>
                                           </div> 
                                       </div>
                               <div style="height:40px; background-color: white;"></div>

         
                               <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                               <script>
                               var arrow = document.getElementById("arrow");
                               var notiBtn = document.getElementById("notiBtn");

                               var menu = document.getElementById("menu");  
                               var noti = document.getElementById("noti");
                               arrow.onclick = function() {
                                   $("#menu").slideToggle();
                               }
                               notiBtn.onclick = function() {
                                   if(noti.style.display == "block")$("#noti").slideUp();
                                   else {
                                       var xhttp = new XMLHttpRequest();
                                       xhttp.onreadystatechange = function() {
                                         if (this.readyState == 4 && this.status == 200) {
                                          document.getElementById("noti_img").src = "../assets/img/icn_notification.png";
                                         }
                                       };
                                       xhttp.open("GET","assets/operation/db_update.php");
                                       xhttp.send();
                                       $("#noti").slideDown();
                                   }
                               }


        

                               /////////

                               var searchBar = document.getElementById("searchbar");
                               var searchBox = document.getElementById("searchbox");
                               searchBar.onfocus= function(){
                                   $("#searchbox").slideDown();
        
                               }
                               searchBar.onblur= function(){
                                   myVar = setInterval(function () {
                                       $("#searchbox").slideUp();
                                       clearInterval(myVar);
                                   }, 200);
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
    $_SESSION['g'] = $_SESSION['user']->link_google($data['id']);
   $google_client2->revokeToken();
   unset($_SESSION['access_token']);
  }
 }
}   
?>
<div style="width:10%; display:inline-block; background-color:rgba(220,220,220,0.5); border-right:2px solid indigo; border-bottom:2px solid indigo; padding:0 15px 15px 15px; border-radius:0 0 50px 0; vertical-align:top; text-align:center;">
<h3 style="color:white; background-color:rgba(160,50,180,0.5); border:1px solid indigo; border-radius:5px">Account Settings</h3>
<img style="width:100%;" src="../assets/img/acc_settings.png">
</div>
<div class="wrapper">

                    <?php if(isset($_SESSION['g'])){
                    echo '<h2 class="header" style="color:orange; background-color:whitesmoke;">
                        '.$_SESSION['g'].'
                    </h2>'; unset($_SESSION['g']);}
                    ?>
                    <h4 class="header">
                        General Settings
                    </h4>
                                <form id="change0" class="column" method="POST" action="../assets/operation/change_settings.php">
                                    <div class="form-group">
                                        <label class="form-label">First Name:</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="<?php echo $_SESSION["user"]->get_f_name();?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Last Name:</label>
                                        <input type="text" name="last_name" class="form-control" placeholder="<?php echo $_SESSION["user"]->get_l_name();?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail:</label>
                                        <input type="text" name="email" class="form-control mb-1" placeholder="<?php echo $_SESSION["user"]->get_email();?>">
                                    </div>
                                    <input type="hidden" name="operation" value="email">
                                    <input type="submit" name="update_details" value="Save Changes"class="submission">
                                </form>
                    <h4 class="header">
					    Password Change
					</h4>
                                <form class="column" id="change1" method="POST" action="../assets/operation/change_settings.php">
                                    <div class="form-group">
                                        <label class="form-label">Current password:</label>
                                        <input type="password" name="current_pass" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">New password:</label>
                                        <input type="password" name="new_pass" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Repeat new password:</label>
                                        <input type="password" name="new_pass2" class="form-control">
                                    </div>
                                    <input type="hidden" name="operation" value="pass">
                                    <input type="submit" name="update_password" value="Save Changes"class="submission">
                                </form>
                        <h4 class="header">
						    Change Phone Number
						</h4>
                                <form class="column" id="change2" method="POST" action="../assets/operation/change_settings.php">
                                    <div class="form-group">
                                        <label class="form-label">New Number:</label>
                                        <input type="text" name="new_number" class="form-control" value="">
                                    </div>
                                    <input type="hidden" name="operation" value="phone_number">
                                    <input type="submit" name="update_phone" value="Save Changes"class="submission">
                                </form>
                        <h4 class="header">
					        Privacy Settings
                        </h4>
                                <form class="column" id="change3" method="POST" action="../assets/operation/change_settings.php">     
                                    <div class="form-group">
                                        <label class="form-label">Enable Market ?</label>
                                        <?php 
											if($_SESSION['user']->get_market_statues() == '0'){
												echo'<input type="checkbox" name="check2" value="1">';
											}
											else
											{
											    echo'<input type="checkbox" checked name="check2" value="1">';
											}
										?>
                                    </div>
                                    <input type="hidden" name="operation" value="check">
                                    <input type="submit" name="checkboxes" value="Save Changes"class="submission">
                                </form> 
                        <h4 class="header">
					        Associate Google Credentials
                        </h4>
                                <div class="column" style="width:25%;">     
                                        <?php /////GOOOOOOOOOOOOGLEEEEEEE 
                                        //This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
                                        if(!isset($_SESSION['access_token']))
                                        {
                                        echo $login_button = '<a onclick="g()" style="margin: auto 0;"  href="'.$google_client2->createAuthUrl().'"><img style="width:80px; border-radius:10px;" src="http://localhost/social-media-platform-web/assets/img/google.png" /></a>';
                                        }
                                        ?>
                                </div>
   
    </div>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript">

        var frm0 = $('#change0');
        frm0.submit(function (e) {

            e.preventDefault();

            $.ajax({
                type: frm0.attr('method'),
                url: frm0.attr('action'),
                data: frm0.serialize(),
                success: function (data) {
                    console.log('Submission was successful.');
                    alert(data);
                },
                error: function (data) {
                    console.log('An error occurred.');
                    alert(data);
                },
            });
        });
        var frm1 = $('#change1');
        frm1.submit(function (e) {

            e.preventDefault();

            $.ajax({
                type: frm1.attr('method'),
                url: frm1.attr('action'),
                data: frm1.serialize(),
                success: function (data) {
                    console.log('Submission was successful.');
                    alert(data);
                },
                error: function (data) {
                    console.log('An error occurred.');
                    alert(data);
                },
            });
        });
        var frm2 = $('#change2');
        frm2.submit(function (e) {

            e.preventDefault();

            $.ajax({
                type: frm2.attr('method'),
                url: frm2.attr('action'),
                data: frm2.serialize(),
                success: function (data) {
                    console.log('Submission was successful.');
                    alert(data);
                },
                error: function (data) {
                    console.log('An error occurred.');
                    alert(data);
                },
            });
        });
        var frm3 = $('#change3');
        frm3.submit(function (e) {

            e.preventDefault();

            $.ajax({
                type: frm3.attr('method'),
                url: frm3.attr('action'),
                data: frm3.serialize(),
                success: function (data) {
                    console.log('Submission was successful.');
                    alert(data);
                },
                error: function (data) {
                    console.log('An error occurred.');
                    alert(data);
                },
            });
        });

        </script>


    </body>  
</html>
            