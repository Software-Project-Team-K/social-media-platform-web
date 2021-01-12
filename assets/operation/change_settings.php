<?php

require '../classes.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$operation = $_POST['operation'];
	if ($operation == "email") {
		$connect = new connection();
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$currentEmail = $_SESSION['user']->get_email();
		$userLoggedIn = $_SESSION['user']->get_id();
		$email_check = $connect->conn->query("SELECT * FROM users WHERE email='$email'");
		if (mysqli_num_rows($email_check)==0 || $email=="$currentEmail")
		{
			$valid1 = preg_match("/^[A-Za-z-']+$/",$first_name);
			$valid2 = preg_match("/[A-Za-z-']{2,10}/",$first_name);
			$valid3 = preg_match("/^[A-Za-z-']+$/",$last_name);
			$valid4 = preg_match("/[A-Za-z-']{2,10}/",$last_name);
			if(!($valid1 && $valid2 && $valid3 && $valid4))echo "Please Enter a valid name. \n (only letters in range[2,10])";
			else{
				$valid = preg_match("/[@]/",$email);
				if(!$valid) echo "Please Enter a valid Email.";
				else{
				echo "Details Updated!";
				$full_name =$first_name." ".$last_name;
				$query = $connect->conn->query("UPDATE users SET f_name='$first_name',l_name='$last_name',full_name='$full_name',email='$email' WHERE id = '$userLoggedIn'");
				}
			}
		}
		else
		{
			echo "That E-mail Is Already In Use";
		}
	}
	else if ($operation == "pass") {
		$connect = new connection();
		$old_pass = $_POST['current_pass'];
		$new_pass = $_POST['new_pass'];
		$new_pass2 = $_POST['new_pass2'];
		$userLoggedIn = $_SESSION['user']->get_id();
		$pass_check = $connect->conn->query("SELECT * FROM users WHERE id='$userLoggedIn'");
		$row = mysqli_fetch_assoc($pass_check);
		$user_pass = $row['password'];
		if ($old_pass == $user_pass) {
			if ($new_pass==$new_pass2) {

				$valid1 = preg_match("/^[A-Za-z0-9]{8,16}$/",$new_pass);
				$valid2 = preg_match("/[0-9]+/",$new_pass);
				$valid3 = preg_match("/[A-Za-z]+/",$new_pass);
				if(!($valid1 && $valid2 && $valid3))echo "Please Enter a valid password. \n (at least one letters and one number and in range[8,16])";
				else{
					$query = $connect->conn->query("UPDATE users SET password='$new_pass' WHERE id = '$userLoggedIn'");
					echo "Password Changed Successfully";
				}
			}
			else{
				echo "Passwords Don't Match";
			}
		}
		else
		{
			echo "Wrong Old Password";
		}
	}
	else if ($operation == "check")
	{
		$connect = new connection();
		$userLoggedIn = $_SESSION['user']->get_id();
		if (!empty($_POST["check2"])) {
			$query = $connect->conn->query("UPDATE users SET enable_market='1' WHERE id = '$userLoggedIn'");
		}
		else
		{
			$query = $connect->conn->query("UPDATE users SET enable_market='0' WHERE id = '$userLoggedIn'");
		}
		echo "Details Updated Successfully";
	}
	else if ($operation == "phone_number")
	{
		$connect = new connection();
		$new_number = $_POST['new_number'];
		$userLoggedIn = $_SESSION['user']->get_id();
		$valid = preg_match("/^[0-9+][0-9]{8,15}$/",$new_number);
		if(!$valid){echo "Please Enter a valid phone number. \n (only numbers and in range[8,15])";}
		else{
			echo "Details Updated";
			$query = $connect->conn->query("UPDATE users SET phone_num='$new_number' WHERE id = '$userLoggedIn'");
		}
	}
}
?>