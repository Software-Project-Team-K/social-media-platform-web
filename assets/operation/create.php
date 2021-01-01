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

                    //CREATE TABLES for users
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
                        no_post INT,
                        no_likes INT,
                        user_closed VARCHAR (3) default'no'
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
                    $sql = "ALTER TABLE users AUTO_INCREMENT=1001";
                    $conn->query($sql);
                    
                     //CREATE TABLES for posts
                     $sql = "CREATE TABLE posts(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        body TEXT,
                        added_by VARCHAR(75),
                        date_added datetime,
                        user_to VARCHAR(75),
                        user_closed VARCHAR(3),
                        likes INT,
                        deleted VARCHAR(3) 
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
                   

                    //CREATE TABLES for likes
                    $sql = "CREATE TABLE likes(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                       username INT,
                       post_id INT
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
                   
                    //CREATE TABLES for comments
                   $sql = "CREATE TABLE comments(
                    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                   post_body text,
                   posted_by varchar(75),
                   posted_to varchar(75),
                   date_added datetime,
                   deleted varchar(3),
                   post_id INT
                )";
                if ($conn->query($sql) === TRUE) echo "Table created successfully"."<br>";
                else echo "Error creating Table: " . $conn->error."<br>";
               
                    //CLOSE THE CONNECTION
                    $conn->close();
?>
    