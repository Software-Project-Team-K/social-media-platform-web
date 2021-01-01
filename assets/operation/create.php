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

                    //CREATE USER TABLE 
                    $sql = "CREATE TABLE users(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        password VARCHAR(20) NOT NULL,
                        email VARCHAR(30) NOT NULL,
                        f_name VARCHAR(20) NOT NULL,
                        l_name VARCHAR(20) NOT NULL,
                        phone_num INT(20) UNSIGNED,
                        gender VARCHAR(10),
                        bio VARCHAR (50) DEFAULT 'Hey there! im a new Chatverse User!',
                        google_id VARCHAR(25) DEFAULT 'X',
                        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        birth_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        profile_pic VARCHAR(60) NOT NULL DEFAULT '../assets/img/default_pp.jpg',
                        cover_pic VARCHAR(60) NOT NULL DEFAULT '../assets/img/default_cover.jpg',
                        friends VARCHAR(300) NOT NULL DEFAULT '',
                        friends_no INT(10) UNSIGNED DEFAULT 0,
                        fr_requests VARCHAR(300) DEFAULT '',
                        new_noti VARCHAR(5) DEFAULT '',
                        products_no INT(10) UNSIGNED DEFAULT 0,
                        enable_market INT(2) UNSIGNED DEFAULT 0,
                        show_friends INT(2) UNSIGNED DEFAULT 0,
                        show_user_details INT(2) UNSIGNED DEFAULT 0
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
                    $sql = "ALTER TABLE users AUTO_INCREMENT=1001";
                    $conn->query($sql);
                    



                    //CREATE NOTIFICATIONS TABLES
                    $sql = "CREATE TABLE notifications(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        sender VARCHAR(20) NOT NULL,
                        receiver VARCHAR(20) NOT NULL,
                        body VARCHAR (50) NOT NULL,
                        at_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";

                    //CREATE NOTIFICATIONS TABLES
                    $sql = "CREATE TABLE marketplace(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        seller VARCHAR(25) NOT NULL,
                        product_name VARCHAR(30) NOT NULL,
                        product_desc VARCHAR (200) NOT NULL,
                        product_pic VARCHAR (100) NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                     else echo "Error creating Table: " . $conn->error."<br>";











                    //CLOSE THE CONNECTION
                    $conn->close();
?>
    