<?php

                    
                    require '../classes.php';
                    $connect = new connection();
                    session_start();

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $target_id = $_GET['target'];
                    $operation = $_GET['op'];

                    switch ($operation) {
                        case 'Add Friend':
                            $_SESSION['user']->friendRequest($target_id);
                            break;
                        case 'Unfriend':
                            $_SESSION['user']->removeFriend($target_id);
                            break;
                        case 'Accept':
                            $_SESSION['user']->addFriend($target_id);
                            break;
                        case 'Refuse':
                            $_SESSION['target']->cancelRequest($_SESSION['user']->get_id());
                            break;
                        case 'Cancel Request':
                            $_SESSION['user']->cancelRequest($target_id);
                            break;
                    }    
                }

                header("location: ../../$target_id");



?>