<?php

                    
                    require 'connect.php';
                    require 'classes.php';
                    session_start();    


                    // Dynamic Validation AJAX (Create Errors Object)
                    if(!isset($_SESSION['validator'])) $_SESSION['validator'] = new dynamic_validation(); 
                    $validator = $_SESSION['validator']; 


                    // Dynamic Validation AJAX (Processing)
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        $input = test_input($_GET["q"]);
                        $type = $_GET["t"];
                        $errors = $validator->validate($input,$type,$conn);
                        end($errors);
                        echo ($errors[key($errors)]);  
                    }

                    // Data processing and Store
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $f_name = test_input($_POST["f_name"]);
                        $l_name = test_input($_POST["l_name"]);
                        $email = strtolower(test_input($_POST["email"]));
                        $password = test_input($_POST["password"]);
                        $phone_num = test_input($_POST["phone_num"]);

                        $conn->query("INSERT INTO users(f_name,l_name,password,phone_num,email) VALUES('$f_name','$l_name','$password','$phone_num','$email')");
                        $username = $conn->insert_id."_".strtolower($f_name);
                        $conn->query("UPDATE users SET username='$username' WHERE id=$conn->insert_id");

                        {$_SESSION['error']="Registered Successfully, You Can Login Now!"; $_SESSION['color']="green"; header("location: hello.php");}

                        mkdir($username);
                        copy("default_p.php",$username."/"."index.php");
                        copy("default_pp.jpg",$username."/"."pp.jpg");
                     }   



                   $conn->close();
?>
        