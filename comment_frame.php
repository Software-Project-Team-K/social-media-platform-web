<?php  
	require 'assets/classes.php';
    $connect =new connection ;
    $con = $connect->conn;
    session_start(); 

	if (isset($_SESSION['user'])) {
		$userloggedin = $_SESSION['user']->get_id();
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE id='$userloggedin'");
		$user = mysqli_fetch_array($user_details_query);
	}
	/*else {
		header("Location: register.php");
	}*/

	?>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="styling/style.css">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
    <style type="text/css">
            * {
                font-size: 12px;
                font-family: Arial, Helvetica, Sans-serif;
            }

            </style>

	
	<script>
		function toggle() {
			var element = document.getElementById("comment_section");

			if(element.style.display == "block") 
				element.style.display = "none";
			else 
				element.style.display = "block";
		}
	</script>

	<?php  
	//Get id of post
	if(isset($_GET['post_id'])) {
		$post_id = $_GET['post_id'];
	}

	$user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
	$row = mysqli_fetch_array($user_query);

	$posted_to = $row['added_by'];

	if(isset($_POST['postComment' . $post_id])) {
		$post_body = $_POST['post_body'];
		$post_body = mysqli_escape_string($con, $post_body);
        $date_time_now = date("Y-m-d H:i:s");
        // show if the comment is empty
        $post_body=strip_tags($post_body);//strip html tags
        $post_body=mysqli_real_escape_string($con,$post_body);//escape the quotes ti ignore mi$smatch
        $post_body=str_replace('\r\n', '\n',$post_body);
        $post_body=nl2br($post_body);
        $chech_space=preg_replace('/\s+/','',$post_body);//erase any space
       //check spaces
        if($chech_space !="")
        {
		$insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userloggedin', '$posted_to', '$date_time_now', 'no', '$post_id')");
		echo "<p> WOhoo Comment Posted! </p>";
        }
    }
	?>
	<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST">
		<textarea name="post_body"></textarea>
		<input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
	</form>

	<!-- Load comments -->
    <?php
        $get_comments=mysqli_query($con,"SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
        $count=mysqli_num_rows($get_comments); //if comments exist
        if($count !=0)
        {   
            while($comment = mysqli_fetch_array($get_comments))
            {
                $comment_body=$comment['post_body'];
                $posted_by=$comment['posted_by'];
                $posted_to=$comment['posted_to'];
                $deleted=$comment['deleted'];
                $date_added=$comment['date_added'];

                //time frame
                    $date_time_now=date("Y-m-d H:i:s");//teh current date
                    $start_date=new DateTime($date_added);//time of post
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
                    }//end of time frame


                $user_obj=new user($posted_by);
                $post_owner_profile_url= $user_obj->get_id() .'/'.$user_obj->get_profile_pic();
                
                ?>
                     <div class="comment_section">
                        <a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $post_owner_profile_url;?>" title="<?php $posted_by?>" style="float:left;" height="30"></a>
                        <a href="<?php echo $posted_by?>" target="_parent"> <b> <?php echo $user_obj->get_name(); ?></b></a>
                        &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message ."<br>".$comment_body; ?>
                        <hr>
                    </div>
                
                <?php

            }//end of while($comment=mysqli_fetch_array($get_comments))

        }// if($count!=0)
        else
        {
            echo"<center><br><br> No comments to show!</center>";
        }


    ?>
    





</body>
</html>