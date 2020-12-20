<?php

                    
                    require '../classes.php';
                    $connect = new connection();
                    session_start();

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $user_id = $_SESSION['user']->get_id();
                    $target_id = $_GET['target'];
                    $operation = $_GET['op'];

                    switch ($operation) {
                        case 'Add Friend':
                            friendship::friendRequest($user_id,$target_id);
                            break;
                        case 'Unfriend':
                            friendship::removeFriend($user_id,$target_id);
                            break;
                        case 'Accept':
                            friendship::addFriend($user_id,$target_id);
                            break;
                        case 'Refuse':
                            friendship::cancelRequest($target_id,$user_id);
                            break;
                        case 'Cancel Request':
                            friendship::cancelRequest($user_id,$target_id);
                            break;
                    }    
                }

                header("location: ../../$target_id");



?>