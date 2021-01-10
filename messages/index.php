<?php 
	require '../includes/classes/Message.php';
	session_start();
	if(!isset($_SESSION['user']))header("location: ../");
	$connect =new connection ;
	$con = $connect->conn;   
	$userloggedin= $_SESSION['user']; 
	$userloggedinId= $userloggedin->get_id(); 
	$userloggedin_query=mysqli_query($con, "SELECT * FROM users WHERE id='$userloggedinId' ");
	$user= mysqli_fetch_array($userloggedin_query);
	$message_obj = new Message($con, $userloggedinId);

	if(isset($_GET['u']))
		$user_to = $_GET['u'];
	else {
		$user_to = $message_obj->getMostRecentUser();
		if($user_to == false)
			$user_to = 'new';
	}
	
	if($user_to != "new")
		$user_to_obj = new user($user_to);
	
	if(isset($_POST['post_message'])) {
	
		if(isset($_POST['message_body'])) {
			$body = mysqli_real_escape_string($con, $_POST['message_body']);
			$date = date("Y-m-d H:i:s");
			$message_obj->sendMessage($user_to, $body, $date);
			header("Location:index.php");
		}
	}
	
	echo '
	<!DOCTYPE html>
		<html>

			<head>
					<link rel="stylesheet" type="text/css" href="../styling/style.css">
					<link rel="stylesheet" type=text/css href="../styling/bootstrap.css">
					<link rel="stylesheet" href="../profile/main.css">
					<meta charset="utf-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
					<script src="../assets/js/bootstrap.js"></script>
					<script src="../assets/js/bootbox.min.js"></script>
					<script src="../assets/js/demo.js"></script>
					<link rel="icon" href="../assets/img/icn_logo.png">

					<!--Navigation Bar-->
					<div id="nav">
						<a href="../"><img src="../assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
						<input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
							<div id="navbuttons">
									<button><a href="../'.$_SESSION["user"]->get_id().'"><img src="../'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
									<button><a href="../messages" ><img src="../assets/img/icn_msg.png"></a></button>
									<button><img src="../assets/img/icn_notification.png"></button>
									<button id="arrow"><img src="../assets/img/icn_settings.png"></button>
									<ul id="menu">
											<li><a href="../settings">Account Settings</li>
											<li><a href="../assets/operation/logout.php">Logout</a></li>
									</ul>
								</div> 
							</div>
					<div style="height:40px; background-color: white;"></div>

					<script>
					var arrow = document.getElementById("arrow");
					var menu = document.getElementById("menu");  
					arrow.onclick = function() {
						if(menu.style.display == "block")menu.style.display = "none"
						else menu.style.display = "block";}
					</script>


				</head>
			<body>'

 ?>

 	<div class="user_details column">
		<a href="<?php echo $userLoggedIn; ?>">  <img id="pp" src=<?php echo "../".$userloggedinId."/".$userloggedin->get_profile_pic(); ?>></a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php 
			echo $userloggedin->get_name();
			 ?>
			</a>
			<br>
			<?php echo "Posts: " . $userloggedin->getnumofposts(). "<br>"; 
			?>
		</div>
			<h4>Conversations</h4>
			<div class="loaded_conversations">
				<?php echo $message_obj->getConvos(); ?>
			</div>
			<br>
			<!--<a href="index.php?u=new">New Message</a>-->
	</div>
	

	<div class="main_column column" id="main_column">
		<?php  
		if($user_to != "new"){
			echo "<h4>You and <a href='$user_to'>" . $user_to_obj->get_name() . "</a></h4><hr><br>";

			echo "<div class='loaded_messages' id='scroll_messages'>";
				echo $message_obj->getMessages($user_to);
			echo "</div>";
		}
		else {
			echo "<h4>New Message</h4>";
		}
		?>
		<div class="message_post">
			<form action="" method="POST">
				<?php
				if($user_to == "new") {
					echo "Select the friend you would like to message <br><br>";
					?> 
					To: <input type='text' onkeyup='getUsers(this.value, "<?php echo $userLoggedIn; ?>")' name='q' placeholder='Name' autocomplete='off' id='seach_text_input'>

					<?php
					echo "<div class='results'></div>";
				}
				else {
					echo "<textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>";
					echo "<input type='submit' name='post_message' class='info' id='message_submit' value='Send'>";
				}

				?>
			</form>
		</div>

		<script>
			var div = document.getElementById("scroll_messages");
			div.scrollTop = div.scrollHeight;
		</script>
	</div>

	
	</body>  
</html>