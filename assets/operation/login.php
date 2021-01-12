<?php

                    
                    require '../classes.php';
                    $connect = new connection();
                    session_start();

                    //Google sign in
                    if(isset($_SESSION['google_id'])){
                        $temp = $_SESSION['google_id']; 
                        $result = $connect->conn->query(" SELECT * FROM users WHERE google_id ='$temp' ");
                        include('../../hello/config.php');
                        $google_client->revokeToken();
                        unset($_SESSION['access_token']);
                        unset($_SESSION['google_id']);
                        if (mysqli_num_rows($result) == 0) {$_SESSION['msg']="Invalid Google Credential!";  $_SESSION['color']="red"; header("location: ../../"); die();}
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['user'] = new user($row['id']);
                        header("Location: ../../");
                    }

                    //Get User Input
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $logID = strtolower(test_input($_POST["logID"]));
                    $password = test_input($_POST["password"]);}
                    

                    //Check If Its admin
                    $result = $connect->conn->query("SELECT * FROM admins WHERE username='$logID' AND password='$password'");
                    if (mysqli_num_rows($result) != 0) {
                        $_SESSION['admin'] = new admin($logID);
                        header("Location: ../../");
                    }

                    //Check If The User not Exists
                    $result = $connect->conn->query("SELECT * FROM users WHERE email='$logID' or id='$logID' or phone_num='$logID'");
                    if (mysqli_num_rows($result) == 0) {$_SESSION['msg']="Invalid Email/ID or Phone!";  $_SESSION['color']="red"; header("location: ../../"); die();}

                    //If The user Exist fetch the real password
                    $row = mysqli_fetch_assoc($result);
                    $realpass = $row['password'];

                    //Check If The Password is right
                    if ($password==$realpass){
                    $_SESSION['user'] = new user($logID);
                    header("Location: ../../");}
                    else {$_SESSION['msg']="Invalid Password!";  $_SESSION['color']="red"; header("location: ../../");}              
?>