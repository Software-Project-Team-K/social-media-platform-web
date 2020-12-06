<?php

                    class user{
                        private $username;
                        private $f_name;
                        private$l_name;
                        private$full_name;

                        function __construct($fn,$ln,$id){
                            $this->f_name=$fn;
                            $this->l_name=$ln;
                            $this->username=$id;
                            $this->auto();
                        }

                        function name(){
                            return $this->full_name;
                        }

                        function id(){
                            return $this->username;
                        }


                        function auto(){
                            $this->full_name = $this->f_name." ".$this->l_name;
                        }

                    }



                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
?>