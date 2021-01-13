<?php

            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if($_GET['op']=="create_room") chat::create_room($_SESSION['user']->get_id());     
                else if($_GET['op']=="load_rooms") chat::load_rooms($_SESSION['user']->get_id());
                else if($_GET['op']=="load_room"){
                  $_SESSION['room'] = new chat($_SESSION['user']->get_id(),$_GET['id']);
                  $_SESSION['room']->load_conversation();}
                else if($_GET['op']=="send_msg"){
                  $_SESSION['room']->send_msg($_GET['body']);
                }
                else if($_GET['op']=="add_member"){
                  echo $_SESSION['room']->add_member($_GET['id']);
                }
            }
            
?>