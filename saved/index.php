<?php 

                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");

                //refetch the data
                $_SESSION['user'] = new user($_SESSION['user']->get_id());
                if(isset($_SESSION['user']) && strlen($_SESSION['user']->get_id())==0) header("location: ../assets/operation/logout.php");


                $url = $_SERVER['REQUEST_URI'];
                $_SESSION['current']= $url;
                $_SESSION['offset'] = 0;


                
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
                                    <link rel="stylesheet" href="main.css">
                                    <link rel="icon" href="../assets/img/icn_logo.png">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Chatverse | Saved Posts</title>
                                            
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


        <div style="width:10%; display:inline-block; background-color:rgba(220,220,220,0.5); border-right:2px solid indigo; border-bottom:2px solid indigo; padding:0 15px 15px 15px; border-radius:0 0 50px 0; vertical-align:top; text-align:center;">
        <h3 style="color:white; background-color:rgba(160,50,180,0.5); border:1px solid indigo; border-radius:5px">Saved Posts</h3>
        <img style="width:100%;" src="../assets/img/post_save2.png">
        </div>



        <!-- Posts Section-->
        <div id="newsfeed">


        </div>




        <div id="comments">
                <samp style="font-size:150%; color:royalblue; font-weight:bolder; text-decoration:underline;">Comments</samp>
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
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=saved");
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
                                                xhttp2.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=saved");
                                                xhttp2.send(); 
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=saved");
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
                                            
                                            
                                            $.when(c4.play()).then(setTimeout(rld,500));
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=save&id=" + post_id );
                                        xhttp.send();
                                }
                                function rld(){
                                        location.reload()
                                }
            </script>

 
    </body>  
</html>
