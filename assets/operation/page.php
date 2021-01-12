<?php
            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                switch ($_GET['op']) {
                    case 'join':
                        $_SESSION['group']->join_group();
                        break;
                    case 'cancel':
                        $_SESSION['group']->cancel_request();
                        break;
                    case 'leave':
                        $_SESSION['group']->leave_group();
                        break;
                    case 'delete':
                        $_SESSION['group']->delete_group();
                        break;
                    case 'kick':
                        $_SESSION['group']->kick_member($_GET['id']);
                        break;
                    case 0:
                        $_SESSION['group']->accept_request($_GET['id']);
                        break;
                    case 1:
                        $_SESSION['group']->refuse_request($_GET['id']);
                        break;
                }
                die();
            }

?>