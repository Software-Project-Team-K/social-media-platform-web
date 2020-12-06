<?php       
                    $_server = "localhost";
                    $_user = "root";
                    $_pass = "";
                    $_dbname = "silvaro";
                    $conn = new mysqli($_server, $_user, $_pass ,$_dbname) or die("Connection failed: " . $conn->connect_error);
?>