<?php
            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Create") {
                
                if($_POST['type'] == "Group"){
                    group::create($_POST['name'],$_SESSION['user']->get_id());
                }
                else if($_POST['type'] == "Page"){
                    page::create($_POST['name'],$_SESSION['user']->get_id());
                }
                header("location: ../../");
            }
            else
            $_SESSION['user']->open_noti();
?>