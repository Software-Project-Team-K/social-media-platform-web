<?php 
            require 'assets/classes.php';
            session_start();
            if(!isset($_SESSION['user']))header("location: hello/");

            
            //refetch the data
            $_SESSION['user'] = new user($_SESSION['user']->get_id());
            if(isset($_SESSION['user']) && strlen($_SESSION['user']->get_id())==0) header("location: assets/operation/logout.php");
            
            $url = $_SERVER['REQUEST_URI'];
            $_SESSION['current']= $url;
            $_SESSION['offset'] = 0;

        
            echo '
                 <!DOCTYPE html>
                    <html id="html">
                        <head>
                                <link rel="stylesheet" href="main.css">
                                <meta charset="utf-8">
                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Chatverse | Newsfeed</title>
                                <link rel="icon" href="assets/img/icn_logo.png">
            
                                 <!--Navigation Bar-->
                                 <div id="nav">
                                    <a href=""><img src="assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>

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

                                <audio  id="sound1">
                                <source src="assets/audio/clickon.mp3" type="audio/mpeg">
                                </audio>
                                <audio id="sound2">
                                <source src="assets/audio/clickoff.mp3" type="audio/mpeg">
                                </audio>



                            </head>
                        <body id="body">'
?>
        <!-- LETS GO BABY -->

            <div id="groups_pages">
                <div id="groups" style="height: 46%; border:0; padding:10px 0px;">
                    <img style="width:15%; margin:7px 5px 10px 25px; vertical-align:top; display:inline-block;" src="assets/img/group_icon.png">
                    <p style="color:indigo; display:inline-block; font-size:105%; text-align:center; border:2px gray solid; box-shadow: 1px 3px 5px indigo; font-weight:bolder; background-color:white; width:45%; margin:5px auto; border-radius:5px;">Groups (<?php echo $_SESSION['user']->get_groups_no(); ?>)</p>
                    <div id="show" style="height: 80%; border:0; text-align:left; padding: 10px 20px; overflow-y:auto;">
                    <?php
                    $groups = $_SESSION['user']->get_groups();
                    $groups_no = $_SESSION['user']->get_groups_no();
                    if($groups_no!=0){
                        $start = 0;
                        for($i=0; $i<$groups_no; $i++){
                        $end = strpos($groups,",",$start + 1);
                        $group = new group($_SESSION['user']->get_id(),substr($groups,$start,$end - $start));
                        $start = $end + 1;
                        echo'- <a href="group.php?group='.$group->get_id().'"> '.$group->get_name().'</a><br>';
                        }
                    }
                    else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:130%; margin: 30px;">No Groups To Show</p>';
                    ?>
                    </div>
                </div>
                <div id="pages" style="height: 46%; padding:10px 0px;">
                    <img style="width:12%; margin:5px 5px 10px 25px; vertical-align:top; display:inline-block;" src="assets/img/page_icon.png">
                    <p style="color:indigo; display:inline-block; font-size:105%; text-align:center; border:2px gray solid; box-shadow: 1px 3px 5px indigo; font-weight:bolder; background-color:white; width:45%; margin:5px auto; padding:0; border-radius:5px;">Pages (<?php echo $_SESSION['user']->get_groups_no(); ?>)</p>                    <div id="show" style="height: 80%; border:0; text-align:left; padding: 10px 20px; overflow-y:auto;">
                    <?php
                    $pages = $_SESSION['user']->get_pages();
                    $pages_no = $_SESSION['user']->get_pages_no();
                    if($pages_no!=0){
                        $start = 0;
                        for($i=0; $i<$pages_no; $i++){
                        $end = strpos($pages,",",$start + 1);
                        $page = new page($_SESSION['user']->get_id(),substr($pages,$start,$end - $start));
                        $start = $end + 1;
                        echo'- <a href="page.php?page='.$page->get_id().'"> '.$page->get_name().'</a><br>';
                        }
                    }
                    else echo '<p style="text-align:center; color:gray; font-weight:bolder; font-size:130%; margin: 30px;">No Pages To Show</p>';
                    ?>
                    </div>
                </div>
                <hr>
                <button onclick="create()"; style="color:white; background-color:indigo; width:50%; font-weight:bold; margin: 0 25%; border-radius:8px;">Create a new</button>

                <div id="create" style="height: 15%; display:none; border: 2px darkblue  solid; border-radius:10px; position: absolute; bottom: 0%; left:110%;">
                <form method="POST" action="http://localhost/social-media-platform-web/assets/operation/db_update.php">
                    <p>Name:</p><input style="width:60%" name="name" type="text"><br>
                    <input type="radio" id="male" name="type" value="Page" checked="checked"><samp> Page &emsp;</samp>
                    <input type="radio" id="female" name="type" value="Group"><samp> Group</samp><br>
                    <input type="submit" name="submit" style="margin:5px 10px 5px 20%; border-radius:5px; color:green;" value="Create"> <input type="button" style="width:25%; text-align:center; color:red; border-radius:5px;" onclick="create()" value="Close">
                </form>
                
                </div>

            </div>

            <div id="newsfeed">
                <div id="writepost">
                    <img src="<?php echo $_SESSION['user']->get_id()."/".$_SESSION['user']->get_profile_pic()  ?>">
                    <form id="writepostform" method="POST" action="http://localhost/social-media-platform-web/assets/operation/post.php">
                        <textarea rows="5" placeholder="Write a Timeline Post" id="postbody" type="textbox" name="body"></textarea>
                        <input type="hidden" placeholder="Write the Post To..." style="width:30%; float:left; margin:0;" name="post_to" value="H"> <input style="width:18%; float:right; margin: 2px 0; border-radius:5px; border:gray 2px solid; background-color:indigo; color:white;" name="submit" type="submit" value="Post">
                    </form>
                </div>
                <!-- Load Posts -->
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
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=home");
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
                                                xhttp2.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=home");
                                                xhttp2.send(); 
                                            }
                                        }
                                        };
                                        xhttp.open("GET","http://localhost/social-media-platform-web/assets/operation/post.php?op=load&page=home");
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
                                            c1.play();
                                            img.src = "http://localhost/social-media-platform-web/assets/img/post_love2.png";
                                            num.innerHTML = Number(num.innerHTML) + 1;
                                            }
                                            else 
                                            {
                                            c2.play();
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
                                    if(commentbox.style.display=="block"){$("#comments").fadeOut(); return;}
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
                                    var commentbox = document.getElementById("comments");
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

                                function create(){
                                    var but = document.getElementById("create");
                                    $("#create").fadeToggle();
                                }

            </script>

    </body>  
</html>
            