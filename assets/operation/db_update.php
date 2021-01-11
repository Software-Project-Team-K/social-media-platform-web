<?php
            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Enable Market") {
                $_SESSION['user']->enable_market(1);
                header("location: ../../settings");
            }
            else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Disable Market") {
                $_SESSION['user']->enable_market(0);
                header("location: ../../settings");
            }
            else
            $_SESSION['user']->open_noti();
    

?>