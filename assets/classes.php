<?php

                    class connection{
                        private  $_server = "localhost";
                        private  $_user = "root";
                        private  $_pass = "";
                        private  $_dbname = "chatverse";
                        public   $conn;
                    
                        function __construct(){
                        $this->conn = new mysqli($this->_server, $this->_user, $this->_pass ,$this->_dbname) or die("Connection failed: " . $this->conn->connect_error);
                        }
                        function __destruct(){
                        $this->conn->close();
                         }
                    }
                    class user{

                        private $data;

                        function __construct($logID){
                            //get user data from parameter (username or email)
                            $connect = new connection;
                            $connect->conn->query("UPDATE users SET is_online='YES' WHERE id='$logID'");
                            $result = $connect->conn->query("SELECT * FROM users WHERE id='$logID' or email='$logID' or phone_num='$logID'");
                            $this->data = mysqli_fetch_assoc($result);
                        }

                        function get_name() {return $this->data['full_name'];}
                        function get_id()  {return $this->data['id'];}
                        function get_gender(){return $this->data['gender'];}
                        function get_email(){return $this->data['email'];}
                        function get_phone(){return $this->data['phone_num'];}
                        function get_bio(){return $this->data['bio'];}
                        function get_birth_date(){return $this->data['birth_date'];}
                        function get_profile_pic() {return $this->data['profile_pic'];}
                        function get_cover_pic()  {return $this->data['cover_pic'];}
                        function get_friends(){return $this->data['friends'];}
                        function get_friends_no(){return $this->data['friends_no'];}
                        function get_fr_requests(){return $this->data['fr_requests'];}
                        function get_noti_statues(){return $this->data['new_noti']; }
                        function get_market_statues(){return  $this->data['enable_market'];}
                        function get_products_no(){return $this->data['products_no'];}
                        function get_groups(){return $this->data['groups'];}
                        function get_groups_no(){return $this->data['groups_no'];}
                        function get_pages(){return $this->data['pages'];}
                        function get_pages_no(){return $this->data['pages_no'];}
                        function go_offline($id)
                        { 
                            $connect = new connection;
                            $connect->conn->query("UPDATE users SET is_online='NO' WHERE id='$id'"); 
                        }
                        function update_profile_pic($link)
                        {
                            $connect = new connection;
                            $id = $this->get_id();
                            $connect->conn->query("UPDATE users SET profile_pic='$link' WHERE id='$id'");
                        }
                        function update_cover_pic($link)
                        {
                            $connect = new connection;
                            $id = $this->get_id();
                            $connect->conn->query("UPDATE users SET cover_pic='$link' WHERE id='$id'");
                        }
                        function update_bio($text)
                        {
                            $connect = new connection;
                            $id = $this->get_id();
                            $connect->conn->query("UPDATE users SET bio='$text' WHERE id='$id'");
                        }
                        function enable_market($val){
                            $connect = new connection;
                            $id = $this->get_id();
                            $connect->conn->query("UPDATE users SET enable_market='$val' WHERE id='$id'");
                        }
                        function open_noti(){
                            $connect = new connection;
                            $id = $this->get_id();
                            $connect->conn->query("UPDATE users SET new_noti='' WHERE id='$id'");
                        }
                        function link_google($google){
                            $connect = new connection;
                            $id = $this->get_id();
                            $result = $connect->conn->query("SELECT * FROM users WHERE google_id='$google'");
                            if (mysqli_num_rows($result) == 0) {
                            $connect->conn->query("UPDATE users SET google_id='$google' WHERE id='$id'");
                            echo 'This Google Account associated Successfully!.';}
                            else echo 'This Google Account already associated!.';
                        }
                    }
                    class admin{

                        private $data;

                        function __construct($logID){
                            $connect = new connection;
                            $result = $connect->conn->query("SELECT * FROM admins WHERE username='$logID'");
                            $this->data = mysqli_fetch_assoc($result);
                        }
                        function get_name() {return $this->data['full_name'];}
                        function get_username(){return $this->data['username'];}
                        function get_control_type(){return $this->data['control_type'];}


                        function fetch_statistics()
                        {
                            $connect = new connection;
                            $result = $connect->conn->query("SELECT * FROM users");
                            $users_no = mysqli_num_rows($result);
                            $result = $connect->conn->query("SELECT * FROM users WHERE is_online='YES'");
                            $online_no = mysqli_num_rows($result);
                            $result = $connect->conn->query("SELECT * FROM groups");
                            $groups_no = mysqli_num_rows($result);
                            $result = $connect->conn->query("SELECT * FROM pages");
                            $pages_no = mysqli_num_rows($result);
                            $result = $connect->conn->query("SELECT * FROM posts");
                            $posts_no = mysqli_num_rows($result);

                            echo'
                            <div class="data"><img src="assets/img/user_icon.png"><p>Total Users Number:</p><samp> '.$users_no.'</samp></div>
                            <div class="data"><img src="assets/img/online_icon.png"><p>Online Users Number:</p><samp> '.$online_no.'</samp></p></div>
                            <div class="data"><img src="assets/img/page_icon.png"><p>Total Pages Number:</p><samp> '.$pages_no.'</samp></p></div>
                            <div class="data"><img src="assets/img/group_icon.jpg"><p>Total Groups Number:</p><samp> '.$groups_no.'</samp> </p></div>
                            <div class="data"><img src="assets/img/post_icon.png"><p>Total Posts Number:</p><samp> '.$posts_no.'</samp></p></div>
                            <div class="data"><img src="assets/img/icn_msgx.png"><p>Total Messeges Number:</p><samp></samp></div>
                            <div class="data"><img src="assets/img/trend_icon.png"><p>Top Trends: </p></div>';
                        }
                        function ban_unit($pattern){

                            $connect = new connection;
                            if(strlen($pattern) < 2) return 'Invalid Pattern!';
                            if($pattern[0]=='G')
                            {
                                 $id=substr($pattern,1);   
                                 $result = $connect->conn->query("SELECT group_owner FROM groups WHERE id='$id'");
                                 if(mysqli_num_rows($result)==0)return 'No Matched Group!';
                                 $result = mysqli_fetch_assoc($result);
                                 $owner = $result['group_owner'];
                                 $myGroup = new group($owner,$id);
                                 $myGroup->delete_group();
                                 return 'Banned Successfully!';
                            }
                            else if($pattern[0]=='P')
                            {
                                $id=substr($pattern,1); 
                                $result = $connect->conn->query("SELECT page_owner FROM pages WHERE id='$id'");
                                if(mysqli_num_rows($result)==0)return 'No Matched Page!';
                                $result = mysqli_fetch_assoc($result);
                                $owner = $result['page_owner'];
                                $myPage = new page($owner,$id);
                                $myPage->delete_page();
                                return 'Banned Successfully!';  
  
                            }
                            else if($pattern[0]=='U')
                            {
                                $id=substr($pattern,1);  
                                $result = $connect->conn->query("SELECT * FROM users WHERE id='$id'");
                                if(mysqli_num_rows($result)==0)return 'No Matched Users!'; 
                                $user = new user($id);
                                $connect->conn->query("DELETE FROM posts WHERE post_from='$id'");  
                                $connect->conn->query("DELETE FROM notifications WHERE sender='$id'");  
                                $connect->conn->query("DELETE FROM marketplace WHERE seller='$id'");  
                                $connect->conn->query("DELETE FROM comments WHERE comment_from='$id'");  
                                $friends = $user->get_friends();
                                $friends_no = $user->get_friends_no();
                                $start = 0;
                                for($i=0; $i<$friends_no; $i++){
                                $end = strpos($friends,",",$start + 1);
                                $friend = substr($friends,$start,$end - $start);
                                $start = $end + 1;
                                friendship::removeFriend($id,$friend);
                                }
                                $results = $connect->conn->query("SELECT id FROM users WHERE fr_requests LIKE '%$id%' ");
                                for($i=0;$i<mysqli_num_rows($results);$i++){
                                $result = mysqli_fetch_assoc($results);
                                friendship::cancelRequest($id,$result['id']);
                                }
                                $groups = $user->get_groups();
                                $groups_no = $user->get_groups_no();
                                $start = 0;
                                for($i=0; $i<$groups_no; $i++){
                                $end = strpos($groups,",",$start + 1);
                                $group = new group($id,substr($groups,$start,$end - $start));
                                $start = $end + 1;
                                if($group->get_owner() == $id)$group->delete_group();
                                else $group->leave_group();
                                }
                                $results = $connect->conn->query("SELECT id FROM groups WHERE requests LIKE '%$id%' ");
                                for($i=0;$i<mysqli_num_rows($results);$i++){
                                $result = mysqli_fetch_assoc($results);
                                $group = new group($id,$result['id']);
                                $group->cancel_request();
                                }
                                $pages = $user->get_pages();
                                $pages_no = $user->get_pages_no();
                                $start = 0;
                                for($i=0; $i<$pages_no; $i++){
                                $end = strpos($pages,",",$start + 1);
                                $page = new page($id,substr($pages,$start,$end - $start));
                                $start = $end + 1;
                                if($page->get_owner() == $id)$page->delete_page();
                                else if(strstr($page->get_admins(),$id))
                                {
                                    $page->leave_admin();
                                    $page->unfollow_page();
                                }
                                else $page->unfollow_page();
                                }
                                $connect->conn->query("DELETE FROM users WHERE id='$id'"); 
                                return 'Banned Successfully!'; 
                            }
                            else return 'Invalid Pattern!';
                        }
                    }
                    class friendship{
                        static function isFriend($user_id,$target_id){
                            $user = new user($user_id);
                            return strstr($user->get_friends(),$target_id);
                        }
                        static function isFrRequest($user_id,$target_id){
                            $target= new user($target_id);
                            return strstr($target->get_fr_requests(),$user_id);
                        }
                        static function friendRequest($user_id,$target_id){
                            $connect = new connection;
                            $target = new user($target_id);
                            $fr_requests = $target->get_fr_requests().$user_id.",";
                            $connect->conn->query("UPDATE users SET fr_requests='$fr_requests' WHERE id='$target_id'");
                        }
                        static function cancelRequest($user_id,$target_id){
                            $connect = new connection;
                            $target = new user($target_id);
                            $fr_requests = str_replace($user_id.",","",$target->get_fr_requests());
                            $connect->conn->query("UPDATE users SET fr_requests='$fr_requests' WHERE id='$target_id'");
                        }
                        static function addFriend($user_id,$target_id){
                            $connect = new connection;
                            $user = new user($user_id);
                            $user_friends = $user->get_friends()."$target_id".",";
                            $user_friends_no = $user->get_friends_no() + 1;
                            $connect->conn->query("UPDATE users SET friends='$user_friends' WHERE id='$user_id'");
                            $connect->conn->query("UPDATE users SET friends_no='$user_friends_no' WHERE id='$user_id'");
                            $target = new user($target_id);
                            friendship::cancelRequest($target_id,$user_id);
                            $trg_friends = $target->get_friends()."$user_id".",";
                            $trg_friends_no = $target->get_friends_no() + 1;
                            $connect->conn->query("UPDATE users SET friends='$trg_friends' WHERE id='$target_id'");
                            $connect->conn->query("UPDATE users SET friends_no='$trg_friends_no' WHERE id='$target_id'");
                        }
                        static function removeFriend($user_id,$target_id){
                            $connect = new connection;
                            $user = new user($user_id);
                            $user_friends =  str_replace($target_id.",","",$user->get_friends());
                            $user_friends_no = $user->get_friends_no() - 1;
                            $connect->conn->query("UPDATE users SET friends='$user_friends' WHERE id='$user_id'");
                            $connect->conn->query("UPDATE users SET friends_no='$user_friends_no' WHERE id='$user_id'");
                            $target = new user($target_id);
                            $trg_friends = str_replace($user_id.",","",$target->get_friends());
                            $trg_friends_no = $target->get_friends_no() - 1;
                            $connect->conn->query("UPDATE users SET friends='$trg_friends' WHERE id='$target_id'");
                            $connect->conn->query("UPDATE users SET friends_no='$trg_friends_no' WHERE id='$target_id'");
                        } 
                    }
                    class notification{

                        private $connect;
                        private $con;
                        private $user_id;

                        function __construct($user_id){
                            $this->user_id = $user_id;
                            $this->connect = new connection;
                            $this->con = $this->connect->conn;
                        }

                        function get_noti(){
                            $all_notifications = $this->con->query("SELECT * from notifications WHERE receiver='$this->user_id' order by at_time desc LIMIT 8");
                            if(mysqli_num_rows($all_notifications)!=0){
                            for($i = 0; $i < mysqli_num_rows($all_notifications);$i++){
                            $notifications = mysqli_fetch_assoc($all_notifications);
                            $sender = new user($notifications['sender']);
                            $body = $notifications['body'];
                            $time = $notifications['at_time'];
                            echo '<div><a href="http://localhost/social-media-platform-web/'.$sender->get_id().'"><img src="http://localhost/social-media-platform-web/' .$sender->get_id().'/'.$sender->get_profile_pic().'"><a/><samp>'.date_optimize($time).'</samp><p>'.$sender->get_name()." ".$body.'</p></div>';
                            }
                            }
                            else echo '<p style="color:gray; font-size:120%; margin:30%;">No Notifications</p>'; 

                        }
                        function add_noti($target_id,$body){
                            $this->con->query("INSERT INTO notifications(sender,receiver,body) VALUES('$this->user_id','$target_id','$body')");
                            $this->con->query("UPDATE users SET new_noti='+' WHERE id='$target_id'");
                        }



                    }
                    class marketplace{
                        
                        private $seller_id;
                        private $seller;
                        private $products;
                        private $products_no;

                        function __construct($user_id){
                            $this->seller_id =$user_id;
                            $this->seller = new user($user_id);
                            $connect = new connection;
                            $this->products = $connect->conn->query("SELECT * FROM marketplace WHERE seller='$this->seller_id'");
                            $this->products_no=mysqli_num_rows($this->products);
                        }

                        function add_product($name,$desc,$pic){
                            $connect = new connection;
                            $connect->conn->query("INSERT INTO marketplace(seller,product_name,product_desc,product_pic) VALUES('$this->seller_id','$name','$desc','$pic')");
                            $this->products_no +=1;
                            $number = $this->products_no;
                            $connect->conn->query("UPDATE users SET products_no='$number' WHERE id='$this->seller_id'");
                        }

                        function remove_product($id){
                            $connect = new connection;
                            $connect->conn->query("DELETE FROM marketplace WHERE id='$id'");
                            $this->products_no -=1;
                            $number = $this->products_no;
                            $connect->conn->query("UPDATE users SET products_no='$number' WHERE id='$this->seller_id'");
                        }

                        function show_some_products(){
                            $limit = ($this->products_no <6)? $this->products_no:6;
                            for($i=0;$i<$limit;$i++){
                            $product=  mysqli_fetch_assoc($this->products);
                            echo    '<div class="dataunit">
                                        <img src="market/'. $product['product_pic'].'"><br>
                                        <a>'. $product['product_name'] . '</a>
                                    </div>';
                            }
                        }
                        function show_all_products($target_id){
                        if($this->seller_id == $target_id){
                            for($i=0;$i<$this->products_no;$i++){
                            $product=  mysqli_fetch_assoc($this->products);
                            echo' 
                             <div id="'.$product['id'].'">
                            <h3 style="padding:0;margin:0 10%;">'.$product['product_name'].'</h3>
                             <img src="market/'.$product['product_pic'].'"><div class="body"><p>'.$product['product_desc'].'</p></div>
                             <br><button onclick="x('.$product['id'].')" style="clear:left; margin:10px 0 2px 10%;">Remove Product</button>
                            </div>';
                            }
                        }
                        else{
                            for($i=0;$i<$this->products_no;$i++){
                                $product=  mysqli_fetch_assoc($this->products);
                                echo' 
                                 <div id="'.$product['id'].'">
                                <h3 style="padding:0;margin:0 10%;">'.$product['product_name'].'</h3>
                                 <img src="market/'.$product['product_pic'].'"><div class="body"><p>'.$product['product_desc'].'</p></div>
                                 <br><button name = '.$product['product_name'].' onclick="y(this.name)" style="clear:left; margin:10px 0 2px 10%;">Request Order</button>
                                </div>';
                                }
                            }
                        }
                    }
                    class post{
                        private $user_id;
                        function __construct($user_id){
                            $this->user_id =$user_id;
                        }
                        function write_post($body,$pattern){
                            $connect = new connection;
                            if($pattern[0]=='G'){$post_to ='group'; $post_to_id =substr($pattern,1);}
                            else if($pattern[0]=='P'){$post_to ='page'; $post_to_id =substr($pattern,1);}
                            else if($pattern[0]=='F'){$post_to ='friend'; $post_to_id =substr($pattern,1);}
                            else {$post_to ='home'; $post_to_id='';}
                            $connect->conn->query("INSERT INTO posts(post_from,post_to,post_to_id,body) VALUES('$this->user_id','$post_to','$post_to_id','$body')");
                        }
                        function load_timeline_posts($offset){
                            $connect = new connection;
                            $user = new user($this->user_id);
                            $friends = $this->user_id.','.$user->get_friends();
                            $groups = $user->get_groups();
                            $pages = $user->get_pages();
                            $posts = $connect->conn->query("SELECT * FROM posts WHERE ('$friends' LIKE CONCAT('%', post_from, '%') AND post_to='home') or ('$groups' LIKE CONCAT('%', post_to_id, '%') AND post_to='group') or ('$pages' LIKE CONCAT('%', post_to_id, '%') AND post_to='page')  order by date DESC LIMIT 5 OFFSET $offset");


                            if(mysqli_num_rows($posts) == 0){
                                echo'
                                <div class="post" style="text-align:center; background-color:transparent; width:60%;">
                                <p style="font-weight:bolder; color:indigo; ">Hurray! No More News.</p>
                                </div>';
                                $_SESSION['offset']=-1;
                            }

                            else{
                                for($i=0;$i<mysqli_num_rows($posts);$i++){
                                    $post = mysqli_fetch_assoc($posts);
                                    $writer = new user($post['post_from']);
                                    if($post['post_to']=='page'){
                                    $myPage = new page($this->user_id,$post['post_to_id']);

                                    echo' 
                                    <div class="post">
                                    <img src="http://localhost/social-media-platform-web/assets/img/page_icon.png">
                                    <p>'.$myPage->get_name().'</p>';

                                    }
                                    else{
                                    echo' 
                                    <div class="post">
                                    <img src="http://localhost/social-media-platform-web/'.$writer->get_id().'/'.$writer->get_profile_pic().'">
                                    <p>'.$writer->get_name().'</p>';
                                    }
                                    


                                    if($post['post_to']=='group'){
                                        $myGroup = new group($this->user_id,$post['post_to_id']);
                                        echo ' <p style="color:rgb(0,255,0); font-size:85%; margin:0 20px;"> (Group: '.$myGroup->get_name().')</p>';
                                    }
                            
                                    echo'<samp>'.date_optimize($post['date']).'</samp>
                                    <hr>
                                    <textarea readonly class="body">'.$post['body'].'</textarea>
                                    <div class="toolbar">';
                                    
                                    if(!(strstr($post['likes'],$this->user_id))) echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love1.png"></button>';
                                    else  echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love2.png"></button>';
                                    echo'
                                    <p id="l'.$post['id'].'">'.substr_count($post['likes'],",").'</p>
                                    <button  name="'.$post['id'].'" onclick="comment(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_comment.png"></button>
                                    <p>';
                                    $id = $post['id'];
                                    $comments = $connect->conn->query("SELECT * FROM comments WHERE post_id='$id'");
                                    echo mysqli_num_rows($comments);
                                    echo'</p>
                                    <button name="'.$post['id'].'" onclick="share(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_share.png"></button>
                                    <p id="s'.$post['id'].'">'.substr_count($post['shared'],",").'</p>';

                                    if(!(strstr($post['saved'],$this->user_id))) echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save1.png"></button>';
                                    else echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save2.png"></button>';  
                                    echo '</div>
                                    </div>';
                                }
                                $_SESSION['offset'] = $_SESSION['offset'] + mysqli_num_rows($posts); 
                            }
                        }
                        function load_profile_posts($offset){
                            $connect = new connection;
                            $user = new user($this->user_id);
                            $posts = $connect->conn->query("SELECT * FROM posts WHERE (post_from='$this->user_id' and post_to='home') or shared LIKE CONCAT('%', '$this->user_id', '%') order by date DESC LIMIT 5 OFFSET $offset");
                            
                            if(mysqli_num_rows($posts) == 0){
                                echo'
                                <div class="post" style="text-align:center; background-color:transparent; width:60%;">
                                <p style="font-weight:bolder; color:indigo; ">No More Posts.</p>
                                </div>';
                                $_SESSION['offset']=-1;
                            }

                            else{
                                for($i=0;$i<mysqli_num_rows($posts);$i++){
                                    $post = mysqli_fetch_assoc($posts);
                                    $writer = new user($post['post_from']);
                                    echo' 
                                    <div class="post">
                                    <img src="http://localhost/social-media-platform-web/'.$writer->get_id().'/'.$writer->get_profile_pic().'">
                                    <p>'.$writer->get_name();
                                    if(strstr($post['shared'],$this->user_id)) echo '<samp style="color:rgb(0,255,0); font-size:80%;"> (Shared By '.$user->get_name().')</samp>'; 
                                    echo '</p>
                                    <samp>'.date_optimize($post['date']).'</samp>
                                    <hr>
                                    <textarea readonly class="body">'.$post['body'].'</textarea>
                                    <div class="toolbar">';
                                    
                                    if(!(strstr($post['likes'],$this->user_id))) echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love1.png"></button>';
                                    else  echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love2.png"></button>';
                                    echo'
                                    <p id="l'.$post['id'].'">'.substr_count($post['likes'],",").'</p>
                                    <button  name="'.$post['id'].'" onclick="comment(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_comment.png"></button>
                                    <p>';
                                    $id = $post['id'];
                                    $comments = $connect->conn->query("SELECT * FROM comments WHERE post_id='$id'");
                                    echo mysqli_num_rows($comments);
                                    echo'</p>
                                    <button name="'.$post['id'].'" onclick="share(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_share.png"></button>
                                    <p id="s'.$post['id'].'">'.substr_count($post['shared'],",").'</p>';

                                    if(!(strstr($post['saved'],$this->user_id))) echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save1.png"></button>';
                                    else echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save2.png"></button>';  
                                    echo '</div>
                                    </div>';
                                }
                                $_SESSION['offset'] = $_SESSION['offset'] + mysqli_num_rows($posts); 
                            }
                        }

                        function load_saved_posts($offset){
                            $connect = new connection;
                            $user = new user($this->user_id);
                            $posts = $connect->conn->query("SELECT * FROM posts WHERE saved LIKE CONCAT('%', $this->user_id, '%') order by date DESC LIMIT 5 OFFSET $offset");
                            
                            if(mysqli_num_rows($posts) == 0){
                                echo'
                                <div class="post" style="text-align:center; background-color:transparent; width:60%;">
                                <p style="font-weight:bolder; color:indigo; ">No More Saved Posts.</p>
                                </div>';
                                $_SESSION['offset']=-1;
                            }

                            else{
                                for($i=0;$i<mysqli_num_rows($posts);$i++){
                                    $post = mysqli_fetch_assoc($posts);
                                    $writer = new user($post['post_from']);
                                    echo' 
                                    <div class="post">
                                    <img src="http://localhost/social-media-platform-web/'.$writer->get_id().'/'.$writer->get_profile_pic().'">
                                    <p>'.$writer->get_name().'</p>
                                    <samp>'.date_optimize($post['date']).'</samp>
                                    <hr>
                                    <textarea readonly class="body">'.$post['body'].'</textarea>
                                    <div class="toolbar">';
                                    
                                    if(!(strstr($post['likes'],$this->user_id))) echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love1.png"></button>';
                                    else  echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love2.png"></button>';
                                    echo'
                                    <p id="l'.$post['id'].'">'.substr_count($post['likes'],",").'</p>
                                    <button  name="'.$post['id'].'" onclick="comment(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_comment.png"></button>
                                    <p>';
                                    $id = $post['id'];
                                    $comments = $connect->conn->query("SELECT * FROM comments WHERE post_id='$id'");
                                    echo mysqli_num_rows($comments);
                                    echo'</p>
                                    <button name="'.$post['id'].'" onclick="share(this.name)" ><img  src="http://localhost/social-media-platform-web/assets/img/post_share.png"></button>
                                    <p id="s'.$post['id'].'">'.substr_count($post['shared'],",").'</p>';

                                    if(!(strstr($post['saved'],$this->user_id))) echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save1.png"></button>';
                                    else echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save2.png"></button>';  
                                    echo '</div>
                                    </div>';
                                }
                                $_SESSION['offset'] = $_SESSION['offset'] + mysqli_num_rows($posts); 
                            }
                        }


                        function load_group_posts($offset,$group_id){
                            $connect = new connection;
                            $user = new user($this->user_id);
                            $posts = $connect->conn->query("SELECT * FROM posts WHERE post_to='group' and post_to_id='$group_id' order by date DESC LIMIT 5 OFFSET $offset");
                            
                            if(mysqli_num_rows($posts) == 0){
                                echo'
                                <div class="post" style="text-align:center; background-color:transparent; width:60%;">
                                <p style="font-weight:bolder; color:indigo; ">No More Group Posts.</p>
                                </div>';
                                $_SESSION['offset']=-1;
                            }

                            else{
                                for($i=0;$i<mysqli_num_rows($posts);$i++){
                                    $post = mysqli_fetch_assoc($posts);
                                    $writer = new user($post['post_from']);
                                    echo' 
                                    <div class="post">
                                    <img src="http://localhost/social-media-platform-web/'.$writer->get_id().'/'.$writer->get_profile_pic().'">
                                    <p>'.$writer->get_name().'</p>
                                    <samp>'.date_optimize($post['date']).'</samp>
                                    <hr>
                                    <textarea readonly class="body">'.$post['body'].'</textarea>
                                    <div class="toolbar">';
                                    
                                    if(!(strstr($post['likes'],$this->user_id))) echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love1.png"></button>';
                                    else  echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love2.png"></button>';
                                    echo'
                                    <p id="l'.$post['id'].'">'.substr_count($post['likes'],",").'</p>
                                    <button  name="'.$post['id'].'" onclick="comment(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_comment.png"></button>
                                    <p>';
                                    $id = $post['id'];
                                    $comments = $connect->conn->query("SELECT * FROM comments WHERE post_id='$id'");
                                    echo mysqli_num_rows($comments);
                                    echo'</p>
                                    <button name="'.$post['id'].'" onclick="share(this.name)" ><img  src="http://localhost/social-media-platform-web/assets/img/post_share.png"></button>
                                    <p id="s'.$post['id'].'">'.substr_count($post['shared'],",").'</p>';

                                    if(!(strstr($post['saved'],$this->user_id))) echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save1.png"></button>';
                                    else echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save2.png"></button>';  
                                    echo '</div>
                                    </div>';
                                }
                                $_SESSION['offset'] = $_SESSION['offset'] + mysqli_num_rows($posts); 
                            }
                        }



                        function load_page_posts($offset,$page_id){
                            $connect = new connection;
                            $user = new user($this->user_id);
                            $posts = $connect->conn->query("SELECT * FROM posts WHERE post_to='page' and post_to_id='$page_id' order by date DESC LIMIT 5 OFFSET $offset");
                            
                            if(mysqli_num_rows($posts) == 0){
                                echo'
                                <div class="post" style="text-align:center; background-color:transparent; width:60%;">
                                <p style="font-weight:bolder; color:indigo; ">No More Page Posts.</p>
                                </div>';
                                $_SESSION['offset']=-1;
                            }

                            else{
                                for($i=0;$i<mysqli_num_rows($posts);$i++){
                                    $post = mysqli_fetch_assoc($posts);
                                    $myPage = new page($_SESSION['user']->get_id(),$page_id);
                                    echo' 
                                    <div class="post">
                                    <img src="http://localhost/social-media-platform-web/assets/img/page_icon.png">
                                    <p>'.$myPage->get_name().'</p>
                                    <samp>'.date_optimize($post['date']).'</samp>
                                    <hr>
                                    <textarea readonly class="body">'.$post['body'].'</textarea>
                                    <div class="toolbar">';
                                    
                                    if(!(strstr($post['likes'],$this->user_id))) echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love1.png"></button>';
                                    else  echo '<button style="margin-top: 0px;" name="'.$post['id'].'" onclick="love(this.name)"><img id="love'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_love2.png"></button>';
                                    echo'
                                    <p id="l'.$post['id'].'">'.substr_count($post['likes'],",").'</p>
                                    <button  name="'.$post['id'].'" onclick="comment(this.name)" ><img src="http://localhost/social-media-platform-web/assets/img/post_comment.png"></button>
                                    <p>';
                                    $id = $post['id'];
                                    $comments = $connect->conn->query("SELECT * FROM comments WHERE post_id='$id'");
                                    echo mysqli_num_rows($comments);
                                    echo'</p>
                                    <button name="'.$post['id'].'" onclick="share(this.name)" ><img  src="http://localhost/social-media-platform-web/assets/img/post_share.png"></button>
                                    <p id="s'.$post['id'].'">'.substr_count($post['shared'],",").'</p>';

                                    if(!(strstr($post['saved'],$this->user_id))) echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save1.png"></button>';
                                    else echo '<button name="'.$post['id'].'" onclick="save(this.name)" ><img id="save'.$post['id'].'" src="http://localhost/social-media-platform-web/assets/img/post_save2.png"></button>';  
                                    echo '</div>
                                    </div>';
                                }
                                $_SESSION['offset'] = $_SESSION['offset'] + mysqli_num_rows($posts); 
                            }
                        }



                        function love_post($post_id){
                            $connect = new connection;
                            $likes = $connect->conn->query("SELECT likes FROM posts WHERE id='$post_id'");
                            $likes = mysqli_fetch_assoc($likes);
                            $likes = $likes['likes'];
                            if(!(strstr($likes,$this->user_id)))$likes = $likes.$this->user_id.",";
                            else $likes =  str_replace($this->user_id.",","",$likes);
                            $connect->conn->query("UPDATE posts SET likes='$likes' WHERE id='$post_id'");
                        }
                        function share_post($post_id){
                            $stat = 0;
                            $connect = new connection;
                            $shares = $connect->conn->query("SELECT shared FROM posts WHERE id='$post_id'");
                            $shares = mysqli_fetch_assoc($shares);
                            $shares = $shares['shared'];
                            if(!(strstr($shares,$this->user_id)))
                            {
                                $shares = $shares.$this->user_id.",";
                                $stat = 1;
                            }
                            $connect->conn->query("UPDATE posts SET shared='$shares' WHERE id='$post_id'");
                            return $stat;
                        }
                        function save_post($post_id){
                            $connect = new connection;
                            $saves = $connect->conn->query("SELECT saved FROM posts WHERE id='$post_id'");
                            $saves = mysqli_fetch_assoc($saves);
                            $saves = $saves['saved'];
                            if(!(strstr($saves,$this->user_id)))$saves = $saves.$this->user_id.",";
                            else $saves =  str_replace($this->user_id.",","",$saves);
                            $connect->conn->query("UPDATE posts SET saved='$saves' WHERE id='$post_id'");
                        }
                        function write_comment($post_id,$body){
                            $connect = new connection;
                            $connect->conn->query("INSERT INTO comments(post_id,comment_from,body) VALUES('$post_id','$this->user_id','$body')");
                        }
                        function load_comments($post_id){
                            $connect = new connection;
                            $comments = $connect->conn->query("SELECT * FROM comments WHERE post_id='$post_id'");
                            
                            for($i=0;$i<mysqli_num_rows($comments);$i++){
                            $comment = mysqli_fetch_assoc($comments);
                            $user = new user($comment['comment_from']);
                            echo' <div class="comment">
                            <div class="who">
                                <img src="http://localhost/social-media-platform-web/'.$user->get_id()."/".$user->get_profile_pic().'">
                                <p>'.$user->get_name().'</p>
                                <p>'.date_optimize($comment['date']).'</p>
                            </div>
                            <textarea readonly>'.$comment['body'].'</textarea>
                            </div>';
                            }
                        }
                    }
                    class group{
                        private $user_id;
                        private $user;
                        private $group_id;
                        private $data;

                        function __construct($user_id,$group_id){
                            $this->user_id = $user_id;
                            $this->user = new user($user_id);
                            $this->group_id = $group_id;
                            $connect = new connection;
                            $result = $connect->conn->query("SELECT * FROM groups WHERE id='$group_id'");
                            $this->data = mysqli_fetch_assoc($result);
                        }
                        function get_id(){return $this->data['id'];}
                        function get_name(){return $this->data['group_name'];}
                        function get_owner(){return $this->data['group_owner'];}
                        function get_members(){return $this->data['members'];}
                        function get_members_no(){return $this->data['members_no'];}
                        function get_requests(){return $this->data['requests'];}
                        function get_requests_no(){return $this->data['requests_no'];}
                        static function create($name,$user_id){
                            $connect = new connection;
                            $connect->conn->query("INSERT INTO groups(group_name,group_owner) VALUES('$name','$user_id')");
                            $last_id = $connect->conn->insert_id;
                            $result = $connect->conn->query("SELECT groups,groups_no FROM users WHERE id='$user_id'");
                            $result = mysqli_fetch_assoc($result);
                            $groups = $result['groups'].$last_id.",";
                            $num = $result['groups_no'] + 1;
                            $connect->conn->query("UPDATE users SET groups='$groups' WHERE id='$user_id'");
                            $connect->conn->query("UPDATE users SET groups_no='$num' WHERE id='$user_id'");
                        }
                        function join_group(){
                        $connect = new connection;
                        $requests = $this->get_requests().$this->user_id.",";
                        $requests_no = $this->get_requests_no() + 1;
                        $connect->conn->query("UPDATE groups SET requests='$requests' WHERE id='$this->group_id'");
                        $connect->conn->query("UPDATE groups SET requests_no='$requests_no' WHERE id='$this->group_id'");
                        }
                        function cancel_request(){
                        $connect = new connection;
                        $requests = str_replace($this->user_id.",","",$this->get_requests());
                        $requests_no = $this->get_requests_no() - 1;
                        $connect->conn->query("UPDATE groups SET requests='$requests' WHERE id='$this->group_id'");
                        $connect->conn->query("UPDATE groups SET requests_no='$requests_no' WHERE id='$this->group_id'");
                        }
                        function leave_group(){
                        $connect = new connection;
                        $members = str_replace($this->user_id.",","",$this->get_members());
                        $members_no=$this->get_members_no() - 1;
                        $connect->conn->query("UPDATE groups SET members='$members' WHERE id='$this->group_id'");
                        $connect->conn->query("UPDATE groups SET members_no='$members_no' WHERE id='$this->group_id'");
                        $user = new user($this->user_id);
                        $groups = str_replace($this->group_id.",","",$user->get_groups());
                        $num = $user->get_groups_no() -1;
                        $connect->conn->query("UPDATE users SET groups='$groups' WHERE id='$this->user_id'");
                        $connect->conn->query("UPDATE users SET groups_no='$num' WHERE id='$this->user_id'");
                        }
                        function delete_group(){
                            $connect = new connection;
                            $members = $this->get_members().$this->user_id.",";
                            $members_no = $this->get_members_no() + 1;

                            if($members_no!=0){
                                $start = 0;
                                for($i = 0; $i <$members_no; $i++){
                                $end = strpos($members,",",$start + 1);
                                $user = new user(substr($members,$start,$end - $start));
                                $start = $end + 1;
                                $groups = str_replace($this->group_id.",","",$user->get_groups());
                                $num = $user->get_groups_no() -1;
                                $user_id = $user->get_id();
                                $connect->conn->query("UPDATE users SET groups='$groups' WHERE id='$user_id'");
                                $connect->conn->query("UPDATE users SET groups_no='$num' WHERE id='$user_id'");
                                }
                            }
                            $connect->conn->query("DELETE FROM posts WHERE post_to='group' and post_to_id='$this->group_id'");  
                            $connect->conn->query("DELETE FROM groups WHERE id='$this->group_id'");  
                        }
                        function accept_request($id){
                            $connect = new connection;
                            $requests = str_replace($id.",","",$this->get_requests());
                            $requests_no = $this->get_requests_no() - 1;
                            $connect->conn->query("UPDATE groups SET requests='$requests' WHERE id='$this->group_id'");
                            $connect->conn->query("UPDATE groups SET requests_no='$requests_no' WHERE id='$this->group_id'");
                            $user = new user($id);
                            $groups = $user->get_groups().$this->group_id.",";
                            $num = $user->get_groups_no() +1;
                            $connect->conn->query("UPDATE users SET groups='$groups' WHERE id='$id'");
                            $connect->conn->query("UPDATE users SET groups_no='$num' WHERE id='$id'");
                            $members=$this->get_members().$id.",";
                            $members_no=$this->get_members_no() + 1;
                            $connect->conn->query("UPDATE groups SET members='$members' WHERE id='$this->group_id'");
                            $connect->conn->query("UPDATE groups SET members_no='$members_no' WHERE id='$this->group_id'");
                        }
                        function refuse_request($id){
                            $connect = new connection;
                            $requests = str_replace($id.",","",$this->get_requests());
                            $requests_no = $this->get_requests_no() - 1;
                            $connect->conn->query("UPDATE groups SET requests='$requests' WHERE id='$this->group_id'");
                            $connect->conn->query("UPDATE groups SET requests_no='$requests_no' WHERE id='$this->group_id'");  
                        }
                        function kick_member($id){
                            $connect = new connection;
                            $user = new user($id);
                            $groups = str_replace($this->group_id.",","",$user->get_groups());
                            $num = $user->get_groups_no() -1;
                            $connect->conn->query("UPDATE users SET groups='$groups' WHERE id='$id'");
                            $connect->conn->query("UPDATE users SET groups_no='$num' WHERE id='$id'");
                            
                            $members= str_replace($id.",","",$this->get_members());
                            $members_no=$this->get_members_no() - 1;
                            $connect->conn->query("UPDATE groups SET members='$members' WHERE id='$this->group_id'");
                            $connect->conn->query("UPDATE groups SET members_no='$members_no' WHERE id='$this->group_id'");
                        }

                    }
                    class page{
                        private $user_id;
                        private $user;
                        private $page_id;
                        private $data;

                        function __construct($user_id,$page_id){
                            $this->user_id = $user_id;
                            $this->user = new user($user_id);
                            $this->page_id = $page_id;
                            $connect = new connection;
                            $result = $connect->conn->query("SELECT * FROM pages WHERE id='$page_id'");
                            $this->data = mysqli_fetch_assoc($result);
                        }
                        function get_id(){return $this->data['id'];}
                        function get_name(){return $this->data['page_name'];}
                        function get_owner(){return $this->data['page_owner'];}
                        function get_admins(){return $this->data['admins'];}
                        function get_admins_no(){return $this->data['admins_no'];}
                        function get_followers(){return $this->data['followers'];}
                        function get_followers_no(){return $this->data['followers_no'];}
                        static function create($name,$user_id){
                            $connect = new connection;
                            $connect->conn->query("INSERT INTO pages(page_name,page_owner) VALUES('$name','$user_id')");
                            $last_id = $connect->conn->insert_id;
                            $result = $connect->conn->query("SELECT pages,pages_no FROM users WHERE id='$user_id'");
                            $result = mysqli_fetch_assoc($result);
                            $pages = $result['pages'].$last_id.",";
                            $num = $result['pages_no'] + 1;
                            $connect->conn->query("UPDATE users SET pages='$pages' WHERE id='$user_id'");
                            $connect->conn->query("UPDATE users SET pages_no='$num' WHERE id='$user_id'");
                        }

                        function follow_page(){
                            $connect = new connection;
                            $followers = $this->get_followers().$this->user_id.",";
                            $followers_no = $this->get_followers_no() + 1;
                            $connect->conn->query("UPDATE pages SET followers='$followers' WHERE id='$this->page_id'");
                            $connect->conn->query("UPDATE pages SET followers_no='$followers_no' WHERE id='$this->page_id'");
                            $id = $this->user_id;
                            $user = new user($id);
                            $pages = $user->get_pages().$this->page_id.",";
                            $num = $user->get_pages_no() +1;
                            $connect->conn->query("UPDATE users SET pages='$pages' WHERE id='$id'");
                            $connect->conn->query("UPDATE users SET pages_no='$num' WHERE id='$id'");
                            }
                            function unfollow_page(){
                            $connect = new connection;
                            $followers = str_replace($this->user_id.",","",$this->get_followers());
                            $followers_no = $this->get_followers_no() - 1;
                            $connect->conn->query("UPDATE pages SET followers='$followers' WHERE id='$this->page_id'");
                            $connect->conn->query("UPDATE pages SET followers_no='$followers_no' WHERE id='$this->page_id'");
                            $id = $this->user_id;
                            $user = new user($id);
                            $pages = str_replace($this->page_id.",","",$user->get_pages());
                            $num = $user->get_pages_no() - 1;
                            $connect->conn->query("UPDATE users SET pages='$pages' WHERE id='$id'");
                            $connect->conn->query("UPDATE users SET pages_no='$num' WHERE id='$id'");
                            }
                            function give_admin($id){
                            $connect = new connection;
                            $followers = str_replace($id.",","",$this->get_followers());
                            $followers_no = $this->get_followers_no() - 1;
                            $connect->conn->query("UPDATE pages SET followers='$followers' WHERE id='$this->page_id'");
                            $connect->conn->query("UPDATE pages SET followers_no='$followers_no' WHERE id='$this->page_id'");
                            $admins = $this->get_admins().$id.",";
                            $admins_no = $this->get_admins_no() + 1;
                            $connect->conn->query("UPDATE pages SET admins='$admins' WHERE id='$this->page_id'");
                            $connect->conn->query("UPDATE pages SET admins_no='$admins_no' WHERE id='$this->page_id'");
                            }
                            function take_admin($id){
                            $connect = new connection;
                            $followers =  $this->get_followers().$id.",";
                            $followers_no = $this->get_followers_no() + 1;
                            $connect->conn->query("UPDATE pages SET followers='$followers' WHERE id='$this->page_id'");
                            $connect->conn->query("UPDATE pages SET followers_no='$followers_no' WHERE id='$this->page_id'");
                            $admins = str_replace($id.",","",$this->get_admins());
                            $admins_no = $this->get_admins_no() - 1;
                            $connect->conn->query("UPDATE pages SET admins='$admins' WHERE id='$this->page_id'");
                            $connect->conn->query("UPDATE pages SET admins_no='$admins_no' WHERE id='$this->page_id'");
                            }
                            function leave_admin(){
                            $this->take_admin($this->user_id);
                            }
                            function delete_page(){

                                $connect = new connection;
                                $members = $this->get_followers().$this->get_admins().$this->get_owner().",";
                                $members_no = $this->get_followers_no() + $this->get_admins_no() + 1;
    
                                if($members_no!=0){
                                    $start = 0;
                                    for($i = 0; $i <$members_no; $i++){
                                    $end = strpos($members,",",$start + 1);
                                    $user = new user(substr($members,$start,$end - $start));
                                    $start = $end + 1;
                                    $pages = str_replace($this->page_id.",","",$user->get_pages());
                                    $num = $user->get_pages_no() -1;
                                    $user_id = $user->get_id();
                                    $connect->conn->query("UPDATE users SET pages='$pages' WHERE id='$user_id'");
                                    $connect->conn->query("UPDATE users SET pages_no='$num' WHERE id='$user_id'");
                                    }
                                }

                                $connect->conn->query("DELETE FROM posts WHERE post_to='page' and post_to_id='$this->page_id'");  
                                $connect->conn->query("DELETE FROM pages WHERE id='$this->page_id'");  

                            }

                    }
                    class dynamic_validation{

                        private $errors = array("</br>");
                        private $name_c = "/^[A-Za-z-']+$/";
                        private $name_c2 = "/[A-Za-z-']{2,10}/";
                        private $email_c = "/[@]/";
                        private $pass_c = "/^[A-Za-z0-9]{8,16}$/";
                        private $pass_c2 = "/[0-9]+/";
                        private $pass_c3 = "/[A-Za-z]+/";
                        private $phone_c = "/^[0-9+][0-9]{8,15}$/";
                        private $error_1 = "The name must contains only Alphabet letters!";
                        private $error_2 = "Please Enter a real first name!";
                        private $error_1L = "The last name must contains only Alphabet letters!";
                        private $error_2L = "Please Enter a real last name!";
                        private $error_3 = "The email must be vaild!";
                        private $error_4 = "Email is already used!";
                        private $error_5 = "The password [8-16 Digits] must contains at least one letter and number!";
                        private $error_6 = "The Password doesnt match the Re-Password!";
                        private $error_7 = "The phone must be valid and contains only digits!";
                        private $error_8 = "Sorry, You shoud be at least 13 Years old to sign up!";
                        private $pw = "";
           
                        
                        function validate($input,$type,$conn){
                            switch ($type) {
                                case "f_name"   :
                                    $valid = preg_match($this->name_c,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_1);
                                    else if($valid==FALSE) $this->add_error($this->error_1);
                                    $valid = preg_match($this->name_c2,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_2);
                                    else if($valid==FALSE) $this->add_error($this->error_2);
                                break;
                                case "l_name":
                                    $valid = preg_match($this->name_c,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_1L);
                                    else if($valid==FALSE) $this->add_error($this->error_1L);
                                    $valid = preg_match($this->name_c2,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_2L);
                                    else if($valid==FALSE) $this->add_error($this->error_2L);
                                break;
                                case "email":
                                    $valid = preg_match($this->email_c,$input);
                                    if($valid) $this->remove_error($this->error_3);
                                    else $this->add_error($this->error_3);
                                    $result = $conn->query("SELECT * FROM users WHERE email='$input'");                         
                                    $valid = (mysqli_num_rows($result) == 0)? TRUE:FALSE;
                                    if($valid) $this->remove_error($this->error_4);
                                    else $this->add_error($this->error_4);
                                break;
                                case "password":
                                    $this->pw = $input;
                                    $valid = preg_match($this->pass_c,$input);
                                    $valid *= preg_match($this->pass_c2,$input);
                                    $valid *= preg_match($this->pass_c3,$input);
                                    if($valid) $this->remove_error($this->error_5);
                                    else $this->add_error($this->error_5);
                                break;
                                case "password2":
                                    $valid = ($input == $this->pw)? TRUE:False;
                                    if($valid) $this->remove_error($this->error_6);
                                    else $this->add_error($this->error_6);
                                break;
                                case "phone_num":
                                    $valid = preg_match($this->phone_c,$input);
                                    if($valid) $this->remove_error($this->error_7);
                                    else $this->add_error($this->error_7);
                                break;
                                case "birth_date":
                                    $datebirth = date_create($input);
                                    $datecurrent = date_create();
                                    $interval = date_diff($datecurrent, $datebirth);
                                    $valid = ($interval->format('%y') >= 13)? TRUE:False;
                                    if($valid) $this->remove_error($this->error_8);
                                    else $this->add_error($this->error_8);
                                break;
                            }    
                            return $this->errors;
                        }

                        private function add_error($str){
                            if(!in_array($str,$this->errors))
                            array_push($this->errors,$str);

                        }
                        private function remove_error($str){
                            if(in_array($str,$this->errors)){
                            $k = array_search($str,$this->errors);
                            unset($this->errors[$k]);
                            }
                        }
                        function get_errors(){
                            return $this->errors;
                        }
                    }
                    //Some Functions
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
                    function date_optimize($input) {

                        $date = date_create($input);
                        $current = date_create();
                        date_add($current,date_interval_create_from_date_string("1 hour"));
                        $interval = date_diff($current,$date);

                        if($interval->format('%m') !=0) return $interval->format('%m months ago.');
                        else if($interval->format('%d') !=0) return $interval->format('%d days ago.');
                        else if($interval->format('%h') !=0) return $interval->format('%hh, %im ago.');
                        else if($interval->format('%i') !=0) return $interval->format('%i minutes ago.');
                        else return 'few seconds ago.';
                    }

?>