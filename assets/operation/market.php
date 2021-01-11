<?php

            require '../classes.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['type']=="add_product") {
         
              $seller_id = $_SESSION['user']->get_id();
              $pic_name = basename($_FILES["fileToUpload"]["name"]);

              $target_dir = "../../".$seller_id."/market/";
              echo $target_dir;
              $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              
              // Check if image file is a actual image or fake image
              if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                  echo "File is an image - " . $check["mime"] . ".";
                  $uploadOk = 1;
                } else {
                  echo "File is not an image.";
                  $uploadOk = 0;
                }
              }
              
              // Check if file already exists
              if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
              }
              
              // Check file size
              if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
              }
              
              // Allow certain file formats
              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
              && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
              }
              
              // Check if $uploadOk is set to 0 by an error
              if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
              // if everything is ok, try to upload file
              } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } else {
                  echo "Sorry, there was an error uploading your file.";
                }
              }

              $myMarket = new marketplace($seller_id);
              $myMarket-> add_product($_POST['product_name'],$_POST['product_desc'],$pic_name);

          }

          else if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['type']=="remove_product"){
            $myMarket = new marketplace($_SESSION['user']->get_id());
            $myMarket->remove_product($_POST['id']);
          }
          else if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['type']=="notify"){
            $noti = new notification($_SESSION['user']->get_id());
            $noti->add_noti($_SESSION['target']->get_id(),"is interested in <u>".$_POST['name']."</u>");
          }
          header("Location: ../../$seller_id");    
?>