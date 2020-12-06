<?php


                    require 'connect.php';
                    require 'classes.php';
                    session_start();

                    $f_name = $l_name = $email = $password = $phone_num = "";
                    $name_c = "/^[A-Za-z-']+$/";
                    $name_c2 = "/[A-Za-z-']{2,10}/";
                    $pass_c = "/^[A-Za-z0-9]{8,16}$/";
                    $pass_c2 = "/[0-9]+/";
                    $pass_c3 = "/[A-Za-z]+/";
                    $email_c = "/[@]/";
                    $phone_c = "/^[0-9+][0-9]{8,15}$/";
                    $valid = TRUE;


                    //Dynamic Validation AJAX
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        $value = test_input($_GET["q"]);
                        $type = $_GET["t"];

                        switch ($type) {
                            case "f_name":
                                $valid = preg_match($name_c,$value);
                                if($valid == FALSE) {echo "The name must contains only Alphabet letters!"; break;}
                                $valid = preg_match($name_c2,$value);
                                if($valid == FALSE) echo "Please Enter a real name!";
                                break;
                            case "l_name":
                                 $valid = preg_match($name_c,$value);
                                 if($valid == FALSE) {echo "The name must contains only Alphabet letters!"; break;}
                                 $valid = preg_match($name_c2,$value);
                                if($valid == FALSE) echo "Please Enter a real name!";
                                break;
                            case "email":
                                $valid = preg_match($email_c,$value);
                                if($valid == FALSE) {echo "The email must be vaild!"; break;}
                                $sql ="SELECT username FROM users WHERE email='$value'";
                                $result = $conn->query($sql);
                                if (mysqli_num_rows($result) != 0) echo("Email is already used!");
                                break;
                            case "password":
                                $valid = preg_match($pass_c,$value);
                                $valid *= preg_match($pass_c2,$value);
                                $valid *= preg_match($pass_c3,$value);
                                $password = $value;
                                if($valid == FALSE) echo "The password has (8-15) Digits and must contains at least one letter!";
                                break;
                            case "phone_num":
                                $valid = preg_match($phone_c,$value);
                                if($valid == FALSE) echo "The phone must be valid and contains only digits!";
                                break;
                            default:
                                echo "</br>";
                            break;
                        }      
                    }



                    

                    // Data processing and Store
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $f_name = test_input($_POST["f_name"]);
                    $l_name = test_input($_POST["l_name"]);
                    $email = strtolower(test_input($_POST["email"]));
                    $password = test_input($_POST["password"]);
                    $password2= test_input($_POST["password2"]);
                    $phone_num = test_input($_POST["phone_num"]);
                    



                    $valid = preg_match($name_c,$f_name);
                    $valid *= preg_match($name_c2,$f_name);
                    if($valid == FALSE){$_SESSION['error']="Invalid Firstname!"; $_SESSION['page']="true"; header("location: hello.php"); die;}
                    $valid = preg_match($name_c,$l_name);
                    $valid *= preg_match($name_c2,$l_name);
                    if($valid == FALSE){$_SESSION['error']="Invalid Lastname!"; $_SESSION['page']="true"; header("location: hello.php"); die;}

                    $sql ="SELECT username FROM users WHERE email='$email'";
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) != 0){$_SESSION['error']="Email is already used!"; $_SESSION['page']="true"; header("location: hello.php");die;}

                    $valid = preg_match($pass_c,$password);
                    if($valid == FALSE){$_SESSION['error']="Invalid Password!"; $_SESSION['page']="true"; header("location: hello.php");die;}
                    $valid = preg_match($pass_c2,$password);
                    if($valid == FALSE){$_SESSION['error']="Invalid Password!"; $_SESSION['page']="true"; header("location: hello.php");die;}
                    $valid = preg_match($pass_c3,$password);
                    if($valid == FALSE){$_SESSION['error']="Invalid Password!"; $_SESSION['page']="true"; header("location: hello.php");die;}
                    if($password != $password2){$_SESSION['error']="Password doesnt match Re-Password!"; $_SESSION['page']="reg"; header("location: hello.php"); die;}
                    $valid = preg_match($phone_c,$phone_num);
                    if($valid == FALSE ){$_SESSION['error']="Invalid Phone!"; $_SESSION['page']="true"; header("location: hello.php");die;}





                    $sql = "INSERT INTO users(f_name,l_name,password,phone_num,email)
                    VALUES('$f_name','$l_name','$password','$phone_num','$email')";
                    $conn->query($sql);


                    $username = $conn->insert_id."_".strtolower($f_name);
                    $sql = "UPDATE users SET username='$username' WHERE id=$conn->insert_id";
                    $conn->query($sql);
                    {$_SESSION['error']="Registered Successfully, You Can Login Now!"; unset($_SESSION['page']); header("location: hello.php");}
                    mkdir($username);
                    copy("default_p.php",$username."/"."index.php");
                    copy("default_pp.jpg",$username."/"."pp.jpg");
                   }   

                    $conn->close();

?>
        