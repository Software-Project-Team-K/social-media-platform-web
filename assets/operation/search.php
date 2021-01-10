<?php
            require '../classes.php';
            session_start();




            if ($_SERVER["REQUEST_METHOD"] == "GET") {

                $index = $_GET['index'];
                $connect = new connection;

                $results = $connect->conn->query("SELECT full_name,profile_pic,id FROM users WHERE email='$index' OR id='$index'");
                if (mysqli_num_rows($results) != 0){
                    for($i = 0; $i < mysqli_num_rows($results);$i++){
                        $result = mysqli_fetch_assoc($results);
                        echo '
                        <a href="http://localhost/social-media-platform-web/'.$result["id"].'">
                        <div class="searchUnit">
                        <img src="http://localhost/social-media-platform-web/'.$result["id"].'/'.$result["profile_pic"].'"><p>'.$result["full_name"].'</p>
                        </div></a>';
                    }
                }   
                else{
                    $results = $connect->conn->query("SELECT full_name,profile_pic,id FROM users WHERE INSTR(full_name,'$index')>0");
                    if (strlen($index) < 1) {
                        echo '
                        <div class="searchUnit">
                        <samp>Search Results will be shown here.</samp>
                        </div>';
                    }
                    else if (mysqli_num_rows($results) == 0) {
                        echo '
                        <div class="searchUnit">
                        <samp>No Matching Results.</samp>
                        </div>';
                    }
                    else if (mysqli_num_rows($results) == 1) {
                        $result = mysqli_fetch_assoc($results);
                        if($result['id']==$_SESSION['user']->get_id())
                        echo '
                        <div class="searchUnit">
                        <samp>No Matching Results.</samp>
                        </div>';
                        else
                        echo '
                        <a href="http://localhost/social-media-platform-web/'.$result["id"].'">
                        <div class="searchUnit">
                        <img src="http://localhost/social-media-platform-web/'.$result["id"].'/'.$result["profile_pic"].'"><p>'.$result["full_name"].'</p>
                        </div></a>';
                    }
                    else
                    for($i = 0; $i < mysqli_num_rows($results);$i++){
                        $result = mysqli_fetch_assoc($results);
                        if($result['id']!=$_SESSION['user']->get_id())
                        echo '
                            <a href="http://localhost/social-media-platform-web/'.$result["id"].'">
                            <div class="searchUnit">
                            <img src="http://localhost/social-media-platform-web/'.$result["id"].'/'.$result["profile_pic"].'"><p>'.$result["full_name"].'</p>
                            </div></a>';
                    }
                }
            }
            
?>