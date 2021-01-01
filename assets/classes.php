<?php

                    //CLASS >> CURRENT USER DATA
                    class user{

                        private $data;

                        function __construct($logID){
                            //get user data from parameter (username or email)
                            $connect = new connection;
                            $result = $connect->conn->query("SELECT * FROM users WHERE id='$logID' or email='$logID' or phone_num='$logID'");
                            $this->data = mysqli_fetch_assoc($result);
                        }

                        function get_name() {return $this->data['f_name']." ".$this->data['l_name'];}
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
                        function getnumofposts()
                        {
                            $connect = new connection;
                            $id=$this->get_id();
                            $query=mysqli_query($connect->conn,"SELECT no_post FROM users WHERE id='$id'");
                            $row=mysqli_fetch_array($query);
                            return $row['no_post'];
                    
                        }
                        function isclosed()
                                {
                                    $connect = new connection;
                                    $id=$this->get_id();
                                    $query=mysqli_query($connect->conn,"SELECT user_closed FROM users WHERE id='$id'");
                                    $row=mysqli_fetch_array($query);
                                    if($row['user_closed']=='yes')
                                    {
                                        return true;
                                    }
                                    else
                                    {
                                        return false;
                                    }
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

                    //CLASS >> FRIENDSHIP
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
                    //CLASS >> CONNECTION TO DATABASE
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
                    //CLASS >> DYNAMIC VALIDATE THE INPUT 
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
                    //FUNCTION >> CLEAR THE INPUT 
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }


                    
?>

<?php
// 
class Post
{
    private $user_obj;
    //$connect 
    private $con;
    public function __construct($con,$user)
    {
        //connect to the data base
        $this->con=$con;
        $this->user_obj=new user($user);
    }
    //get fpost
    public function submitpost($body, $user_to)
    {
        $body=strip_tags($body);//strip html tags
        $body=mysqli_real_escape_string($this->con,$body);//escape the quotes ti ignore mi$smatch
        $body=str_replace('\r\n', '\n',$body);
        $body=nl2br($body);
        $chech_space=preg_replace('/\s+/','',$body);//erase any space
       //check spaces
        if($chech_space !="")
        {
            //current date and time 
            $date_added=date("Y-m-d H:i:S");
            // added by 
            $added_by=$this->user_obj->get_id();
            if($user_to ==$added_by)
            {
                $user_to="none";
            }
            //insert post into database
            $insert=mysqli_query($this->con,"INSERT INTO posts VALUES ('','$body','$added_by','$date_added','$user_to','no','0','no')");
           // $database=mysqli_query($htis->con," INSERT INTO posts VALUES  ('','alaa','alaa','2020-6-12','alaa','no','no','0')");
            $returned_id=mysqli_insert_id($this->con);
            //insert notifiacations
            //update post count for user
            $no_post=$this->user_obj->getnumofposts();
            $no_post++;
            $update_query=mysqli_query($this->con,"UPDATE users SET no_post='$no_post' WHERE id='$added_by' ");





        }
    }
    // load post function 
    public function loadpostfriends($data, $limit)
    {
        //from ajax
        $page=$data['page'];
        $userloggedin=$this->user_obj->get_id();

        if ($page==1)
        {
            $start=0;
        }
        else
        {
        $start=($page - 1) * $limit;
        }
        
        $str="";//string to return
        $data_query=mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");
        if(mysqli_num_rows($data_query) > 0)
        {
            
            $num_iterations=0; // number of posts checked 
            $count=1;

            //fetch data
            while($row=mysqli_fetch_array($data_query))
            {
                
                $body=$row['body'];
                $id=$row['id'];
                $added_by=$row['added_by'];
                $date_time=$row['date_added'];
                
                //if user to is none 
                if($row['user_to']=="none")
                {
                    $user_to="";
                }   
                else
                {
                    $user_to_obj=new user($row['user_to']);
                    $user_to_name=$user_to_obj->get_name();
                    $user_to="to <a href='".$row['user_to'] ."'>".$user_to_name."</a>";
                }    
                //if the user closed 
                $added_by_obj=new user($added_by);
                if($added_by_obj->isclosed())
                {
                    continue;
                }  //User
                //check if the user friend
                
                $user_logged_obj= new user($userloggedin);
                if(friendship::isFriend($userloggedin,$added_by) || $added_by==$userloggedin){
                
                
                    if($num_iterations ++ < $start)
                    {
                        continue;
                    }
                    //once 10 posts have been loaded break
                        if($count > $limit)
                        {
                            break;
                        }
                        else
                        {
                            $count++;
                        }
                    if($userloggedin==$added_by)
                    {
                        $delete_button="<button id='post$id'>delete</button>";
                    }
                    else
                    {
                         $delete_button="";
                    }
                    //user details
                    $user_details=mysqli_query($this->con, "SELECT f_name,l_name,profile_pic FROM users WHERE id='$added_by'");
                    $user_row=mysqli_fetch_array($user_details);
                    $first_name=$user_row['f_name'];
                    $last_name=$user_row['l_name'];
                    $profile_pic=$added_by."/".$user_row['profile_pic']; // to get profile

                    ?>
					<script> 
						function toggle<?php echo $id; ?>() {
                            var target=$(event.target);
                            if(!target.is("a"))
                            {
 							
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
                            }	
						}

					</script>
					<?php
                    // check num of comments
                    $comment_check=mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
                    $comment_check_num=mysqli_num_rows($comment_check);
                    //time frame
                    $date_time_now=date("Y-m-d H:i:s");//teh current date
                    $start_date=new DateTime($date_time);//time of post
                    $end_date=new DateTime($date_time_now);// current time 
                    $interval=$start_date->diff($end_date);//time difference 
                    if($interval->y >=1)
                    {
                        if($interval==1)
                        {
                            $time_message=$interval->y . "year ago";    //1 year ago
                        }
                        else
                        {
                            $time_message=$interval->y . "years ago";    //1 year ago
                        }
                    }
                else if($interval->m >=1)
                    {
                        if($interval->d ==0)
                        {
                            $days="ago";
                        }
                        else if($interval->d ==1)
                        {
                            $days=$interval->d ."day ago";
                        }
                        else
                        {
                            $days=$interval->d ."days ago";
                        }
                        //if m =1
                        if($interval->m==1){
                            $time_message= $interval->m ."month". $days;
                        }
                        else{
                            $time_message=$interval->m ."months".$days;
                        }
                    }
                    // for days only i.e 12 days ago 
                else if($interval->d >=1)
                    {
                        if($interval->d ==1)
                        {
                            $days="yesterday";
                        }
                        else
                        {
                            $days=$interval->d ."days ago";
                        }
                    }
                    else if($interval->h >=1)
                    {   
                        if($interval->h ==1)
                        {
                            $time_message=$interval->h ."hour ago";
                        }
                        else
                        {
                            $time_message=$interval->h ."hours ago";
                        }
                    }
                    else if($interval->i >=1)
                    {   
                        if($interval->i ==1)
                        {
                            $time_message=$interval->i ."minute ago";
                        }
                        else
                        {
                            $time_message=$interval->i ."minutes ago";
                        }
                    }
                    else
                    {
                        if($interval->s <30)
                        {   
                            $time_message="just now";
                        }        
                        else
                        {
                            $time_message=$interval->s ."seconds ago";
                        }
                    }
                    // on click msh sh8ala enma ama b3mlha display block btzhr requested url not found
                    $str.="<div class='status_post' onClick='javascript:toggle$id()'>
                        <div class='post_profile_pic'>
                        <img src='$profile_pic' width='50'>
                        </div>

                    <div class='posted_by' style='color:#ACACAC;'>
                    <a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
                    $delete_button
                    </div>
                    <div id='post_body'>
                    $body
                    <br>
                    </div>
                    <div class ='newsfeed'>
                    $comment_check_num comments &nbsp;&nbsp;&nbsp;
                    <iframe src='like.php?post_id=$id' scrolling ='no' frameborder='0'></iframe>
                    
                    </div>
                    </div>
                    <div class='post_comment' id='toggleComment$id' style='display:none;'>
                    <iframe src='comment_frame.php?post_id=$id' id='comment_iframe'frameborder='0' ></iframe>
                     </div>
                    <hr>";
            }
            }//end of while
        ?>

            <script>
            $(document).ready(function(){
                $('#post<?php echo $id; ?>').on('click',function(){
                    bootbox.confirm("Are you sure you want to delete this post?",function(result){
                        $.post("includes/handlers/delete_post.php?post_id=<?php echo $id;?>",{result:result});
                        if(result)
                        location.reload();
                       
                    });

                });

            });
            </script>







        <?php
            if($count > $limit)
             {   $str.="<input type ='hidden' class='nextpage' value=' ". ($page +1) ." '>
                    <input type= 'hidden' class='nomoreposts' value='false'>";
             }
                    else
                $str.="<input type='hidden' class='nomoreposts' value='true'><p style='text-align: centre;'> OOOPS! no more posts</p>";

        }//end of if(mysqli_num_rows($data_query)) 
        echo $str;
    }
    //loadprofileposts
    public function loadporfilepost($data, $limit)
    {
        //from ajax
        $page=$data['page'];
        $userloggedin=$this->user_obj->get_id();
        $profileUser=$data['profileusername'];

        if ($page==1)
        {
            $start=0;
        }
        else
        {
        $start=($page - 1) * $limit;
        }

        $str="";//string to return
        $data_query=mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' AND ((added_by='$profileUser' AND user_to='none ')OR user_to='$profileUser')ORDER BY id DESC");
        if(mysqli_num_rows($data_query) > 0)
        {
            $num_iterations=0; // number of posts checked 
            $count=1;

            //fetch data
            while($row=mysqli_fetch_array($data_query))
            {
                $body=$row['body'];
                $id=$row['id'];
                $added_by=$row['added_by'];
                $date_time=$row['date_added'];
            
                
                    if($num_iterations ++ < $start)
                    {
                        continue;
                    }
                    //once 10 posts have been loaded break
                        if($count > $limit)
                        {
                            break;
                        }
                        else
                        {
                            $count++;
                        }
                    if($userloggedin==$added_by)
                    {
                        $delete_button="<button id='post$id'>delete</button>";
                    }
                    else
                    {
                         $delete_button="";
                    }
                    //user details
                    $user_details=mysqli_query($this->con, "SELECT f_name,l_name,profile_pic FROM users WHERE id='$added_by'");
                    $user_row=mysqli_fetch_array($user_details);
                    $first_name=$user_row['f_name'];
                    $last_name=$user_row['l_name'];
                    $profile_pic=$added_by."/".$user_row['profile_pic']; ;

                    ?>
					<script> 
						function toggle<?php echo $id; ?>() {
                            var target=$(event.target);
                            if(!target.is("a"))
                            {
 							
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
                            }	
						}

					</script>
					<?php
                    // check num of comments
                    $comment_check=mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
                    $comment_check_num=mysqli_num_rows($comment_check);
                    //time frame
                    $date_time_now=date("Y-m-d H:i:s");//teh current date
                    $start_date=new DateTime($date_time);//time of post
                    $end_date=new DateTime($date_time_now);// current time 
                    $interval=$start_date->diff($end_date);//time difference 
                    if($interval->y >=1)
                    {
                        if($interval==1)
                        {
                            $time_message=$interval->y . "year ago";    //1 year ago
                        }
                        else
                        {
                            $time_message=$interval->y . "years ago";    //1 year ago
                        }
                    }
                else if($interval->m >=1)
                    {
                        if($interval->d ==0)
                        {
                            $days="ago";
                        }
                        else if($interval->d ==1)
                        {
                            $days=$interval->d ."day ago";
                        }
                        else
                        {
                            $days=$interval->d ."days ago";
                        }
                        //if m =1
                        if($interval->m==1){
                            $time_message= $interval->m ."month". $days;
                        }
                        else{
                            $time_message=$interval->m ."months".$days;
                        }
                    }
                    // for days only i.e 12 days ago 
                else if($interval->d >=1)
                    {
                        if($interval->d ==1)
                        {
                            $days="yesterday";
                        }
                        else
                        {
                            $days=$interval->d ."days ago";
                        }
                    }
                    else if($interval->h >=1)
                    {   
                        if($interval->h ==1)
                        {
                            $time_message=$interval->h ."hour ago";
                        }
                        else
                        {
                            $time_message=$interval->h ."hours ago";
                        }
                    }
                    else if($interval->i >=1)
                    {   
                        if($interval->i ==1)
                        {
                            $time_message=$interval->i ."minute ago";
                        }
                        else
                        {
                            $time_message=$interval->i ."minutes ago";
                        }
                    }
                    else
                    {
                        if($interval->s <30)
                        {   
                            $time_message="just now";
                        }        
                        else
                        {
                            $time_message=$interval->s ."seconds ago";
                        }
                    }
                    // on click msh sh8ala enma ama b3mlha display block btzhr requested url not found
                    $str.="<div class='status_post' onClick='javascript:toggle$id()'>
                        <div class='post_profile_pic'>
                        <img src='$profile_pic' width='50'>
                        </div>

                    <div class='posted_by' style='color:#ACACAC;'>
                    <a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
                    $delete_button
                    </div>
                    <div id='post_body'>
                    $body
                    <br>
                    </div>
                    <div class ='newsfeed'>
                    $comment_check_num comments &nbsp;&nbsp;&nbsp;
                    <iframe src='like.php?post_id=$id' scrolling ='no' frameborder='0'></iframe>
                    
                    </div>
                    </div>
                    <div class='post_comment' id='toggleComment$id' style='display:none;'>
                    <iframe src='comment_frame.php?post_id=$id' id='comment_iframe'frameborder='0' ></iframe>
                     </div>
                    <hr>";
            
            }//end of while
        ?>

            <script>
            $(document).ready(function(){
                $('#post<?php echo $id; ?>').on('click',function(){
                    bootbox.confirm("Are you sure you want to delete this post?",function(result){
                        $.post("includes/handlers/delete_post.php?post_id=<?php echo $id;?>",{result:result});
                        if(result)
                        location.reload();
                       
                    });

                });

            });
            </script>







        <?php
            if($count > $limit)
             {   $str.="<input type ='hidden' class='nextpage' value=' ". ($page +1) ." '>
                    <input type= 'hidden' class='nomoreposts' value='false'>";
             }
                    else
                $str.="<input type='hidden' class='nomoreposts' value='true'><p style='text-align: centre;'> OOOPS! no more posts</p>";

        }//end of if(mysqli_num_rows($data_query)) 
        echo $str;
    }
}

?>