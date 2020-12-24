<?php

                    //SERVER DETAILS
                    $server = "localhost";
                    $user = "root";
                    $pass = "";
                    $dbname = "chatverse";
                        
                    //CONNECT TO THE SERVER
                    $conn = new mysqli($server, $user, $pass);
                    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

                    //DELETE DATABASE IF EXISTS
                    $sql = "DROP DATABASE IF EXISTS chatverse";
                    $conn->query($sql);

                    //CREATE DATABASE
                    $sql = "CREATE DATABASE ".$dbname;
                    if ($conn->query($sql) === TRUE) echo "Database created successfully"."<br>";
                    else echo "Error creating database: " . $conn->error."<br>";
                
                    //CONNECT TO THE DATABASE
                    $conn = new mysqli($server, $user, $pass ,$dbname);

                    //CREATE TABLES
                    $sql = "CREATE TABLE users(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        password VARCHAR(20) NOT NULL,
                        email VARCHAR(30) NOT NULL,
                        f_name VARCHAR(20) NOT NULL,
                        l_name VARCHAR(20) NOT NULL,
                        phone_num INT(15) UNSIGNED,
                        gender VARCHAR(15),
                        bio VARCHAR (50) DEFAULT 'Hey there! im a new Chatverse User!',
                        google_id VARCHAR(25) DEFAULT 'X',
                        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        birth_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        profile_pic VARCHAR(60) NOT NULL DEFAULT '../assets/img/default_pp.jpg',
                        cover_pic VARCHAR(60) NOT NULL DEFAULT '../assets/img/default_cover.jpg',
                        friends VARCHAR(300) NOT NULL DEFAULT '',
                        friends_no INT(10) UNSIGNED DEFAULT 0,
                        fr_requests VARCHAR(300) DEFAULT ''
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
                    $sql = "ALTER TABLE users AUTO_INCREMENT=1001";
                    $conn->query($sql);
                    
                    //CLOSE THE CONNECTION
                    $conn->close();
?>
    