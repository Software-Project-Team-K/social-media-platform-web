<?php
            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                switch ($_GET['op']) {
                    case 'follow':
                        $_SESSION['page']->follow_page();
                        break;
                    case 'unfollow':
                        $_SESSION['page']->unfollow_page();
                        break;
                    case 'delete':
                        $_SESSION['page']->delete_page();
                        break;
                    case 'leave':
                        $_SESSION['page']->leave_admin();
                        break;
                    case 'promote':
                        $_SESSION['page']->give_admin($_GET['id']);
                        break;
                    case 'demote':
                        $_SESSION['page']->take_admin($_GET['id']);
                        break;
                }
                die();
            }

?>