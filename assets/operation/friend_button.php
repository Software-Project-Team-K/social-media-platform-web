<?php

                    
                    require '../classes.php';
                    $connect = new connection();
                    session_start();

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $target_id = $_GET['target'];
                    
                    if($_SESSION['user']->IsFriend($target_id)){
                        $_SESSION['user']->removeFriend($target_id);
                    }
                    else{
                        if($_SESSION['user']->IsFrRequest($target_id)) $_SESSION['user']->cancelRequest($target_id);
                        else $_SESSION['user']->friendRequest($target_id);
                    } 
                    
                }

                header("location: ../../$target_id");



?>