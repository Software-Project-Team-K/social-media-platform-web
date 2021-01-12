<?php
        require '../classes.php';
        session_start();  
        if(isset($_SESSION['user']))$_SESSION['user']->go_offline($_SESSION['user']->get_id());
        session_unset();
        session_destroy();
        header("location: ../../");
?>

