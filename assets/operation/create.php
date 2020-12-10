<?php
                    $server = "localhost";
                    $user = "root";
                    $pass = "";
                    $dbname = "silvaro2";
                        
                    $conn = new mysqli($server, $user, $pass);
                    if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);}


                    $sql = "CREATE DATABASE ".$dbname;
                    if ($conn->query($sql) === TRUE) {
                        echo "Database created successfully"."<br>";
                    } 
                    else {
                         echo "Error creating database: " . $conn->error."<br>";
                    }

                    $conn = new mysqli($server, $user, $pass ,$dbname);

                    $sql = "CREATE TABLE users(
                        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(25),
                        password VARCHAR(20) NOT NULL,
                        email VARCHAR(30) NOT NULL,
                        f_name VARCHAR(20) NOT NULL,
                        l_name VARCHAR(20) NOT NULL,
                        phone_num INT(15) UNSIGNED,
                        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        profile_pic VARCHAR(60) NOT NULL DEFAULT '../assets/default/default_pp.jpg',
                        cover_pic VARCHAR(60) NOT NULL DEFAULT '../assets/default/default_cover.jpg'
                    )";

                    if ($conn->query($sql) === TRUE) {
                        echo "Table created successfully"."<br>";
                    } else {
                        echo "Error creating Table: " . $conn->error."<br>";
                    }

                    $conn->close();
?>
    