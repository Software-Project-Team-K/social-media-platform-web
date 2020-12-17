<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");

                //aquire the target username
                $target_id = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],"/",1)+1);
                $target_id = substr($target_id,0,strlen($target_id)-1);
                //check if the target is the user
                if($_SESSION['user']->get_id() ==$target_id){
                    $_SESSION['style']="../assets/profile/main.css";
                    $_SESSION['target'] = $_SESSION['user'];
                }
                else{
                    $_SESSION['style']="../assets/profile/guest.css";
                    $_SESSION['target'] = new user($target_id);
                }

                
                echo '
                                <!DOCTYPE html>
                                <html>
        
                                <head>
                                    <link rel="stylesheet" href="'.$_SESSION["style"].'">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Silvaro | '.$_SESSION["target"]->get_name().'</title>
                                    <link rel="icon" href="../assets/img/icn_logo.png">
        
                                    <!--Navigation Bar-->
                                    <div id="nav">
                                        <a href="../"><img src="../assets/img/icn_logo.png" style="width: 50px; height: 95%; margin: 0 15px;"></a>
                                        <input type="text" style="width:20%; position: relative; left:5px; bottom:15px;">
                                        <div id="navbuttons">
                  
                                            <button><a href="../'.$_SESSION["user"]->get_id().'"><img src="../'.$_SESSION["user"]->get_id()."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                            <button><img src="../assets/img/icn_msg.png"></button>
                                            <button><img src="../assets/img/icn_notification.png"></button>
                                            <button><a href="../assets/operation/logout.php"><img src="../assets/img/icn_settings.png"></a></button>
                                        </div> 
                                    </div>
                                    <div style="height:45px; background-color: white;"></div>
        
                                </head>
        
                                <body>'
?>



        <div id="NCP">  
                <div id="cover">
                    <button id="coverBtn"><img src="../assets/img/icn_upload.png"></button>
                    <img src=<?php echo "../".$_SESSION["target"]->get_id()."/".$_SESSION['target']->get_cover_pic(); ?>>
                </div>
                <div id="PNB">
                    <div style="display: inline-block; margin: 0 5%;">
                        <img id="pp" src=<?php echo "../".$_SESSION["target"]->get_id()."/".$_SESSION['target']->get_profile_pic(); ?>>
                        <button id="ppBtn"><img src="../assets/img/icn_upload.png"></button>
                        <p><?php echo $_SESSION['target']->get_name(); ?></p>
                    </div>
                    <form id="buttons" method="GET" action="../assets/operation/friend_button.php">
                        <input  type="hidden" name = "target" value = "<?php echo $target_id ?>">
                        <?php
                        if($_SESSION["user"]->isFriend($target_id)) echo '<input type="submit" name="op" value="Unfriend">';
                        else if(($_SESSION["target"]->isFrRequest($_SESSION['user']->get_id()))) echo '<input type="submit" name="op" value="Accept"><input type="submit" name="op" value="Refuse">';
                        else if(!($_SESSION["user"]->isFrRequest($target_id))) echo '<input type="submit" name="op" value="Add Friend">';
                        else echo '<input type="submit" name="op" value="Cancel Request">';
                        ?>                    
                    </form>
                </div>
        </div>




        <div id="uploadPPBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="pp">
                    <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
                </form>
            </div>
        </div>

        <div id="uploadCoverBox" class="modal">
            <div class="modal-content">
            <span class="close">&times;</span>
                <form action="../assets/operation/upload.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="cover">
                    <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                    <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
                </form>
            </div>
        </div>



        <!-- User Details-->
        <div style="width:25%; margin: 20px 0 20px 2%; height: 1000px; border: 2px red solid; display:inline-block;">

        </div>

        <!-- Posts Section-->
        <div style="width:65%; margin: 20px 2%; height: 1000px; border: 2px black solid; display:inline-block;">

        </div>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>  //Cover and PP Buttons
                var ppBox = document.getElementById("uploadPPBox");
                var ppBtn = document.getElementById("ppBtn");
                var closePP = document.getElementsByClassName("close")[0];
                ppBtn.onclick = function() {
                ppBox.style.display = "block";
                }
                closePP.onclick = function() {
                ppBox.style.display = "none";
                }
                //
                var coverBox = document.getElementById("uploadCoverBox");
                var coverBtn = document.getElementById("coverBtn");
                var closeCover = document.getElementsByClassName("close")[1];
                coverBtn.onclick = function() {
                coverBox.style.display = "block";
                }
                closeCover.onclick = function() {
                coverBox.style.display = "none";
                }




        </script>
    </body>  
</html>
