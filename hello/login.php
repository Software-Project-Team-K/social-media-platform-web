<?php

                    
                    require '../assets/classes.php';
                    $connect = new connect();
                    session_start();


                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $logID = strtolower(test_input($_POST["logID"]));
                    $password = test_input($_POST["password"]);
                    }


                    $result = $connect->conn->query("SELECT * FROM users WHERE email='$logID' or username='$logID'");
        
                    if (mysqli_num_rows($result) == 0) {$_SESSION['error']="Invalid Email/Username!";  $_SESSION['color']="red"; header("location: ./"); die();}

                    $row = mysqli_fetch_assoc($result);
                    $realpass = $row['password'];

                    if ($password==$realpass)
                    {
                    $_SESSION['user'] = new user($row);
                    header("Location: ./");
                    }
                    else {$_SESSION['error']="Invalid Password!";  $_SESSION['color']="red"; header("location: ./");}

                    
?>