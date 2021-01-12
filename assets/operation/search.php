<?php
            require '../classes.php';
            session_start();




            if ($_SERVER["REQUEST_METHOD"] == "GET") {

                $index = $_GET['index'];
                $connect = new connection;
                
                if($index == 'top_trends'){
                    admin::get_trends(1);
                    die();
                }
                else if($index == 'top_trends_w'){
                    admin::get_trends(7);
                    die();
                }
                else if($index == 'top_trends_m'){
                    admin::get_trends(30);
                    die();
                }
                else if($index == 'top_pages'){
                    admin::get_top_pages(10);
                    die();
                }

                $results = $connect->conn->query("SELECT full_name,profile_pic,id FROM users WHERE email='$index' OR id='$index'");
                $pattern = '-1';
                if(strlen($index) > 1)$pattern = substr($index,1);
                $groups = $connect->conn->query("SELECT * FROM groups WHERE id='$pattern'");
                $pages = $connect->conn->query("SELECT * FROM pages WHERE id='$pattern'");
                if (mysqli_num_rows($results) != 0 && $index[0]!='G' && $index[0]!='P'){
                    for($i = 0; $i < mysqli_num_rows($results);$i++){
                        $result = mysqli_fetch_assoc($results);
                        echo '
                        <a href="http://localhost/social-media-platform-web/'.$result["id"].'">
                        <div class="searchUnit">
                        <img src="http://localhost/social-media-platform-web/'.$result["id"].'/'.$result["profile_pic"].'"><p>'.$result["full_name"].'</p>
                        </div></a>';
                    }
                }
                else if(mysqli_num_rows($groups) != 0 && $index[0]=='G'){
                    for($i = 0; $i < mysqli_num_rows($groups);$i++){
                        $group = mysqli_fetch_assoc($groups);
                        echo '
                        <a href="http://localhost/social-media-platform-web/group.php?group='.$group["id"].'">
                        <div class="searchUnit">
                        <img src="http://localhost/social-media-platform-web/assets/img/group_icon.png"><p>'.$group["group_name"].'</p>
                        </div></a>';
                    }
                }
                else if(mysqli_num_rows($pages) != 0 && $index[0]=='P'){
                    for($i = 0; $i < mysqli_num_rows($pages);$i++){
                        $page = mysqli_fetch_assoc($pages);
                        echo '
                        <a href="http://localhost/social-media-platform-web/page.php?page='.$page["id"].'">
                        <div class="searchUnit">
                        <img src="http://localhost/social-media-platform-web/assets/img/page_icon.png"><p>'.$page["page_name"].'</p>
                        </div></a>';
                    }
                }
                else{
                    $results = $connect->conn->query("SELECT full_name,profile_pic,id FROM users WHERE INSTR(full_name,'$index')>0");
                    $groups = $connect->conn->query("SELECT * FROM groups WHERE INSTR(group_name,'$index')>0");
                    $pages = $connect->conn->query("SELECT * FROM pages WHERE INSTR(page_name,'$index')>0");


                    if (strlen($index) < 1) {
                        echo '
                        <div class="searchUnit" style="text-align:center; width:100%;">
                        <samp style="color:brown;"> Results will be shown here.</samp></div>
                        <div style="text-align:center; border:0;">
                        <img style="width:50%; margin:0 10%; height:130px; border:0;" src="http://localhost/social-media-platform-web/assets/img/icn_search.png"></div>';
                    }
                   else if (mysqli_num_rows($results) == 0 && mysqli_num_rows($groups) == 0 && mysqli_num_rows($pages) == 0) {
                        echo '
                        <div class="searchUnit" style="text-align:center; width:100%;">
                        <samp style="color:brown;">No Matching Results.</samp>
                        </div><div style="text-align:center; border:0;">
                        <img style="width:50%; margin:0 10%; height:130px; border:0;" src="http://localhost/social-media-platform-web/assets/img/no_search.png"></div>';
                    } 
                    else if (mysqli_num_rows($results) == 1 && mysqli_num_rows($groups) == 0 && mysqli_num_rows($pages) == 0) {
                        $result = mysqli_fetch_assoc($results);
                        if($result['id']==$_SESSION['user']->get_id())
                        echo '
                        <div class="searchUnit" style="text-align:center; width:100%;">
                        <samp style="color:brown;">No Matching Results.</samp>
                        </div><div style="text-align:center; border:0;">
                        <img style="width:50%; margin:0 10%; height:130px; border:0;" src="http://localhost/social-media-platform-web/assets/img/no_search.png"></div>';
                        else
                        echo '
                        <a href="http://localhost/social-media-platform-web/'.$result["id"].'">
                        <div class="searchUnit">
                        <img src="http://localhost/social-media-platform-web/'.$result["id"].'/'.$result["profile_pic"].'"><p>'.$result["full_name"].'</p>
                        </div></a>';
                    }

                    else{
                        for($i = 0; $i < mysqli_num_rows($results);$i++){
                            $result = mysqli_fetch_assoc($results);
                            if($result['id']==$_SESSION['user']->get_id()) continue;
                            echo '
                                <a href="http://localhost/social-media-platform-web/'.$result["id"].'">
                                <div class="searchUnit">
                                <img src="http://localhost/social-media-platform-web/'.$result["id"].'/'.$result["profile_pic"].'"><p>'.$result["full_name"].'</p>
                                </div></a>';
                        }
                        for($i = 0; $i < mysqli_num_rows($groups);$i++){
                            $group = mysqli_fetch_assoc($groups);
                            echo '
                            <a href="http://localhost/social-media-platform-web/group.php?group='.$group["id"].'">
                            <div class="searchUnit">
                            <img src="http://localhost/social-media-platform-web/assets/img/group_icon.png"><p>'.$group["group_name"].'</p>
                            </div></a>';
                        }
                        for($i = 0; $i < mysqli_num_rows($pages);$i++){
                            $page = mysqli_fetch_assoc($pages);
                            echo '
                            <a href="http://localhost/social-media-platform-web/page.php?page='.$page["id"].'">
                            <div class="searchUnit">
                            <img src="http://localhost/social-media-platform-web/assets/img/page_icon.png"><p>'.$page["page_name"].'</p>
                            </div></a>';
                        }
                    }
                }
            }
            
?>