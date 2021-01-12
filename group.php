<?php       
            require 'assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: hello/");

            //refetch the data
            $_SESSION['user'] = new user($_SESSION['user']->get_id());
            if(isset($_SESSION['user']) && strlen($_SESSION['user']->get_id())==0) header("location: assets/operation/logout.php");

            $_SESSION['offset'] = 0;
        
            // Inintialize URL to the variable 
            $url = $_SERVER['REQUEST_URI'];
            $_SESSION['current']= $url;
            $url_components = parse_url($url); 
            parse_str($url_components['query'], $params);
            $_SESSION['group'] = new group($_SESSION['user']->get_id(),$params['group']); 
           
            if($_SESSION['group']->get_owner()==$_SESSION['user']->get_id()) $_SESSION['type']="admin";
            else if(strstr($_SESSION['group']->get_members(),$_SESSION['user']->get_id())) $_SESSION['type']="member";
            else $_SESSION['type']="guest";

            if($_SESSION['type']=="guest") $_SESSION['requested'] = strstr($_SESSION['group']->get_requests(),$_SESSION['user']->get_id());
            

            echo '
                 <!DOCTYPE html>
                    <html id="html">
                        <head>
                                <link rel="stylesheet" href="main.css">
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Chatverse | '.$_SESSION['group']->get_name().'</title>
                                <link rel="icon" href="assets/img/icn_logo.png">
            
                                 <!--Navigation Bar-->
                                 <div id="nav">
                                    <a href="settings/../"><img src="assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>

                                    <form>
                                    <input type="text" id="searchbar">
                                    </form><button type="submit"><img style="width:12px; padding:0; margin:0;" src="assets/img/icn_search.png"></button>
                                    <div id="searchbox">
                                    <div class="searchUnit" style="text-align:center; width:100%;">
                                    <samp style="color:brown;"> Results will be shown here.</samp></div>
                                    <div style="text-align:center; border:0;">
                                    <img style="width:50%; margin:0 10%; height:130px; border:0;" src="http://localhost/social-media-platform-web/assets/img/icn_search.png"></div>
                                    </div>


                                        <div id="navbuttons">
                                                <button><a href='.$_SESSION["user"]->get_id().'><img src="'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                                <button><img src="assets/img/icn_msg.png"></button>
                                                
                                                <button id="notiBtn"><img id="noti_img" src="assets/img/icn_notification'.$_SESSION["user"]->get_noti_statues().'.png"></button>
                                                <button id="arrow"><img src="assets/img/icn_settings.png"></button>
                                                <div id="noti">';
                                                $noti = new notification($_SESSION['user']->get_id());
                                                $noti->get_noti(); 
                                                echo '</div>
                                                <ul id="menu">
                                                        <li><a href="settings">Settings</li>
                                                        <li><a href="saved">Saved Posts</li>
                                                        <li><a href="assets/operation/logout.php">Logout</a></li>
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
                                           document.getElementById("noti_img").src = "assets/img/icn_notification.png";
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
                                xhttp.open("GET","assets/operation/search.php?index=" + searchBar.value);
                                xhttp.send();
                                }

                                </script>
                                
                                <audio  id="sound1">
                                <source src="assets/audio/clickon.wav" type="audio/x-wav">
                                </audio>
                                <audio id="sound2">
                                <source src="assets/audio/clickoff.wav" type="audio/x-wav">
                                </audio>
                                <audio  id="sound3">
                                <source src="assets/audio/saveon.wav" type="audio/x-wav">
                                </audio>
                                <audio id="sound4">
                                <source src="assets/audio/saveoff.wav" type="audio/x-wav">
                                </audio>

                            </head>
                        <body id="body">'
?>
        <!-- LETS GO BABY -->

        <div id="groups_pages" style="text-align:center; height:82%;">
        <img src="assets/img/group_icon.png" style="width:60%; margin: 10px auto; border-radius:inherit;" >
        <h3 style="margin:0 0 10px 0; color:royalblue; font-style:italic;"> <?php echo $_SESSION['group']->get_name(); ?> </h3>

        <button id="g_button" style="border-radius:5px; color:indigo; font-weight:bolder;" onclick="group_button()"><?php
        if($_SESSION['type']=="admin")echo 'Delete Group';
        else if($_SESSION['type']=="member")echo 'Leave Group';
        else {
            if($_SESSION['requested']) echo 'Cancel Request';
            else echo 'Join Group';
        }
       
       ?></button>
        <hr>
        <p style="margin:5px auto; width:75%; font-size:120%; color:white; border:2px solid black; border-radius:6px; background-color:indigo; font-weight:bolder; <?php if($_SESSION['type']=="guest") echo 'display:none;' ?>"> Members (<?php echo $_SESSION['group']->get_members_no();?>) </p>
        <div style="width:100%; text-align:left; padding:5px; height:30%; border:2px solid gray; border-radius:10px; overflow-y:auto; <?php if($_SESSION['type']=="guest") echo 'display:none;' ?>">
        <?php
                    $members = $_SESSION['group']->get_members();
                    $members_no = $_SESSION['group']->get_members_no();
                    if($members_no!=0){
                        $start = 0;
                        for($i=0; $i<$members_no; $i++){
                        $end = strpos($members,",",$start + 1);
                        $member = new user(substr($members,$start,$end - $start));
                        $start = $end + 1;
                        echo'<div style="border:2px solid transparent;"> - <a style="font-size:95%; text-decoration:none;" href="http://localhost/social-media-platform-web/'.$member->get_id().'"> '.$member->get_name().'</a><button name="'.$member->get_id().'" onclick="kick_button(this.name)" style="margin: 0 5px;'; if($_SESSION['type']!="admin") echo'display:none;';  echo'padding:1px 2px; border-radius:3px; font-size:80%;  float:right;">Kick</button></div>';
                        } 
                    }
                    else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:130%; margin: 40px auto;">No Members</p>';
        ?>
        </div>
        <p style="margin:5px auto; width:75%; font-size:120%; color:white; border:2px solid black; border-radius:6px; background-color:indigo; font-weight:bolder; <?php if($_SESSION['type']!="admin") echo 'display:none;' ?>"> Requests (<?php echo $_SESSION['group']->get_requests_no(); ?>) </p>
        <div style="width:100%; text-align:left; padding:5px; height:30%; border:2px solid gray; border-radius:10px; overflow-y:auto; <?php if($_SESSION['type']!="admin") echo 'display:none;' ?>">
        <?php
                    $requests = $_SESSION['group']->get_requests();
                    $requests_no = $_SESSION['group']->get_requests_no();
                    if($requests_no!=0){
                        $start = 0;
                        for($i=0; $i<$requests_no; $i++){
                        $end = strpos($requests,",",$start + 1);
                        $member = new user(substr($requests,$start,$end - $start));
                        $start = $end + 1;
                        echo'<div style="border:2px solid transparent;"> - <a style="font-size:95%; text-decoration:none;" href="http://localhost/social-media-platform-web/'.$member->get_id().'"> '.$member->get_name().'</a><button name="'.$member->get_id().'" onclick="response_button(this.name, 1)" style="margin: 0 5px; padding:1px 2px; border-radius:3px; font-size:80%;  float:right;">X</button><button name="'.$member->get_id().'" onclick="response_button(this.name , 0)" style="margin: 0 5px; padding:1px 2px; border-radius:3px; font-size:80%; float:right;">O</button> </div>';
                      }
                    }
                    else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:130%; margin: 40px auto;">No Requests</p>';
        ?>
        </div>
        </div>
            
            <div style="display:none; border: 2px indigo solid; border-radius:15px; margin: 50px 30%; text-align:center;  <?php if($_SESSION['type']=="guest") echo 'display:block;' ?>">
                            <h1 style="color:brown;"> Join The Group To See Posts</h1>
            </div>

            <div id="newsfeed" <?php if($_SESSION['type']=="guest") echo 'style="display:none"' ?>>
                <div id="writepost">
                    <img src="<?php echo $_SESSION['user']->get_id()."/".$_SESSION['user']->get_profile_pic()  ?>">
                    <form id="writepostform" method="POST" action="http://localhost/social-media-platform-web/assets/operation/post.php">
                        <textarea rows="5" placeholder="Share news with the group." id="postbody" type="textbox" name="body"></textarea>
                        <input type="hidden" placeholder="Write the Post To..." style="width:30%; float:left; margin:10px 0;" name="post_to" value="G<?php echo $_SESSION['group']->get_id(); ?>"> <input style="width:18%; float:right; margin: 2px 0; border-radius:5px; border:gray 2px solid; background-color:indigo; color:white;" name="submit" type="submit" value="Post">
                    </form>
                </div>
                <!-- Load Posts -->
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
                    <img src="<?php echo $_SESSION['user']->get_id()."/".$_SESSION['user']->get_profile_pic()  ?>">
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
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=group&id="+<?php echo $_SESSION['group']->get_id(); ?>);
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
                                                xhttp2.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=group&id="+<?php echo $_SESSION['group']->get_id(); ?>);
                                                xhttp2.send(); 
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=group&id="+<?php echo $_SESSION['group']->get_id(); ?>);
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
                                            c4.play();
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=save&id=" + post_id );
                                        xhttp.send();
                                }
                                function group_button(){
                                    var g_button = document.getElementById("g_button");
                                    if(g_button.innerHTML == "Delete Group"){var op="delete";}
                                    else if(g_button.innerHTML == "Join Group"){var op="join";}
                                    else if(g_button.innerHTML == "Leave Group"){var op="leave";}
                                    else if(g_button.innerHTML == "Cancel Request"){var op="cancel";}
                                    var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            if(op=="delete") window.location.replace("settings/../");
                                            else location.reload();
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/group.php?op="+ op);
                                        xhttp.send(); 
                                }
                                function kick_button(id){
                                    var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            location.reload();
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/group.php?op=kick&id="+ id);
                                        xhttp.send(); 
                                }
                                function response_button(id,op){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                             location.reload();
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/group.php?op=" + op + "&id=" + id);
                                        xhttp.send(); 
                                }

            </script>

    </body>  
</html>
            