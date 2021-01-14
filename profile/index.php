<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");
                
                $_SESSION['offset']=0;

                $url = $_SERVER['REQUEST_URI'];
                $_SESSION['current']= $url;
                //aquire the usernames
                $user_id = $_SESSION['user']->get_id();
                $target_id = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],"/",1)+1);
                $target_id = strtolower(substr($target_id,0,strlen($target_id)-1));
                //check if the target is the user
                $isVisitor = TRUE;
                if($user_id == $target_id) $isVisitor = FALSE;
                //refetch the data
                $_SESSION['user'] = new user($user_id);
                if(isset($_SESSION['user']) && strlen($_SESSION['user']->get_id())==0) header("location: ../assets/operation/logout.php");
                $_SESSION['target'] = new user($target_id);
                
             echo '
                    <!DOCTYPE html>
                        <html id="html">
                        <link rel="icon" href="../assets/img/icn_logo.png">

                        <div id="chat">
                        <div id="roomsbig">
                            <button id="newRoom" style="margin:20px 0;">Create a new room</button>
                            <!-- rooms -->
                            <div id="rooms">
                            <!-- load here -->
                            </div>
                        </div><div id="msgsbig">
                            <a style="float:right; font-weight:bolder; font-size:120%; cursor:pointer; color:red; margin:5px 40px;" id="chatClose">X</a>
                            <div id="msgs">
                            <p style="font-size:160%; color:royalblue; text-align:center; margin: 200px 40%;">Select Room To Start Chatting!</p>
                            </div>
                            <div id="send">
                                <div class="ay" style="width:fit-content; height:60%;">
                                    <textarea id="theMsg" rows="4" cols="40" type="textbox" name="body" style=" vertical-align:middle; resize:none;"></textarea>
                                    <button onclick="sendMsg()" style="vertical-align:middle;">Send</button>
                                </div><div class="ay" style="width:fit-content; height:25%;">
                                    <button onclick="show_friends()">Add Members</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="friends">
                        <button style="margin:10px;" onclick="hide_friends()">Close</button>';

                        $friends = $_SESSION['user']->get_friends();
                        $friends_no = $_SESSION['user']->get_friends_no();
                        if($friends_no!=0){
                            $start = 0;
                            for($i=0; $i<$friends_no; $i++){
                            $end = strpos($friends,",",$start + 1);
                            $friend_id = substr($friends,$start,$end - $start);
                            $friend = new user($friend_id);
                            $start = $end + 1;
                            echo'<p id="'.$friend_id.'" onclick="addMember(this.id)" class="friend">'.$friend->get_name().'</p>';
                            }
                        }
                        else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:120%; margin: 30px 0;">No Friends To Show</p>';
                        
                        
                    echo '</div>
                            <head>
                                    <link rel="stylesheet" href="../profile/main.css">
                                    <link rel="icon" href="../assets/img/icn_logo.png">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Chatverse | '.$_SESSION["target"]->get_name().'</title>
        
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
                                                   <button id="chatBtn"><img src="../assets/img/icn_msg.png"></button>
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



                                   var chatBtn = document.getElementById("chatBtn");
                                   var chat = document.getElementById("chat");
                                   var chatClose = document.getElementById("chatClose");
                                   var newRoom  = document.getElementById("newRoom");
                                   var rooms  = document.getElementById("rooms");
                                   var msgs = document.getElementById("msgs");
                                   var send = document.getElementById("send");
                                   var theMsg = document.getElementById("theMsg");
                                   var currentRoom;
    
    
                                   chatBtn.onclick = function() {
                                       var xhttp = new XMLHttpRequest();
                                       xhttp.onreadystatechange = function() {
                                           rooms.innerHTML= this.responseText;
                                           msgs.scrollTop = msgs.scrollHeight;
                                           $("#chat").fadeIn();
                                       };
                                       xhttp.open("GET","../assets/operation/chat.php?op=load_rooms");
                                       xhttp.send();  
                                   }
                                   chatClose.onclick = function() {
                                       $("#chat").fadeOut();
                                   }
                                   newRoom.onclick = function() {
                                       var xhttp = new XMLHttpRequest();
                                       xhttp.onreadystatechange = function() {
                                           
                                           var xhttp2 = new XMLHttpRequest();
                                           xhttp2.onreadystatechange = function() {
                                               rooms.innerHTML= this.responseText;
                                           };
                                           xhttp2.open("GET","../assets/operation/chat.php?op=load_rooms");
                                           xhttp2.send();  
    
                                       };
                                       xhttp.open("GET","../assets/operation/chat.php?op=create_room");
                                       xhttp.send();
                                   }
                                   
                                   function loadRoom(id){
                                       currentRoom = id;
                                       var xhttp = new XMLHttpRequest();
                                       xhttp.onreadystatechange = function() {
                                           msgs.innerHTML= this.responseText;
                                           msgs.scrollTop = msgs.scrollHeight;
                                           send.style.display="block";
                                       };
                                       xhttp.open("GET","../assets/operation/chat.php?op=load_room&id="+id);
                                       xhttp.send();  
                                   }
    
                                   function sendMsg(){
                                       if(theMsg.value!=""){
                                           var xhttp = new XMLHttpRequest();
                                           xhttp.onreadystatechange = function() {
                                               var xhttp = new XMLHttpRequest();
                                               xhttp.onreadystatechange = function() {
                                                   msgs.innerHTML= this.responseText;
                                                   msgs.scrollTop = msgs.scrollHeight;
                                               };
                                               xhttp.open("GET","../assets/operation/chat.php?op=load_room&id="+currentRoom);
                                               xhttp.send();  
                                           };
                                           xhttp.open("GET","../assets/operation/chat.php?op=send_msg&body="+ theMsg.value);
                                           xhttp.send();  
                                       }
                                   }
    
                                   function show_friends(){
                                       $("#friends").fadeIn();
                                   }
                                   function hide_friends(){
                                       $("#friends").fadeOut();
                                   }
    
                                   function addMember(id){
                                       var xhttp = new XMLHttpRequest();
                                       xhttp.onreadystatechange = function() {
                                           if(this.responseText == "yes") location.reload();
                                       };
                                       xhttp.open("GET","../assets/operation/chat.php?op=add_member&id="+id);
                                       xhttp.send();  
                                   }
            





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
   
                                   <audio  id="sound1">
                                   <source src="../assets/audio/clickon.wav" type="audio/x-wav">
                                   </audio>
                                   <audio id="sound2">
                                   <source src="../assets/audio/clickoff.wav" type="audio/x-wav">
                                   </audio>
                                   <audio  id="sound3">
                                   <source src="../assets/audio/saveon.wav" type="audio/x-wav">
                                   </audio>
                                   <audio id="sound4">
                                   <source src="../assets/audio/saveoff.wav" type="audio/x-wav">
                                   </audio>
   
                               </head>
                           <body id="body">'
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
        <div style="width:23%; margin: 20px 2%; height: 800px; display:inline-block; vertical-align:top;">

            <!-- user info section -->
            <div id="user_info" class="datablock">
            <img src="../assets/img/user_info.png"><p>User Info</p>
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
            <img src="../assets/img/friends.png"><p>Friends  (<?php echo $_SESSION['target']->get_friends_no();?>)</p>
                <button id="friendsBtn">See More</button>
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
                        <div class="dataunit">
                            <img src="../'. $friend->get_id()."/". $friend->get_profile_pic().'"><br>
                            <a href="../'.$friend->get_id().'">' . $friend->get_name() . '</a>
                        </div>';
                    }
                }
                else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:150%; margin: 30px;">No Friends To Show</p>'
                ?>
                </div>
            </div>

            <!-- market section -->
            <?php if($_SESSION['target']->get_market_statues()==1){
            
            echo '
            
            <div id="marketblock" class="datablock">
            <img src="../assets/img/market.png"><p>Marketplace  ('.$_SESSION['target']->get_products_no().')</p>
                <button id="marketBtn">Open</button>
                <hr>

                <!-- products units -->
                <div style="margin: 0 0 0 2%">';
                

                if($_SESSION['target']->get_products_no()!=0){
                    $targetMarket = new marketplace($_SESSION['target']->get_id());
                    $targetMarket->show_some_products();
                }

                else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:150%; margin: 30px;">No Products To Show</p>';
                echo'
                </div>
            </div>';}

            ?>

             <!-- any other section -->

         </div>
  

        <!-- Posts Section-->
        <div id="newsfeed">


        </div>




        <div id="comments">
                <samp style="font-size:150%; color:indigo; font-weight:bolder; text-decoration:underline;">Comments</samp>
                <samp style="font-size:150%; color:red; font-weight:bolder; float:right; cursor:pointer;" onclick="closecomment()">X</samp>
                <hr style="margin-top:5px 0; padding:0;">
                <!-- Load Comments -->
                <div id="load">
                </div>
                <!-- Write Comment -->
                <div id="writecomment">
                    <img src="http://localhost/social-media-platform-web/<?php echo $_SESSION['user']->get_id()."/".$_SESSION['user']->get_profile_pic()  ?>">
                    <form id="writecommentform" method="POST" action="http://localhost/social-media-platform-web/assets/operation/post.php">
                        <textarea  placeholder="Write a comment" type="textbox" name="body"></textarea>
                        <input style="width:20%; height:40px; border-radius:5px;  float:right; font-size:90%; margin: 20px 1px" name="submit" type="submit" value="Write">
                    </form>
                </div>

        </div>



            <script>
                                var html = document.getElementById("html");
                                var body = document.getElementById("body");
                                var newsfeed = document.getElementById("newsfeed");
                                var execute = true;
                                var current_comm;
                                body.onscroll=function(){
                                    if(execute && html.scrollHeight - html.scrollTop <= html.clientHeight + 2){
                                        execute = false;
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            newsfeed.innerHTML += this.responseText;
                                            execute = true;
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=profile");
                                        xhttp.send();
                                    }
                                }
                                body.onload=function(){
                                    
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            newsfeed.innerHTML += this.responseText;
                                            {
                                                var xhttp2 = new XMLHttpRequest();
                                                xhttp2.onreadystatechange = function() {
                                                if (this.readyState == 4 && this.status == 200) {
                                                    newsfeed.innerHTML += this.responseText;
                                                }
                                                };
                                                xhttp2.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=profile");
                                                xhttp2.send(); 
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=profile");
                                        xhttp.send();
                                }
                                ///// buttons of post
                                function love(post_id){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            var img = document.getElementById("love" + post_id);
                                            var num = document.getElementById("l" + post_id);
                                            var c1 = document.getElementById("sound1");
                                            var c2 = document.getElementById("sound2");

                                            if(img.src == "http://localhost/social-media-platform-web/assets/img/post_love1.png") 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_love2.png";
                                            c1.play();
                                            num.innerHTML = Number(num.innerHTML) + 1;
                                            }
                                            else 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_love1.png";
                                            c2.play();
                                            num.innerHTML = Number(num.innerHTML) - 1;
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=love&id=" + post_id );
                                        xhttp.send();
                                }
                                function comment(post_id){
                                    var commentbox = document.getElementById("comments");
                                    if(commentbox.style.display=="block"){$("#comments").fadeOut(); current_comm.src = "http://localhost/social-media-platform-web/assets/img/post_comment.png"; return;}
                                    current_comm = document.getElementById("comment" + post_id);
                                    current_comm.src = "http://localhost/social-media-platform-web/assets/img/post_comment1.png";
                                    var comments = document.getElementById("load");
                                    var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            comments.innerHTML = this.responseText;
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=loadcomments&id="+post_id);
                                        xhttp.send();
                                        $("#comments").fadeIn();
                                }
                                function closecomment(){
                                    current_comm.src = "http://localhost/social-media-platform-web/assets/img/post_comment.png";
                                    $("#comments").fadeOut();
                                }
                                function share(post_id){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            var num = document.getElementById("s" + post_id);
                                            num.innerHTML = Number(num.innerHTML) + Number(this.responseText);
                                            if(this.responseText == '0')alert("You Cant Share your own post! \n and You Cant Share a Post Twice!");
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=share&id=" + post_id );
                                        xhttp.send();
                                }
                                function save(post_id){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            var img = document.getElementById("save" + post_id);
                                            var c3 = document.getElementById("sound3");
                                            var c4 = document.getElementById("sound4");

                                            if(img.src == "http://localhost/social-media-platform-web/assets/img/post_save1.png") 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_save2.png";
                                            c3.play();
                                            }
                                            else 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_save1.png";
                                            c4.play();
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=save&id=" + post_id );
                                        xhttp.send();
                                }


            </script>










                <!-- We Work Here -->
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

        <div id="marketBox" class="modal">
            <div class="modal-mp-content">
            <span class="close">&times;</span>

            <?php 
            $targetMarket = new marketplace($_SESSION['target']->get_id());
            $targetMarket->show_all_products($_SESSION['user']->get_id());
            ?>

            </div>
            <?php if(!$isVisitor){
            echo '<div class="modal-ma-content">
                    <form action="../assets/operation/market.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="add_product">
                            <p>Product name:</p><input type="text" name="product_name">
                            <p>Product description:</p><textarea rows="8" type="textbox" name="product_desc"></textarea>
                            <p>Product image:</p><input style="background-color: gray; width:60%;" type="file" name="fileToUpload"><br></br>
                            <input type="submit" name="submit" value="Add Product" >
                    </form>
            </div>';} ?>
        </div>


        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>  //Cover and PP Buttons and market
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
                
                
                <script>
                var marketBox = document.getElementById("marketBox");
                var marketBtn = document.getElementById("marketBtn");
                var closeMarket = document.getElementsByClassName("close")[3];
                marketBtn.onclick = function() {
                marketBox.style.display = "block";
                }
                closeMarket.onclick = function() {
                marketBox.style.display = "none";
                }
                //
                function x(id){
                    $.ajax({  
                        type:"POST",  
                        url:"../assets/operation/market.php",  
                        data:"type=remove_product"+'&id='+id,
                        success: location.reload()
                    }); 
                }
                function y(name){
                $.ajax({  
                    type:"POST",  
                    url:"../assets/operation/market.php",  
                    data:"type=notify"+'&name='+name,
                    success: location.reload(),
                }); 
                }
        </script>
        
    </body>  
</html>
