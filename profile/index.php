<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");
                $connect =new connection ;
                $con = $connect->conn;   
                $userloggedin= $_SESSION['user']->get_id();
               // $username = $_GET['profile_username'];
               if(isset($_GET['profile_username']))
                 {
                $username = $_GET['profile_username'];
                $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE id='$username'");

              if(mysqli_num_rows($user_details_query) == 0)
                     {
                        echo "User does not exist";
                        exit();
                    }
                }

                //aquire the usernames
                $user_id = $_SESSION['user']->get_id();
                $target_id = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],"/",1)+1);
                $target_id = strtolower(substr($target_id,0,strlen($target_id)-1));
                //refetch the data
                $_SESSION['user'] = new user($user_id);
                $_SESSION['target'] = new user($target_id);
                //check if the target is the user
                $isVisitor = TRUE;
                if($user_id == $target_id) $isVisitor = FALSE;
               

                



                
             echo '
                    <!DOCTYPE html>
                        <html>
        
                            <head>
                                    <link rel="stylesheet" type="text/css" href="../styling/style.css">
                                    <link rel="stylesheet" type=text/css href="../styling/bootstrap.css">
                                    <link rel="stylesheet" href="../profile/main.css">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Chatverse | '.$_SESSION["target"]->get_name().'</title>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                    <script src="../assets/js/bootstrap.js"></script>
                                    <script src="../assets/js/bootbox.min.js"></script>
                                    <link rel="icon" href="../assets/img/icn_logo.png">
        
                                    <!--Navigation Bar-->
                                    <div id="nav">
                                       <a href="../"><img src="../assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                       <input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
                                           <div id="navbuttons">
                                                   <button><a href="../'.$_SESSION["user"]->get_id().'"><img src="../'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                                   <button><img src="../assets/img/icn_msg.png"></button>
                                                   <button><img src="../assets/img/icn_notification.png"></button>
                                                   <button id="arrow"><img src="../assets/img/icn_settings.png"></button>
                                                   <ul id="menu">
                                                           <li><a href="../settings">Account Settings</li>
                                                           <li><a href="../assets/operation/logout.php">Logout</a></li>
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



        <div id="NCP">  
                <div id="cover">
                    <?php if(!$isVisitor) echo '<button id="coverBtn"><img src="../assets/img/icn_upload.png"></button>'?>
                    <img src=<?php echo "../".$target_id."/".$_SESSION['target']->get_cover_pic(); ?>>
                </div>
                <div id="PNB">
                    <div style="display: inline-block; margin: 0 5%;">
                        <img id="pp" src=<?php echo "../".$target_id."/".$_SESSION['target']->get_profile_pic(); ?>>
                        <?php if(!$isVisitor) echo '<button id="ppBtn"><img src="../assets/img/icn_upload.png"></button>' ;?>
                        <p><?php echo $_SESSION['target']->get_name(); ?></p>
                    </div>
                    <form id="buttons" method="GET" action="../assets/operation/friend_button.php">
                        <input  type="hidden" name = "target" value = "<?php echo $target_id ?>">
                        <?php
                        if($isVisitor){
                        if(friendship::isFriend($user_id,$target_id)) echo '<input type="submit" name="op" value="Unfriend">';
                        else if(friendship::isFrRequest($target_id,$user_id)) echo '<input type="submit" name="op" value="Accept"><input type="submit" name="op" value="Refuse">';
                        else if(!(friendship::isFrRequest($user_id,$target_id))) echo '<input type="submit" name="op" value="Add Friend">';
                        else echo '<input type="submit" name="op" value="Cancel Request">';}
                        ?>                                   
                    </form>
                </div>
        </div>



        <!-- User Details-->
        <div style="width:25%; margin: 20px 1%; height: 800px; display:inline-block; vertical-align:top;">

            <!-- user info section -->
                <div id="user_info" class="datablock">
                    <p>User Info</p>
                    <hr>
                    <div style="padding:0 10px;"> 
                        <p><samp>Bio: </samp>
                        <?php
                         echo $_SESSION['target']->get_bio();
                         if(!$isVisitor) echo '<button id="bioBtn" style="float:right; background-color:transparent; border:0px;"><img style="width:15px; height:15px;; margin:0;" src="../assets/img/edit_txt_icon.png"></button>';
                         ?></p>
                        <p><samp>Email: </samp><?php echo $_SESSION['target']->get_email()?> </p>
                        <p><samp>Phone: </samp><?php echo $_SESSION['target']->get_phone()?> </p>
                        <p><samp>Gender: </samp><?php echo $_SESSION['target']->get_gender()?> </p>
                        <p><samp>Birthdate: </samp>
                        <?php
                        $date=date_create($_SESSION['target']->get_birth_date());
                        echo date_format($date,"Y/m/d");
                        ?></p>
                     </div>
                </div>

            <!-- friends section -->
            <div id="friendsblock" class="datablock">
                <p>Friends  (<?php echo $_SESSION['target']->get_friends_no();?>)</p>
                <a href="">See More</a>
                <hr>
                <!-- friends units -->
                <div style="margin: 0 0 0 2%"> 
                <?php
                $friends = $_SESSION['target']->get_friends();
                $friends_no = $_SESSION['target']->get_friends_no();
                if($friends_no!=0){
                    $start = 0;
                    for($i=0; $i<6; $i++){
                    if($i == $friends_no) break;
                    $end = strpos($friends,",",$start + 1);
                    $friend = new user(substr($friends,$start,$end - $start));
                    $start = $end + 1;
                    echo'
                        <div class="friendunit">
                            <img src="../'. $friend->get_id()."/". $friend->get_profile_pic().'"><br>
                            <a href="../'.$friend->get_id().'">' . $friend->get_name() . '</a>
                        </div>';
                    }
                }
                else echo '<p style="text-align:center; font-size:150%; margin: 30px;">No Friends To Show</p>'
                ?>
                </div>
                <!-- any other section -->

            </div>

         </div>
  

        <!-- Posts Section-->
        <!--<div style="width:60%; margin: 20px 1%; height: 1000px; border: 2px black solid; display:inline-block;">-->
        
        <div class="main_column column">
        <div class="posts_area"></div>
        <img id="loading" src="../assets/img/loading.gif">
       <!-- <?php echo $target_id ?>-->
        
        

        </div>

<script>
//for infinite loading 
		var userloggedin ='<?php echo $userloggedin; ?>';
		var profileusername ='<?php echo $target_id; ?>';
		$(document).ready(function(){

			$('#loading').show(); //grbt a3mlha hide became hidden 3adi 
			// ajax for loading posts
			$.ajax({
				url:"../assets/operation/ajaxprofile.php",
				type:"POST",
				data:"page=1&userloggedin=" + userloggedin +"&profileusername=" + profileusername,
				cache:false,
// data msh bt success msh byd5ol hna asln 
				success:function(data)
				{
					$('#loading').hide(); //dont show loading sign again 
					$('.posts_area').html(data);
				}
			});  //end of ajax
		$(window).scroll(function(){
		var height=$('.posts_area').height(); //div containing posts
		var scroll_top=$(this).scrollTop();
		var page=$('.posts_area').find('.nextpage').val();//   created int post class
		var nomoreposts=$('.posts_area').find('.nomoreposts').val();
		//alert("hello");

		// function to scroll to the bottom //rl moshkla msh radi yd5ol  el if aslnn
		if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && nomoreposts=='false')
		{
			
			$('#loading').show();
			alert("hello");
			var ajaxReq = $.ajax({
			url:"../assets/operation/ajaxprofile.php",
			type:"POST",
			data:"page=" + page + "&userloggedin=" + userloggedin +"&profileusername=" +profileusername,
			cache:false,

				success:function(response)
				{
					$('.posts_area').find('.nextpage').remove();
					$('.posts_area').find('.nomoreposts').remove();

					$('#loading').hide();
					$('.posts_area').append(response);//add new posts to the existing posts
				}
			});  

		}//end if

		return false;


		});//end $(window).scroll(function(){*/



		});

	</script>
    
        







        <div id="uploadPPBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/upload_pic.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="pp">
                    <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
                </form>
            </div>
        </div>

        <div id="uploadCoverBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/upload_pic.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="cover">
                    <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
                </form>
            </div>
        </div>
        <div id="uploadBioBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/update_bio.php" method="post">
                    <input style="background-color: white; width:70%;" type="text" name="bio"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload Bio" >
                </form>
            </div>
        </div>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>  //Cover and PP Buttons
                var ppBox = document.getElementById("uploadPPBox");
                var ppBtn = document.getElementById("ppBtn");
                var closePP = document.getElementsByClassName("close")[0];
                ppBtn.onclick = function() {
                ppBox.style.display = "block";
                }
                closePP.onclick = function() {
                ppBox.style.display = "none";
                }
                //
                var coverBox = document.getElementById("uploadCoverBox");
                var coverBtn = document.getElementById("coverBtn");
                var closeCover = document.getElementsByClassName("close")[1];
                coverBtn.onclick = function() {
                coverBox.style.display = "block";
                }
                closeCover.onclick = function() {
                coverBox.style.display = "none";
                }
                //
                var bioBox = document.getElementById("uploadBioBox");
                var bioBtn = document.getElementById("bioBtn");
                var closeBio = document.getElementsByClassName("close")[2];
                bioBtn.onclick = function() {
                bioBox.style.display = "block";
                }
                closeBio.onclick = function() {
                bioBox.style.display = "none";
                }


        </script>
    </body>  
</html>
