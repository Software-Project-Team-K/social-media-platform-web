<?php

                    //CLASS >> CURRENT USER DATA
                    class user{

                        private $username;
                        private $f_name;
                        private $l_name;
                        private $full_name;
                        private $profile_pic;
                        private $cover_pic;

                        function __construct($row){
                            
                            $this->f_name= $row['f_name'];
                            $this->l_name= $row['l_name'];
                            $this->full_name = $this->f_name." ".$this->l_name;
                            $this->username= $row['username'];
                            $this->profile_pic= $row['profile_pic'];
                            $this->cover_pic= $row['cover_pic'];
                        }

                        function get_name() {return $this->full_name;}
                        function get_id()  {return $this->username;}
                        function get_profile_pic() {return $this->profile_pic;}
                        function get_cover_pic()  {return $this->cover_pic;}

                        function update_profile_pic($link,$connect){
                            $this->profile_pic = $link;
                            $connect->conn->query("UPDATE users SET profile_pic='$this->profile_pic' WHERE username='$this->username'");
                        }
                        function update_cover_pic($link,$connect){
                            $this->cover_pic = $link;
                            $connect->conn->query("UPDATE users SET cover_pic='$this->cover_pic' WHERE username='$this->username'");
                        }
                    }

                    //CLASS >> CONNECTION TO DATABASE
                    class connection{

                        private  $_server = "localhost";
                        private  $_user = "root";
                        private  $_pass = "";
                        private  $_dbname = "silvaro";
                        public   $conn;

                        function __construct(){
                            $this->conn = new mysqli($this->_server, $this->_user, $this->_pass ,$this->_dbname) or die("Connection failed: " . $this->conn->connect_error);
                        }
                        function __destruct(){
                            $this->conn->close();
                        }
                    }

                    //CLASS >> DYNAMIC VALIDATE THE INPUT 
                    class dynamic_validation{

                        private $errors = array("</br>");
                        private $name_c = "/^[A-Za-z-']+$/";
                        private $name_c2 = "/[A-Za-z-']{2,10}/";
                        private $email_c = "/[@]/";
                        private $pass_c = "/^[A-Za-z0-9]{8,16}$/";
                        private $pass_c2 = "/[0-9]+/";
                        private $pass_c3 = "/[A-Za-z]+/";
                        private $phone_c = "/^[0-9+][0-9]{8,15}$/";
                        private $error_1 = "The name must contains only Alphabet letters!";
                        private $error_2 = "Please Enter a real first name!";
                        private $error_1L = "The last name must contains only Alphabet letters!";
                        private $error_2L = "Please Enter a real last name!";
                        private $error_3 = "The email must be vaild!";
                        private $error_4 = "Email is already used!";
                        private $error_5 = "The password [8-16 Digits] must contains at least one letter and number!";
                        private $error_6 = "The Password doesnt match the Re-Password!";
                        private $error_7 = "The phone must be valid and contains only digits!";
                        private $pw = "";
           
                        
                        function validate($input,$type,$conn){
                            switch ($type) {
                                case "f_name"   :
                                    $valid = preg_match($this->name_c,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_1);
                                    else if($valid==FALSE) $this->add_error($this->error_1);
                                    $valid = preg_match($this->name_c2,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_2);
                                    else if($valid==FALSE) $this->add_error($this->error_2);
                                break;
                                case "l_name":
                                    $valid = preg_match($this->name_c,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_1L);
                                    else if($valid==FALSE) $this->add_error($this->error_1L);
                                    $valid = preg_match($this->name_c2,$input);
                                    if($valid==TRUE) $this->remove_error($this->error_2L);
                                    else if($valid==FALSE) $this->add_error($this->error_2L);
                                break;
                                case "email":
                                    $valid = preg_match($this->email_c,$input);
                                    if($valid) $this->remove_error($this->error_3);
                                    else $this->add_error($this->error_3);
                                    $result = $conn->query("SELECT * FROM users WHERE email='$input'");                         
                                    $valid = (mysqli_num_rows($result) == 0)? TRUE:FALSE;
                                    if($valid) $this->remove_error($this->error_4);
                                    else $this->add_error($this->error_4);
                                break;
                                case "password":
                                    $this->pw = $input;
                                    $valid = preg_match($this->pass_c,$input);
                                    $valid *= preg_match($this->pass_c2,$input);
                                    $valid *= preg_match($this->pass_c3,$input);
                                    if($valid) $this->remove_error($this->error_5);
                                    else $this->add_error($this->error_5);
                                break;
                                case "password2":
                                    $valid = ($input == $this->pw)? TRUE:False;
                                    if($valid) $this->remove_error($this->error_6);
                                    else $this->add_error($this->error_6);
                                break;
                                case "phone_num":
                                    $valid = preg_match($this->phone_c,$input);
                                    if($valid) $this->remove_error($this->error_7);
                                    else $this->add_error($this->error_7);
                                break;
                            }    
                            return $this->errors;
                        }

                        private function add_error($str){
                            if(!in_array($str,$this->errors))
                            array_push($this->errors,$str);

                        }
                        private function remove_error($str){
                            if(in_array($str,$this->errors)){
                            $k = array_search($str,$this->errors);
                            unset($this->errors[$k]);
                            }
                        }
                        function get_errors(){
                            return $this->errors;
                        }
                    }

                    //FUNCTION >> CLEAR THE INPUT 
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }

?>