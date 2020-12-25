<?php
            require '../classes.php';
            session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $text = test_input($_POST['bio']);
            $_SESSION['user']->update_bio($text);
            header("Location: ../../".$_SESSION['user']->get_id());
        }


?>