<?php


class Group {
    private $user_obj; // admin
    private $group_id;
	private $con;

	public function __construct($con, $user,$group_id){
		$this->con = $con;
        $this->user_obj=new user($user);
        $this->group_id= $group_id;
        
	}

    function test(){
        echo 'hello' . $this->user_obj->get_name() . $this->group_id;
    } 
    public function isMember(){
       $group_details_query = mysqli_query($this->con, "SELECT * FROM groups WHERE id='$this->group_id'");
	   $group = mysqli_fetch_array($group_details_query);//get group info
       $member=$this->user_obj->get_id();
       if((strstr($group['group_members'], $member) || $this->user_obj->get_id() == $group['admin'])) {
            return true;
        }else {
            return false;
        }
    }


    public function joinGroup(){
        $group_details_query = mysqli_query($this->con, "SELECT * FROM groups WHERE id='$this->group_id'");
	    $group = mysqli_fetch_array($group_details_query);//get group info
        $group_members = $group['group_members'] . $this->user_obj->get_id(). ",";
        $this->con->query("UPDATE groups SET group_members='$group_members' WHERE id='$this->group_id'");
    }
    public function loadgrouppost($data, $limit)
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
                        $alert_fn= "delete_post_handler($id)";
                        $delete_button="<button onclick=$alert_fn id='post$id'>delete</button>";
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
                        <img src='$profile_pic' width='50' style='border-radius:10px; '>
                        </div>

                    <div class='posted_by' style='color:#ACACAC; '>
                    <a href='$added_by'>$first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    $delete_button
                    <br>
                    $time_message
                    </div>
                    <div id='post_body'>
                    $body
                    <br>
                    </div>
                    <div class ='newsfeed'>
                    $comment_check_num comments &nbsp;&nbsp;&nbsp;
                    <iframe src='like.php?post_id=$id' scrolling ='no' frameborder='0'></iframe>
                    &nbsp;&nbsp;&nbsp; 
                    <input type='submit' name='share' method='POSt' value='share'>
                    </div>
                    </div>
                    <div class='post_comment' id='toggleComment$id' style='display:none;'>
                    <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
                     </div>
                    <hr>";
            }//end of if condition 
            }//end of while
        ?>

            <script>
            
            function delete_post_handler(id){
                bootbox.confirm("Are you sure you want to delete this post?",function(result){
                        $.post("assets/operation/delete_post.php?post_id="+id,{result:result});
                        if(result)
                        location.reload();
                       
                    });
            }
            /*
            $(document).ready(function(){
                $('#post<?php echo $id; ?>').on('click',function(){
                    bootbox.confirm("Are you sure you want to delete this post?",function(result){
                        $.post("../operation/delete_post.php?post_id=<?php echo $id;?>",{result:result});
                        if(result)
                        location.reload();
                       
                    });

                });

            });*/
            </script>







        <?php
            if($count > $limit)
             {   $str.="<input type ='hidden' class='nextpage' value=' ". ($page +1) ." '>
                    <input type= 'hidden' class='nomoreposts' value='false'>";
             }
                    else
                $str.="<input type='hidden' class='nomoreposts' value='true'><p style='text-align: center; line-height: 15;'> OOOPS! no more posts</p>";

        }//end of if(mysqli_num_rows($data_query)) 
        echo $str;
    }
	

}

?>