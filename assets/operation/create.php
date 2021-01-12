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

                    //CREATE USERS TABLE 
                    $sql = "CREATE TABLE users(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        password VARCHAR(20) NOT NULL,
                        email VARCHAR(30) NOT NULL,
                        f_name VARCHAR(20) NOT NULL,
                        l_name VARCHAR(20) NOT NULL,
                        full_name VARCHAR(40) NOT NULL,
                        phone_num INT(20) UNSIGNED,
                        gender VARCHAR(10),
                        bio VARCHAR (50) DEFAULT 'Hey there! im a new Chatverse User!',
                        google_id VARCHAR(25) DEFAULT 'X',
                        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        birth_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        profile_pic VARCHAR(60) NOT NULL DEFAULT '../assets/img/default_pp.jpg',
                        cover_pic VARCHAR(60) NOT NULL DEFAULT '../assets/img/default_cover.jpg',
                        friends VARCHAR(300) NOT NULL DEFAULT '',
                        friends_no INT(10) UNSIGNED DEFAULT 0,
                        fr_requests VARCHAR(300) DEFAULT '',
                        groups TEXT NOT NULL DEFAULT '',
                        groups_no INT(10) UNSIGNED DEFAULT 0,
                        pages TEXT NOT NULL DEFAULT '',
                        pages_no INT(10) UNSIGNED DEFAULT 0,
                        new_noti VARCHAR(5) DEFAULT '',
                        products_no INT(10) UNSIGNED DEFAULT 0,
                        enable_market INT(2) UNSIGNED DEFAULT 0,
                        saved_posts TEXT
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table users created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
                    $sql = "ALTER TABLE users AUTO_INCREMENT=1001";
                    $conn->query($sql);
                    
                   /*//CREATE ADMINS TABLE
                   $sql = "CREATE TABLE admins(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(20) NOT NULL,
                        password VARCHAR(20) NOT NULL,
                        f_name VARCHAR(20) NOT NULL,
                        l_name VARCHAR(20) NOT NULL,
                        full_name VARCHAR(40) NOT NULL,
                        control_type VARCHAR(20) NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table admins created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";*/

                    //CREATE NOTIFICATIONS TABLE
                    $sql = "CREATE TABLE notifications(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        sender VARCHAR(20) NOT NULL,
                        receiver VARCHAR(20) NOT NULL,
                        body VARCHAR (50) NOT NULL,
                        at_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table notifications created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";

                    //CREATE MARKETPLACE TABLE
                    $sql = "CREATE TABLE marketplace(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        seller VARCHAR(25) NOT NULL,
                        product_name VARCHAR(30) NOT NULL,
                        product_desc VARCHAR (200) NOT NULL,
                        product_pic VARCHAR (100) NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table marketplace created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";

                     //CREATE POSTS TABLE
                     $sql = "CREATE TABLE posts(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        post_from VARCHAR(30) NOT NULL,
                        post_to VARCHAR (30) NOT NULL,
                        body TEXT NOT NULL,
                        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        likes VARCHAR(200),
                        shared TEXT NOT NULL,
                        saved TEXT NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table posts created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";

                     //CREATE COMMENTS TABLE
                     $sql = "CREATE TABLE comments(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        post_id INT(10) NOT NULL,
                        comment_from VARCHAR(30) NOT NULL,
                        body TEXT NOT NULL,     
                        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table comments created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";

                    //CREATE GROUPS TABLE
                     $sql = "CREATE TABLE groups(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        group_name VARCHAR(30) NOT NULL,
                        group_owner VARCHAR(30) NOT NULL,
                        requests TEXT NOT NULL,
                        requests_no INT(10) NOT NULL,     
                        members TEXT NOT NULL,
                        members_no INT(10) NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table groups created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";

                    //CREATE PAGES TABLE
                     $sql = "CREATE TABLE pages(
                        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        page_name VARCHAR(30) NOT NULL,
                        page_owner VARCHAR(30) NOT NULL,
                        admins TEXT NOT NULL,   
                        admins_no INT(10) NOT NULL,
                        followers TEXT NOT NULL,
                        followers_no INT(10) NOT NULL
                    )";
                    if ($conn->query($sql) === TRUE) echo "Table pages created successfully"."<br>";
                    else echo "Error creating Table: " . $conn->error."<br>";
















                    //CLOSE THE CONNECTION
                    $conn->close();
?>
    