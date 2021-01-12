<?php
            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Post") {
                $body = $_POST['body'];
                $post_to = $_POST['post_to'];
                $myPost = new post($_SESSION['user']->get_id());
                $myPost->write_post($body,$post_to);
                //make it dynamic
                header("location: ../../");
            }
            else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit']=="Write") {
                $body = $_POST['body'];
                $post_to = $_POST['post_to'];
                $myPost = new post($_SESSION['user']->get_id());
                $myPost->write_comment($_SESSION['post'],$_POST['body']);
                //make it dynamic
                header("location: ../../");
            }
            
            else if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['op']=="load" && $_SESSION['offset']!=-1) {
                
                if($_GET['page']=="home")
                     { 
                     $myPost = new post($_SESSION['user']->get_id());
                     $myPost->load_timeline_posts($_SESSION['offset']);
                }
                else if($_GET['page']=="saved")
                {
                    $myPost = new post($_SESSION['user']->get_id());
                    $myPost->load_saved_posts($_SESSION['offset']);
                }
                else if($_GET['page']=="group")
                {
                    $myPost = new post($_SESSION['user']->get_id());
                    $myPost->load_group_posts($_SESSION['offset'],$_GET['id']);
                }
                else if($_GET['page']=="page")
                {
                    $myPost = new post($_SESSION['user']->get_id());
                    $myPost->load_page_posts($_SESSION['offset'],$_GET['id']);
                }
                else {
                    $myPost = new post($_SESSION['target']->get_id());
                    $myPost->load_profile_posts($_SESSION['offset']);
                }
                die();
            }
            else if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['op']=="loadcomments") {
                $myPost = new post($_SESSION['user']->get_id());
                $myPost->load_comments($_GET['id']);
                $_SESSION['post']=$_GET['id'];
                die();
            }
            else if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['op']=="love") {
                $myPost = new post($_SESSION['user']->get_id());
                $myPost->love_post($_GET['id']);
                die();
            }
            else if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['op']=="share") {
                $myPost = new post($_SESSION['user']->get_id());
                echo $myPost->share_post($_GET['id']);
                die();
            }
            else if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['op']=="save") {
                $myPost = new post($_SESSION['user']->get_id());
                $myPost->save_post($_GET['id']);
                die();
            }
      







?>