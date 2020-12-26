<?php
//$error_array=array();
//get the data from the login form 
if(isset($_POST['login_button']))
{
    $email=filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL);//santize email
    $_SESSION['log_email']=$email;
    $password= md5($_POST['log_password']);
    $check_database= mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND password='$password'");  
    $check_login= mysqli_num_rows($check_database);
    if($check_login==1)
    {
        $row=mysqli_fetch_array($check_database);
        $username=$row['username'];
        $check_closed=mysqli_query($con,"SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
        if(mysqli_num_rows($check_closed)==1)
        {
            $reopen_account=mysqli_query($con, "UPDATE users SET user_closed ='no' WHERE email='$email'");

        }

        $_SESSION['username']=$username;
       // $profile_pic=$row['profile_pic'];
       header("Location: index.php");
       
       exit();

    }
    else
    {
        array_push($error_array,"email address or password is not correct, please try again<br>");
    }








}




?>

