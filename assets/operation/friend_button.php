<?php

                    
                    require '../classes.php';
                    $connect = new connection();
                    session_start();

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $user_id = $_SESSION['user']->get_id();
                    $target_id = $_GET['target'];
                    $operation = $_GET['op'];
                    $noti = new notification($user_id);

                    switch ($operation) {
                        case 'Add Friend':
                            friendship::friendRequest($user_id,$target_id);
                            $noti->add_noti($target_id,"sent u a friend request!");
                            break;
                        case 'Unfriend':
                            friendship::removeFriend($user_id,$target_id);
                            $noti->add_noti($target_id,"removed you from friends!");
                            break;
                        case 'Accept':
                            friendship::addFriend($user_id,$target_id);
                            $noti->add_noti($target_id,"accepted your friend request!");
                            break;
                        case 'Refuse':
                            friendship::cancelRequest($target_id,$user_id);
                            $noti->add_noti($target_id,"rejected your friend request!");
                            break;
                        case 'Cancel Request':
                            friendship::cancelRequest($user_id,$target_id);
                            $noti->add_noti($target_id,"cancelled the friend request!");
                            break;
                    }    
                }

                header("location: ../../$target_id");



?>