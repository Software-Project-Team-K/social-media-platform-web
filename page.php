<?php       
            require 'assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: hello/");

            //refetch the data
            $_SESSION['user'] = new user($_SESSION['user']->get_id());
            $_SESSION['offset'] = 0;
        
            // Inintialize URL to the variable 
            $url = $_SERVER['REQUEST_URI'];
            $url_components = parse_url($url); 
            parse_str($url_components['query'], $params);
            $_SESSION['page'] = new page($_SESSION['user']->get_id(),$params['page']); 
           
            if($_SESSION['page']->get_owner()==$_SESSION['user']->get_id()) $_SESSION['type']="owner";
            else if(strstr($_SESSION['page']->get_admins(),$_SESSION['user']->get_id())) $_SESSION['type']="admin";
            else $_SESSION['type']="fan";

            if($_SESSION['type']=="fan") $_SESSION['followed'] = strstr($_SESSION['page']->get_followers(),$_SESSION['user']->get_id());
            

            echo '
                 <!DOCTYPE html>
                    <html id="html">
                        <head>
                                <link rel="stylesheet" href="main.css">
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Chatverse | '.$_SESSION['page']->get_name()./*$_SESSION['x'].*/'</title>
                                <link rel="icon" href="assets/img/icn_logo.png">
            
                                 <!--Navigation Bar-->
                                 <div id="nav">
                                    <a href="settings/../"><img src="assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>

                                    <form>
                                    <input type="text" id="searchbar">
                                    </form><button type="submit"><img style="width:12px; padding:0; margin:0;" src="assets/img/icn_search.png"></button>
                                    <div id="searchbox">
                                    <div class="searchUnit">
                                    <samp>Search Results will be shown here!</samp>
                                    </div>
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
                                           document.getElementById("noti_img").src = "assets/img/icn_notification.png";
                                          }
                                        };
                                        xhttp.open("GET","assets/operation/db_update.php");
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
                                xhttp.open("GET","assets/operation/search.php?index=" + searchBar.value);
                                xhttp.send();
                                }


                                </script>

                            </head>
                        <body id="body">'
?>
        <!-- LETS GO BABY -->

        <div id="groups_pages" style="text-align:center;">
        <img src="assets/img/page_icon.png" style="width:60%; margin: 5px auto; border-radius:inherit;" >
        <h3 style="margin:0 0 10px 0; color:green; font-style:italic;"> <?php echo $_SESSION['page']->get_name(); ?> </h3>

        <button id="p_button" style="border-radius:5px; color:indigo; font-weight:bolder;" onclick="page_button()"><?php
        if($_SESSION['type']=="owner")echo 'Delete Page';
        else if($_SESSION['type']=="admin")echo 'Leave Administration';
        else {
            if($_SESSION['followed']) echo 'Unfollow';
            else echo 'Follow';
        }
       
       ?></button>
        <hr>
        <p style="margin:5px auto; width:70%; font-size:130%; color:white; border:2px solid black; border-radius:5px; background-color:indigo; font-weight:bolder; "> Fans (<?php echo $_SESSION['page']->get_followers_no();?>) </p>
        <div style="width:100%; text-align:left; padding:20px; height:30%; border:2px solid gray; border-radius:10px; overflow-y:auto; <?php if($_SESSION['type']=="fan") echo 'display:none;' ?>">
        <?php
                    $followers = $_SESSION['page']->get_followers();
                    $followers_no = $_SESSION['page']->get_followers_no();
                    if($followers_no!=0){
                        $start = 0;
                        for($i=0; $i<$followers_no; $i++){
                        $end = strpos($followers,",",$start + 1);
                        $follower = new user(substr($followers,$start,$end - $start));
                        $start = $end + 1;
                        echo'<div style="border:2px solid transparent;"> - <a style="font-size:95%; text-decoration:none;" href="http://localhost/social-media-platform-web/'.$follower->get_id().'"> '.$follower->get_name().'</a><button name="'.$follower->get_id().'" onclick="promote_button(this.name)" style="margin: 0 5px;'; if($_SESSION['type']!="owner") echo'display:none;';  echo'padding:1px 2px; border-radius:3px; font-size:80%;  float:right;">Promote</button></div>';
                        } 
                    }
                    else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:130%; margin: 60px auto;">No Fans</p>';
        ?>
        </div>
        <p style="margin:5px auto; width:80%; font-size:130%; color:white; border:2px solid black; border-radius:5px; background-color:indigo; font-weight:bolder; <?php if($_SESSION['type']!="owner") echo 'display:none;' ?>"> Admins (<?php echo $_SESSION['page']->get_admins_no(); ?>) </p>
        <div style="width:100%; text-align:left; padding:20px; height:30%; border:2px solid gray; border-radius:10px; overflow-y:auto; <?php if($_SESSION['type']!="owner") echo 'display:none;' ?>">
        <?php
                    $admins = $_SESSION['page']->get_admins();
                    $admins_no = $_SESSION['page']->get_admins_no();
                    if($admins_no!=0){
                        $start = 0;
                        for($i=0; $i<$admins_no; $i++){
                        $end = strpos($admins,",",$start + 1);
                        $admin = new user(substr($admins,$start,$end - $start));
                        $start = $end + 1;
                        echo'<div style="border:2px solid transparent;"> - <a style="font-size:95%; text-decoration:none;" href="http://localhost/social-media-platform-web/'.$admin->get_id().'"> '.$admin->get_name().'</a><button name="'.$admin->get_id().'" onclick="demote_button(this.name)" style="margin: 0 5px; padding:1px 2px; border-radius:3px; font-size:80%;  float:right;">Demote</button></div>';
                      }
                    }
                    else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:130%; margin: 60px auto;">No Requests</p>';
        ?>
        </div>
        </div> 
            

            <div id="newsfeed">
                <div id="writepost" <?php if($_SESSION['type']=="fan") echo 'style="display:none"' ?>>
                    <img src="http://localhost/social-media-platform-web/assets/img/page_icon.png">
                    <form id="writepostform" method="POST" action="http://localhost/social-media-platform-web/assets/operation/post.php">
                        <textarea rows="5" placeholder="Whats in your mind ?.." id="postbody" type="textbox" name="body"></textarea>
                        <input type="hidden" placeholder="Write the Post To..." style="width:30%; float:left; margin:10px 0;" name="post_to" value="P<?php echo $_SESSION['page']->get_id(); ?>"> <input style="width:18%; float:right; margin:10px; border-radius:5px; background-color:indigo; color:white;" name="submit" type="submit" value="Post">
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
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=page&id="+<?php echo $_SESSION['page']->get_id(); ?>);
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
                                                xhttp2.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=page&id="+<?php echo $_SESSION['page']->get_id(); ?>);
                                                xhttp2.send(); 
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=page&id="+<?php echo $_SESSION['page']->get_id(); ?>);
                                        xhttp.send();
                                }
                                ///// buttons of post
                                function love(post_id){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            var img = document.getElementById("love" + post_id);
                                            var num = document.getElementById("l" + post_id);
                                            if(img.src == "http://localhost/social-media-platform-web/assets/img/post_love1.png") 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_love2.png";
                                            num.innerHTML = Number(num.innerHTML) + 1;
                                            }
                                            else 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_love1.png";
                                            num.innerHTML = Number(num.innerHTML) - 1;
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=love&id=" + post_id );
                                        xhttp.send();
                                }
                                function comment(post_id){
                                    var commentbox = document.getElementById("comments");
                                    var comments = document.getElementById("load");
                                    var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            comments.innerHTML = this.responseText;
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=loadcomments&id="+post_id);
                                        xhttp.send();
                                    commentbox.style.display = "block";
                                }
                                function closecomment(){
                                    var commentbox = document.getElementById("comments");
                                    commentbox.style.display = "none";
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
                                            if(img.src == "http://localhost/social-media-platform-web/assets/img/post_save1.png") 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_save2.png";
                                            }
                                            else 
                                            {
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_save1.png";
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=save&id=" + post_id );
                                        xhttp.send();
                                }
                                function page_button(){
                                    var p_button = document.getElementById("p_button");
                                    if(p_button.innerHTML == "Follow"){var op="follow";}
                                    else if(p_button.innerHTML == "Unfollow"){var op="unfollow";}
                                    else if(p_button.innerHTML == "Delete Page"){var op="delete";}
                                    else if(p_button.innerHTML == "Leave Administration"){var op="leave";}
                                    var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            if(op=="delete") window.location.replace("settings/../");
                                            else location.reload();
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/page.php?op="+ op);
                                        xhttp.send(); 
                                }
                                function promote_button(id){
                                    var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                            location.reload();
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/page.php?op=promote&id="+ id);
                                        xhttp.send(); 
                                }
                                function demote_button(id){
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                             location.reload();
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/page.php?op=demote&id=" + id);
                                        xhttp.send(); 
                                }

            </script>

    </body>  
</html>
            