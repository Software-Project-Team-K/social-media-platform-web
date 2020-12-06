<?php


            require 'classes.php';
            session_start();


            $target_dir = $_SESSION['user']->id()."/";
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
            $target_file = $target_dir . "pp.".$imageFileType;

            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
              $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
              if($check == false) $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 50000000) {
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
            if ($uploadOk == 0)  echo "Sorry, your file was not uploaded.";

            // if everything is ok, try to upload file
            else {
              move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
              header("Location: $target_dir");
            }
    
?>