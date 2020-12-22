<?php

                    
                    require '../classes.php';
                    $connect = new connection();
                    session_start();

                    //Get User Input
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $logID = strtolower(test_input($_POST["logID"]));
                    $password = test_input($_POST["password"]);}
                    
                    //Check If The User not Exists
                    $result = $connect->conn->query("SELECT * FROM users WHERE email='$logID' or username='$logID'");
                    if (mysqli_num_rows($result) == 0) {$_SESSION['msg']="Invalid Email/Username!";  $_SESSION['color']="red"; header("location: ../../"); die();}

                    //If The user Exist fetch the real password
                    $row = mysqli_fetch_assoc($result);
                    $realpass = $row['password'];

                    //Check If The Password is right
                    if ($password==$realpass){
                    $_SESSION['user'] = new user($logID);
                    header("Location: ../../");}
                    else {$_SESSION['msg']="Invalid Password!";  $_SESSION['color']="red"; header("location: ../../");}              
?>